<?php

namespace App\Services;

use App\Models\BusinessAccount;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ServiceRequestService
{
    public function create(Service $service, BusinessAccount $requesterAccount, array $data)
    {
        if ($service->status !== 'approved') {
            throw new \Exception(__('service_request.service_not_available'));
        }
        if ($requesterAccount->id === $service->business_account_id) {
            throw new \Exception(__('service_request.cannot_request_own_service'));
        }
        if (isset($data['needed_time']) && now()->gte($data['needed_time'])) {
            throw new \Exception(__('service_request.needed_time_must_be_future'));
        }

        $existing = ServiceRequest::where('service_id', $service->id)
            ->where('requester_business_account_id', $requesterAccount->id)
            ->where('status', 'pending')
            ->exists();
        if ($existing) {
            throw new \Exception(__('service_request.already_requested'));
        }

        if ($service->isUnlimited()) {
            return ServiceRequest::create([
                'service_id'                    => $service->id,
                'requester_business_account_id' => $requesterAccount->id,
                'provider_business_account_id'  => $service->business_account_id,
                'needed_time'                   => $data['needed_time'] ?? null,
                'details'                       => $data['details'] ?? null,
                'quantity'                      => $data['quantity'] ?? 1,
                'status'                        => 'pending',
            ]);
        }

        DB::transaction(function () use ($service, $requesterAccount, $data, &$serviceRequest) {
            $locked = Service::where('id', $service->id)->lockForUpdate()->first();
            $available = $locked->quantity - $locked->reserved_quantity - $locked->pending_quantity;
            if ($data['quantity'] > $available) {
                throw new \Exception(__('service_request.insufficient_quantity', [
                    'available' => $available,
                    'requested' => $data['quantity']
                ]));
            }
            $serviceRequest = ServiceRequest::create([
                'service_id'                    => $locked->id,
                'requester_business_account_id' => $requesterAccount->id,
                'provider_business_account_id'  => $locked->business_account_id,
                'needed_time'                   => $data['needed_time'] ?? null,
                'details'                       => $data['details'] ?? null,
                'quantity'                      => $data['quantity'],
                'status'                        => 'pending',
            ]);
            $locked->increment('pending_quantity', $data['quantity']);
        });

        return $serviceRequest;
    }

    public function accept(ServiceRequest $request, BusinessAccount $providerAccount): ServiceRequest
    {
        $this->authorizeProvider($request, $providerAccount);
        if (!$request->isPending()) {
            throw new \Exception(__('service_request.not_pending'));
        }

        $service = $request->service;
        if ($service->status !== 'approved') {
            throw new \Exception(__('service_request.service_not_available'));
        }

        if ($service->isUnlimited()) {
            $request->update(['status' => 'accepted']);
            return $request->fresh();
        }

        DB::transaction(function () use ($request) {
            $locked = Service::where('id', $request->service_id)->lockForUpdate()->first();
            $available = $locked->quantity - $locked->reserved_quantity;
            if ($request->quantity > $available) {
                throw new \Exception(__('service_request.insufficient_quantity', [
                    'available' => $available,
                    'requested' => $request->quantity
                ]));
            }
            $locked->decrement('pending_quantity', $request->quantity);
            $locked->increment('reserved_quantity', $request->quantity);
            $request->update(['status' => 'accepted']);
        });

        return $request->fresh();
    }

    public function reject(ServiceRequest $request, BusinessAccount $providerAccount): ServiceRequest
    {
        $this->authorizeProvider($request, $providerAccount);
        if (!$request->isPending()) {
            throw new \Exception(__('service_request.not_pending'));
        }

        $service = $request->service;
        if ($service->isUnlimited()) {
            $request->update(['status' => 'rejected']);
            return $request;
        }

        DB::transaction(function () use ($request) {
            $locked = Service::where('id', $request->service_id)->lockForUpdate()->first();
            $locked->decrement('pending_quantity', $request->quantity);
            $request->update(['status' => 'rejected']);
        });

        return $request;
    }

    public function delete(ServiceRequest $request, BusinessAccount $requesterAccount): void
    {
        $this->authorizeRequester($request, $requesterAccount);
        if (!$request->isPending()) {
            throw new \Exception(__('service_request.cannot_delete_non_pending'));
        }

        $service = $request->service;
        if ($service->isUnlimited()) {
            $request->delete();
            return;
        }

        DB::transaction(function () use ($request) {
            $locked = Service::where('id', $request->service_id)->lockForUpdate()->first();
            $locked->decrement('pending_quantity', $request->quantity);
            $request->delete();
        });
    }

    public function cancel(ServiceRequest $request, BusinessAccount $account): void
    {
        if ($request->provider_business_account_id !== $account->id && $request->requester_business_account_id !== $account->id) {
            throw new \Exception(__('auth.forbidden'), 403);
        }
        if (!$request->isAccepted()) {
            throw new \Exception(__('service_request.cannot_cancel_non_accepted'));
        }

        $service = $request->service;
        if ($service->isUnlimited()) {
            $request->update(['status' => 'cancelled']);
            return;
        }

        DB::transaction(function () use ($request) {
            $locked = Service::where('id', $request->service_id)->lockForUpdate()->first();
            $locked->decrement('reserved_quantity', $request->quantity);
            $request->update(['status' => 'cancelled']);
        });
    }

    public function getUserRequests(User $user, ?string $type = null, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $businessIds = $user->businessAccounts()->pluck('id')->toArray();
        $query = ServiceRequest::query()
            ->with(['service', 'requesterAccount', 'providerAccount', 'rating']);

        if ($type === 'received') {
            $query->whereIn('provider_business_account_id', $businessIds);
        } elseif ($type === 'sent') {
            $query->whereIn('requester_business_account_id', $businessIds);
        } else {
            $query->where(function ($q) use ($businessIds) {
                $q->whereIn('provider_business_account_id', $businessIds)
                  ->orWhereIn('requester_business_account_id', $businessIds);
            });
        }

        if ($status && in_array($status, ['pending', 'accepted', 'rejected', 'cancelled'])) {
            $query->where('status', $status);
        }

        return $query->latest()->paginate($perPage);
    }

    private function authorizeProvider(ServiceRequest $request, BusinessAccount $providerAccount): void
    {
        if ($request->provider_business_account_id !== $providerAccount->id) {
            throw new \Exception(__('auth.forbidden'), 403);
        }
    }

    private function authorizeRequester(ServiceRequest $request, BusinessAccount $requesterAccount): void
    {
        if ($request->requester_business_account_id !== $requesterAccount->id) {
            throw new \Exception(__('auth.forbidden'), 403);
        }
    }
}
