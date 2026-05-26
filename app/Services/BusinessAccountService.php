<?php

namespace App\Services;

use App\Models\BusinessAccount;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BusinessAccountService
{
    public function create(User $user, array $data): BusinessAccount
    {
        $exists = BusinessAccount::where('user_id', $user->id)
            ->where('activity_type_id', $data['activity_type_id'])
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'activity_type_id' => __('business.account_already_exists_for_activity_type'),
            ]);
        }

        return BusinessAccount::create([
            'user_id'          => $user->id,
            'activity_type_id' => $data['activity_type_id'],
            'city_id'          => $data['city_id'],
            'business_name'    => [
                'ar' => $data['business_name_ar'],
                'en' => $data['business_name_en'],
            ],
            'license_number'   => $data['license_number'] ?? null,
            'lat'              => $data['lat'] ?? null,
            'lng'              => $data['lng'] ?? null,
            'activities'       => $data['activities'] ?? null,
            'details'          => $data['details'] ?? null,
            'status'           => 'pending',
            'submitted_at'     => now(),
            'is_active'        => false,
        ]);
    }

    public function update(BusinessAccount $account, array $data): BusinessAccount
    {
        if ($account->status === 'suspended') {
            throw new \Exception(__('business.cannot_edit_suspended'));
        }

        $wasApproved = ($account->status === 'approved');
        $wasRejected = ($account->status === 'rejected');

        DB::beginTransaction();
        try {
            $updateData = [];

            if (isset($data['activity_type_id'])) {
                $updateData['activity_type_id'] = $data['activity_type_id'];
            }
            if (isset($data['city_id'])) {
                $updateData['city_id'] = $data['city_id'];
            }
            if (isset($data['business_name_ar']) || isset($data['business_name_en'])) {
                $updateData['business_name'] = [
                    'ar' => $data['business_name_ar'] ?? $account->getTranslation('business_name', 'ar'),
                    'en' => $data['business_name_en'] ?? $account->getTranslation('business_name', 'en'),
                ];
            }
            if (array_key_exists('license_number', $data)) {
                $updateData['license_number'] = $data['license_number'];
            }
            if (array_key_exists('lat', $data)) {
                $updateData['lat'] = $data['lat'];
            }
            if (array_key_exists('lng', $data)) {
                $updateData['lng'] = $data['lng'];
            }
            if (array_key_exists('activities', $data)) {
                $updateData['activities'] = $data['activities'];
            }
            if (array_key_exists('details', $data)) {
                $updateData['details'] = $data['details'];
            }

            if (in_array($account->status, ['approved', 'rejected'])) {
                $updateData['status']       = 'pending';
                $updateData['submitted_at'] = now();
                $updateData['reviewed_at']  = null;
                $updateData['reviewed_by']  = null;
            }

            $account->update($updateData);

            if ($wasApproved) {
                Service::where('business_account_id', $account->id)
                    ->where('status', 'approved')
                    ->update([
                        'status'      => 'suspended',
                        'reviewed_at' => now(),
                        'reviewed_by' => null,
                    ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $account->fresh();
    }

    public function delete(BusinessAccount $account): void
    {
        $hasActiveServices = Service::where('business_account_id', $account->id)
            ->whereIn('status', ['approved', 'suspended'])
            ->exists();

        if ($hasActiveServices) {
            throw new \Exception(__('business.cannot_delete_has_active_services'));
        }

        $hasAcceptedRequests = ServiceRequest::where('provider_business_account_id', $account->id)
            ->where('status', 'accepted')
            ->exists();

        if ($hasAcceptedRequests) {
            throw new \Exception(__('business.cannot_delete_has_accepted_requests'));
        }

        $account->delete();
    }


    public function approve(BusinessAccount $account, int $adminId): BusinessAccount
    {
        if ($account->status !== 'pending') {
            throw new \Exception(__('business.cannot_approve'));
        }

        DB::transaction(function () use ($account, $adminId) {
            Service::where('business_account_id', $account->id)
                ->where('status', 'suspended')
                ->update([
                    'status'      => 'approved',
                    'reviewed_at' => now(),
                    'reviewed_by' => $adminId,
                ]);

            $account->update([
                'status'      => 'approved',
                'reviewed_at' => now(),
                'reviewed_by' => $adminId,
            ]);
        });

        return $account->fresh();
    }


    public function reject(BusinessAccount $account, int $adminId): BusinessAccount
    {
        if ($account->status !== 'pending') {
            throw new \Exception(__('business.cannot_reject_non_pending'));
        }

        DB::transaction(function () use ($account, $adminId) {
            Service::where('business_account_id', $account->id)
                ->where('status', 'suspended')
                ->update([
                    'status'      => 'rejected',
                    'reviewed_at' => now(),
                    'reviewed_by' => $adminId,
                ]);

            $account->update([
                'status'      => 'rejected',
                'reviewed_at' => now(),
                'reviewed_by' => $adminId,
            ]);
        });

        return $account->fresh();
    }


    public function suspend(BusinessAccount $account, int $adminId): BusinessAccount
    {
        if ($account->status !== 'approved') {
            throw new \Exception(__('business.cannot_suspend_not_approved'));
        }

        DB::transaction(function () use ($account, $adminId) {
            Service::where('business_account_id', $account->id)
                ->where('status', 'approved')
                ->update([
                    'status'      => 'suspended',
                    'reviewed_at' => now(),
                    'reviewed_by' => $adminId,
                ]);

            ServiceRequest::whereIn('service_id', function ($query) use ($account) {
                $query->select('id')
                    ->from('services')
                    ->where('business_account_id', $account->id);
            })->where('status', 'pending')->update(['status' => 'rejected']);

            $account->update([
                'status'      => 'suspended',
                'reviewed_at' => now(),
                'reviewed_by' => $adminId,
            ]);
        });

        return $account->fresh();
    }


    public function reactivate(BusinessAccount $account, int $adminId): BusinessAccount
    {
        if ($account->status !== 'suspended') {
            throw new \Exception(__('business.cannot_reactivate_not_suspended'));
        }

        DB::transaction(function () use ($account, $adminId) {
            Service::where('business_account_id', $account->id)
                ->where('status', 'suspended')
                ->update([
                    'status'      => 'approved',
                    'reviewed_at' => now(),
                    'reviewed_by' => $adminId,
                ]);

            $account->update([
                'status'      => 'approved',
                'reviewed_at' => now(),
                'reviewed_by' => $adminId,
            ]);
        });

        return $account->fresh();
    }

    public function getForUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $user->businessAccounts()
            ->with(['activityType', 'city'])
            ->latest()
            ->paginate($perPage);
    }

    public function searchAndPaginate(?string $search = null, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = BusinessAccount::query()
            ->with(['user', 'activityType', 'city', 'reviewer']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                })->orWhere('business_name->ar', 'like', "%{$search}%")
                ->orWhere('business_name->en', 'like', "%{$search}%");
            });
        }

        return $query
            ->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends(['search' => $search, 'status' => $status]);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return BusinessAccount::orderBy('id', 'desc')->get();
    }


public function handleMedia(BusinessAccount $account, array $data): void
{
    if (!empty($data['delete_image_ids'])) {
        $account->media()
            ->whereIn('id', $data['delete_image_ids'])
            ->where('collection_name', 'images')
            ->get()
            ->each->delete();
    }

    if (!empty($data['images'])) {
        foreach ($data['images'] as $image) {
            $account->addMedia($image)->toMediaCollection('images');
        }
    }

    if (!empty($data['delete_document_ids'])) {
        $account->media()
            ->whereIn('id', $data['delete_document_ids'])
            ->where('collection_name', 'documents')
            ->get()
            ->each->delete();
    }

    if (!empty($data['documents'])) {
        foreach ($data['documents'] as $document) {
            $account->addMedia($document)->toMediaCollection('documents');
        }
    }
}
}
