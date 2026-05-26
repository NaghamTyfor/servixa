<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBusinessAccountRequest;
use App\Http\Requests\Api\UpdateBusinessAccountRequest;
use App\Http\Resources\BusinessAccountResource;
use App\Models\BusinessAccount;
use App\Services\BusinessAccountService;
use Illuminate\Http\JsonResponse;

class BusinessAccountController extends Controller
{
    public function __construct(
        private readonly BusinessAccountService $service
    ) {}

public function index(): JsonResponse
{
    $accounts = $this->service->getForUser(auth('api')->user());

    return BusinessAccountResource::collection($accounts)
        ->additional(['message' => __('business.list_retrieved')])
        ->response();
}

    public function show(BusinessAccount $businessAccount): JsonResponse
    {
        $this->authorizeOwner($businessAccount);

        $businessAccount->load([
            'activityType',
            'city',
            'media' => fn($q) => $q->whereIn('collection_name', ['images', 'documents']),
        ]);

        return response()->json([
            'message' => __('business.retrieved'),
            'data'    => BusinessAccountResource::make($businessAccount),
        ]);
    }

    public function store(StoreBusinessAccountRequest $request): JsonResponse
    {
        $account = $this->service->create(auth('api')->user(), $request->validated());

        if ($request->hasFile('images') || $request->hasFile('documents')) {
            $this->service->handleMedia($account, $request->only('images', 'documents'));
        }

        $account->load(['activityType', 'city']);

        return response()->json([
            'message' => __('business.created'),
            'data'    => BusinessAccountResource::make($account),
        ], 201);
    }

    public function update(UpdateBusinessAccountRequest $request, BusinessAccount $businessAccount): JsonResponse
    {
        $this->authorizeOwner($businessAccount);

        if ($businessAccount->status === 'suspended') {
            return response()->json(['message' => __('business.cannot_edit_suspended')], 422);
        }

        $previousStatus = $businessAccount->status;

        try {
            $account = $this->service->update($businessAccount, $request->validated());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        // ✅ تمرير كل بيانات الطلب بما فيها replace/delete flags
        $mediaData = $request->only([
            'images', 'documents',
            'replace_images', 'replace_documents',
            'delete_images', 'delete_documents',
        ]);

        $hasMediaAction = $request->hasFile('images')
            || $request->hasFile('documents')
            || $request->boolean('delete_images')
            || $request->boolean('delete_documents');

        if ($hasMediaAction) {
            $this->service->handleMedia($account, $mediaData);
        }

        $message = __('business.updated');
        if (in_array($previousStatus, ['approved', 'rejected']) && $account->status === 'pending') {
            $message = __('business.resubmitted_for_review');
        }

        $account->load(['activityType', 'city']);

        return response()->json([
            'message' => $message,
            'data'    => BusinessAccountResource::make($account),
        ]);
    }

    public function destroy(BusinessAccount $businessAccount): JsonResponse
    {
        $this->authorizeOwner($businessAccount);

        try {
            $this->service->delete($businessAccount);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => __('business.deleted')]);
    }

    private function authorizeOwner(BusinessAccount $account): void
    {
        if ($account->user_id !== auth('api')->id()) {
            abort(403, __('auth.forbidden'));
        }
    }
}
