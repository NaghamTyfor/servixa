<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreServiceRequestRequest;
use App\Http\Resources\ServiceRequestResource;
use App\Models\BusinessAccount;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Services\ServiceRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ServiceRequestController extends Controller
{
    public function __construct(
        private readonly ServiceRequestService $service
    ) {}

    public function store(StoreServiceRequestRequest $request, Service $service): JsonResponse
    {
        $account = BusinessAccount::findOrFail($request->business_account_id);
        abort_if($account->user_id !== auth('api')->id(), 403, __('auth.forbidden'));
        abort_if($account->status !== 'approved', 403, __('business.not_approved'));

        $serviceRequest = $this->service->create($service, $account, $request->validated());
        $serviceRequest->load(['service', 'requesterAccount', 'providerAccount', 'rating']);

        return response()->json([
            'message' => __('service_request.created'),
            'data'    => ServiceRequestResource::make($serviceRequest),
        ], 201);
    }


    public function myRequests(Request $request): JsonResponse
    {
        $user   = auth('api')->user();
        $type   = $request->input('type');   // 'received', 'sent', أو null
        $status = $request->input('status');

        $requests = $this->service->getUserRequests($user, $type, $status);

        return ServiceRequestResource::collection($requests)
            ->additional(['message' => __('service_request.list_retrieved')])
            ->response();
    }

    public function accept(Request $request, ServiceRequest $serviceRequest): JsonResponse
    {
        $providerAccount = $this->getProviderAccount($serviceRequest);
        if (!$providerAccount) {
            return response()->json(['message' => __('auth.forbidden')], 403);
        }

        try {
            $updated = $this->service->accept($serviceRequest, $providerAccount);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => __('service_request.accepted'),
            'data'    => ServiceRequestResource::make($updated->load($this->baseRelations())),
        ]);
    }


    public function reject(Request $request, ServiceRequest $serviceRequest): JsonResponse
    {
        $providerAccount = $this->getProviderAccount($serviceRequest);
        if (!$providerAccount) {
            return response()->json(['message' => __('auth.forbidden')], 403);
        }

        try {
            $updated = $this->service->reject($serviceRequest, $providerAccount);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => __('service_request.rejected'),
            'data'    => ServiceRequestResource::make($updated->load($this->baseRelations())),
        ]);
    }


    public function destroy(ServiceRequest $serviceRequest): JsonResponse
    {
        $requesterAccount = $this->getRequesterAccount($serviceRequest);
        if (!$requesterAccount) {
            return response()->json(['message' => __('auth.forbidden')], 403);
        }

        try {
            $this->service->delete($serviceRequest, $requesterAccount);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => __('service_request.deleted')]);
    }


    public function cancel(Request $request, ServiceRequest $serviceRequest): JsonResponse
    {
        $user       = auth('api')->user();
        $accountIds = $user->businessAccounts()->pluck('id')->toArray();

        $account = null;
        if (in_array($serviceRequest->provider_business_account_id, $accountIds)) {
            $account = BusinessAccount::find($serviceRequest->provider_business_account_id);
        } elseif (in_array($serviceRequest->requester_business_account_id, $accountIds)) {
            $account = BusinessAccount::find($serviceRequest->requester_business_account_id);
        }

        if (!$account) {
            return response()->json(['message' => __('auth.forbidden')], 403);
        }

        try {
            $this->service->cancel($serviceRequest, $account);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => __('service_request.cancelled')]);
    }


    private function baseRelations(): array
    {
        return [
            'service',
            'requesterAccount',
            'providerAccount',
            'rating',
        ];
    }

    private function getProviderAccount(ServiceRequest $serviceRequest): ?BusinessAccount
    {
        $user           = auth('api')->user();
        $userAccountIds = $user->businessAccounts()->pluck('id')->toArray();

        if (!in_array($serviceRequest->provider_business_account_id, $userAccountIds)) {
            return null;
        }

        return BusinessAccount::find($serviceRequest->provider_business_account_id);
    }

    private function getRequesterAccount(ServiceRequest $serviceRequest): ?BusinessAccount
    {
        $user           = auth('api')->user();
        $userAccountIds = $user->businessAccounts()->pluck('id')->toArray();

        if (!in_array($serviceRequest->requester_business_account_id, $userAccountIds)) {
            return null;
        }

        return BusinessAccount::find($serviceRequest->requester_business_account_id);
    }
}
