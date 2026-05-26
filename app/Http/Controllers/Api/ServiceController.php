<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreServiceRequest;
use App\Http\Requests\Api\UpdateServiceRequest;
use App\Http\Resources\DynamicFieldResource;
use App\Http\Resources\ServiceResource;
use App\Models\BusinessAccount;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        private readonly ServiceService $service
    ) {}

public function index(Request $request): \Illuminate\Http\JsonResponse
{
    $services = $this->service->filterPaginate($request);
    return ServiceResource::collection($services)
        ->additional(['message' => __('service.list_retrieved')])
        ->response();
}

    public function store(StoreServiceRequest $request): JsonResponse
    {
        $account = BusinessAccount::findOrFail($request->business_account_id);
        abort_if($account->user_id !== auth('api')->id(), 403, __('auth.forbidden'));
        abort_if($account->status !== 'approved', 403, __('business.not_approved'));

        try {
            $svc = $this->service->create($account, $request->validated());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => __('service.created'),
            'data'    => ServiceResource::make(
        $svc->load(['category', 'subCategory', 'dynamicFieldValues.dynamicField', 'businessAccount'])            ),
        ], 201);
    }

    public function show(Service $service): JsonResponse
    {
        abort_if($service->status !== 'approved', 404);

        $service->load([
            'businessAccount.user',
            'category',
            'subCategory',
            'dynamicFieldValues.dynamicField',
            'media',
        ]);

        return response()->json([
            'message' => __('service.retrieved'),
            'data'    => ServiceResource::make($service),
        ]);
    }

    public function update(UpdateServiceRequest $request, Service $service): JsonResponse
    {
        abort_if($service->businessAccount->user_id !== auth('api')->id(), 403, __('auth.forbidden'));

        if ($service->status === 'suspended') {
            return response()->json(['message' => __('service.cannot_edit_suspended')], 422);
        }

        $previousStatus = $service->status;

        try {
            $svc = $this->service->update($service, $request->validated());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $message = __('service.updated');
        if (in_array($previousStatus, ['approved', 'rejected']) && $svc->status === 'pending') {
            $message = __('service.resubmitted_for_review');
        }

        return response()->json([
            'message' => $message,
            'data'    => ServiceResource::make(
                $svc->load(['category', 'subCategory', 'dynamicFieldValues.dynamicField'])
            ),
        ]);
    }

    public function destroy(Service $service): JsonResponse
    {
        abort_if($service->businessAccount->user_id !== auth('api')->id(), 403, __('auth.forbidden'));

        try {
            $this->service->delete($service);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['message' => __('service.deleted')]);
    }

public function myServices(Request $request): JsonResponse
{
    $user   = auth('api')->user();
    $status = $request->input('status');
    $perPage = (int) $request->input('per_page', 15);

    $services = $this->service->getUserServicesPaginated($user, $status, $perPage);

    return ServiceResource::collection($services)
        ->additional(['message' => __('service.list_retrieved')])
        ->response();
}

public function dynamicFields(Request $request): JsonResponse
{
    $categoryId = $request->integer('category_id');
    $subCategoryId = $request->integer('sub_category_id');

    if ($subCategoryId) {
        $subCategory = \App\Models\SubCategory::find($subCategoryId);
        if (!$subCategory) {
            return response()->json(['message' => __('validation.exists', ['attribute' => 'sub_category_id'])], 422);
        }
        $categoryId = $subCategory->category_id;
    }
    elseif ($categoryId) {
        $category = \App\Models\Category::find($categoryId);
        if (!$category) {
            return response()->json(['message' => __('validation.exists', ['attribute' => 'category_id'])], 422);
        }
        $hasSubCategories = \App\Models\SubCategory::where('category_id', $categoryId)->exists();
        if ($hasSubCategories) {
            return response()->json([
                'message' => __('validation.sub_category_required_when_parent_has_children')
            ], 422);
        }
    }
    else {
        return response()->json([
            'message' => __('validation.required_without', ['attribute' => 'category_id', 'values' => 'sub_category_id'])
        ], 422);
    }

    $fields = $this->service->getDynamicFields($categoryId, $subCategoryId);

    return response()->json([
        'data' => DynamicFieldResource::collection($fields),
    ]);
}
}
