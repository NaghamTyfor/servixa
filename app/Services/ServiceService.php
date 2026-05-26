<?php

namespace App\Services;

use App\Models\BusinessAccount;
use App\Models\Category;
use App\Models\DynamicField;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ServiceService
{
    public function create(BusinessAccount $account, array $data): Service
    {
        DB::beginTransaction();
        try {
            $isUnlimited = ($data['quantity'] === null);

            $service = Service::create([
                'business_account_id' => $account->id,
                'category_id'         => $data['category_id'],
                'sub_category_id'     => $data['sub_category_id'] ?? null,
                'title'               => ['ar' => $data['title_ar'], 'en' => $data['title_en']],
                'description'         => ['ar' => $data['description_ar'], 'en' => $data['description_en']],
                'quantity'            => $data['quantity'],
                'reserved_quantity'   => 0,
                'pending_quantity'    => 0,
                'service_type'        => $data['service_type'],
                'price_syp'           => $data['price_syp'] ?? null,
                'price_usd'           => $data['price_usd'] ?? null,
                'lat'                 => $data['lat'] ?? null,
                'lng'                 => $data['lng'] ?? null,
                'status'              => 'pending',
                'submitted_at'        => now(),
            ]);

            $this->handleDynamicFields($service, $data['dynamic_fields'] ?? []);
            $this->handleImages($service, $data);

            DB::commit();
            return $service;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Service $service, array $data): Service
    {
        if ($service->status === 'suspended') {
            throw new \Exception(__('service.cannot_edit_suspended'));
        }

        if (array_key_exists('quantity', $data) && !$service->isUnlimited() && $data['quantity'] !== null) {
            if ($data['quantity'] < $service->reserved_quantity) {
                throw new \Exception(__('service.quantity_below_reserved', ['reserved' => $service->reserved_quantity]));
            }
        }

        if (isset($data['quantity']) && $data['quantity'] === null && !$service->isUnlimited()) {
            if ($service->reserved_quantity > 0 || $service->pending_quantity > 0) {
                throw new \Exception(__('service.cannot_make_unlimited_with_requests'));
            }
        }

        DB::beginTransaction();
        try {
            $updateData = [];

            if (isset($data['category_id'])) $updateData['category_id'] = $data['category_id'];
            if (isset($data['sub_category_id'])) $updateData['sub_category_id'] = $data['sub_category_id'];

            if (isset($data['title_ar']) || isset($data['title_en'])) {
                $updateData['title'] = [
                    'ar' => $data['title_ar'] ?? $service->getTranslation('title', 'ar'),
                    'en' => $data['title_en'] ?? $service->getTranslation('title', 'en'),
                ];
            }
            if (isset($data['description_ar']) || isset($data['description_en'])) {
                $updateData['description'] = [
                    'ar' => $data['description_ar'] ?? $service->getTranslation('description', 'ar'),
                    'en' => $data['description_en'] ?? $service->getTranslation('description', 'en'),
                ];
            }

            foreach (['quantity', 'service_type', 'lat', 'lng', 'price_syp', 'price_usd'] as $field) {
                if (array_key_exists($field, $data)) {
                    $updateData[$field] = $data[$field];
                }
            }

            if (isset($data['quantity']) && $data['quantity'] === null && !$service->isUnlimited()) {
                $updateData['reserved_quantity'] = 0;
                $updateData['pending_quantity'] = 0;
            }

            if (in_array($service->status, ['approved', 'rejected'])) {
                $updateData['status'] = 'pending';
                $updateData['submitted_at'] = now();
                $updateData['reviewed_at'] = null;
                $updateData['reviewed_by'] = null;
            }

            $service->update($updateData);

            if (isset($data['dynamic_fields'])) {
                $this->syncDynamicFields($service, $data['dynamic_fields']);
            }

            $this->handleImages($service, $data, true);

            DB::commit();
            return $service->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Service $service): void
    {
        $hasRequests = ServiceRequest::where('service_id', $service->id)->exists();
        if ($hasRequests) {
            throw new \Exception(__('service.cannot_delete_with_requests'));
        }
        DB::transaction(function () use ($service) {
            $service->dynamicFieldValues()->delete();
            $service->delete();
        });
    }

    public function approve(Service $service, int $adminId): Service
    {
        if ($service->status !== 'pending') {
            throw new \Exception(__('service.cannot_approve_non_pending'));
        }
        $service->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $adminId,
        ]);
        return $service;
    }

    public function reject(Service $service, int $adminId): Service
    {
        if ($service->status !== 'pending') {
            throw new \Exception(__('service.cannot_reject_non_pending'));
        }
        $service->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => $adminId,
        ]);
        return $service;
    }

    public function suspend(Service $service, int $adminId): Service
    {
        if ($service->status !== 'approved') {
            throw new \Exception(__('service.cannot_suspend_not_approved'));
        }

        DB::transaction(function () use ($service, $adminId) {
            ServiceRequest::where('service_id', $service->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);

            $service->update([
                'pending_quantity' => 0,
                'status' => 'suspended',
                'reviewed_at' => now(),
                'reviewed_by' => $adminId,
            ]);
        });
        return $service->fresh();
    }

    public function reactivate(Service $service, int $adminId): Service
    {
        if ($service->status !== 'suspended') {
            throw new \Exception(__('service.cannot_reactivate_not_suspended'));
        }
        if (!$service->isUnlimited() && $service->reserved_quantity > $service->quantity) {
            throw new \Exception(__('service.cannot_reactivate_quantity_exceeded', [
                'reserved' => $service->reserved_quantity,
                'available' => $service->quantity,
            ]));
        }
        $service->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $adminId,
        ]);
        return $service->fresh();
    }

    public function getApprovedServices(): Collection
    {
        return Service::approved()
            ->with(['businessAccount', 'category', 'subCategory', 'dynamicFieldValues.dynamicField', 'media'])
            ->latest()
            ->get();
    }

    public function getForUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        $ids = $user->businessAccounts()->pluck('id');
        return Service::whereIn('business_account_id', $ids)
            ->with(['category', 'subCategory', 'dynamicFieldValues.dynamicField'])
            ->latest()
            ->paginate($perPage);
    }

    public function getDynamicFields(int $categoryId, ?int $subCategoryId): Collection
    {
        $fields = collect();
        $category = Category::find($categoryId);
        if ($category) $fields = $fields->merge($category->dynamicFields);
        if ($subCategoryId) {
            $subCategory = SubCategory::find($subCategoryId);
            if ($subCategory) $fields = $fields->merge($subCategory->dynamicFields);
        }
        return $fields->unique('id');
    }

    public function searchAndPaginate(?string $search = null, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Service::query()->with(['businessAccount', 'businessAccount.user', 'category', 'subCategory', 'reviewer', 'media']);
        if ($status && in_array($status, ['pending', 'approved', 'rejected', 'suspended'])) {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('businessAccount', fn($q2) => $q2->where('business_name->ar', 'like', "%{$search}%")->orWhere('business_name->en', 'like', "%{$search}%"));
                $q->orWhereHas('businessAccount.user', fn($q2) => $q2->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->orWhere('phone', 'like', "%{$search}%"));
                $q->orWhere('title->ar', 'like', "%{$search}%")->orWhere('title->en', 'like', "%{$search}%");
                $q->orWhere('description->ar', 'like', "%{$search}%")->orWhere('description->en', 'like', "%{$search}%");
            });
        }
        return $query->orderBy('id', 'asc')->paginate($perPage)->appends(array_filter(['search' => $search, 'status' => $status]));
    }

    public function filterPaginate(Request $request): LengthAwarePaginator
    {
        $query = Service::query()
            ->with(['businessAccount', 'businessAccount.user', 'category', 'subCategory', 'dynamicFieldValues.dynamicField', 'media'])
            ->where('status', 'approved');

        if ($request->filled('category_id')) $query->where('category_id', $request->category_id);
        if ($request->filled('sub_category_id')) $query->where('sub_category_id', $request->sub_category_id);
        if ($request->filled('service_type')) $query->where('service_type', $request->service_type);
        if ($request->filled('min_price_syp')) $query->where('price_syp', '>=', $request->min_price_syp);
        if ($request->filled('max_price_syp')) $query->where('price_syp', '<=', $request->max_price_syp);
        if ($request->filled('min_price_usd')) $query->where('price_usd', '>=', $request->min_price_usd);
        if ($request->filled('max_price_usd')) $query->where('price_usd', '<=', $request->max_price_usd);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title->ar', 'like', "%{$search}%")->orWhere('title->en', 'like', "%{$search}%")
                  ->orWhere('description->ar', 'like', "%{$search}%")->orWhere('description->en', 'like', "%{$search}%")
                  ->orWhereHas('businessAccount', fn($q2) => $q2->where('business_name->ar', 'like', "%{$search}%")->orWhere('business_name->en', 'like', "%{$search}%"))
                  ->orWhereHas('businessAccount.user', fn($q2) => $q2->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->orWhere('phone', 'like', "%{$search}%"));
            });
        }
        if ($request->filled('latitude') && $request->filled('longitude') && $request->filled('radius')) {
            $lat = (float) $request->latitude;
            $lng = (float) $request->longitude;
            $radius = (float) $request->radius;
            $query->whereRaw("(6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) <= ?", [$lat, $lng, $lat, $radius]);
        }
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        if (in_array($sortBy, ['created_at', 'price_syp', 'price_usd', 'quantity', 'title'])) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }
        return $query->paginate((int) $request->input('per_page', 15));
    }

    public function getUserServicesPaginated(User $user, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $ids = $user->businessAccounts()->pluck('id');
        $query = Service::whereIn('business_account_id', $ids)
            ->with(['category', 'subCategory', 'dynamicFieldValues.dynamicField', 'reviewer']);
        if ($status && in_array($status, ['pending', 'approved', 'rejected', 'suspended'])) {
            $query->where('status', $status);
        }
        return $query->latest()->paginate($perPage);
    }

    private function handleDynamicFields(Service $service, array $fields): void
    {
        if (empty($fields)) return;
        $this->validateRequiredDynamicFields($service, $fields);
        $this->validateDynamicFieldValues($service, $fields);
        $this->validateDynamicFieldBelongsToService($service, $fields);
        $this->attachDynamicFields($service, $fields);
    }

    private function attachDynamicFields(Service $service, array $fields): void
    {
        foreach ($fields as $field) {
            $df = DynamicField::findOrFail($field['dynamic_field_id']);
            $value = $this->processFieldValue($df, $field['value']);
            $service->dynamicFieldValues()->updateOrCreate(
                ['dynamic_field_id' => $df->id],
                ['value' => $value]
            );
        }
    }

    private function syncDynamicFields(Service $service, array $fields): void
    {
        $submittedIds = collect($fields)->pluck('dynamic_field_id')->toArray();
        $service->dynamicFieldValues()->whereNotIn('dynamic_field_id', $submittedIds)->delete();
        foreach ($fields as $field) {
            $df = DynamicField::findOrFail($field['dynamic_field_id']);
            $value = $this->processFieldValue($df, $field['value']);
            $service->dynamicFieldValues()->updateOrCreate(
                ['dynamic_field_id' => $df->id],
                ['value' => $value]
            );
        }
    }

    private function processFieldValue(DynamicField $field, $value): ?string
    {
        if ($value === null || $value === '') return null;
        switch ($field->type) {
            case 'number':
                return is_numeric($value) ? (string) $value : null;
            case 'select':
                if ($field->hasOptions() && !$field->isValidOptionValue($value)) {
                    throw new \Exception(__('dynamic_field.invalid_value') . ': ' . $field->getTranslation('name', app()->getLocale()));
                }
                return $value;
            default:
                return (string) $value;
        }
    }

    private function validateDynamicFieldBelongsToService(Service $service, array $fields): void
    {
        foreach ($fields as $field) {
            $df = DynamicField::find($field['dynamic_field_id'] ?? null);
            if (!$df) throw new \Exception(__('dynamic_field.not_found'));
            $valid = ($df->dynamic_fieldable_type === Category::class && $df->dynamic_fieldable_id == $service->category_id);
            if (!$valid && $service->sub_category_id && $df->dynamic_fieldable_type === SubCategory::class && $df->dynamic_fieldable_id == $service->sub_category_id) {
                $valid = true;
            }
            if (!$valid) {
                throw new \Exception(__('dynamic_field.not_belong_to_service', ['field' => $df->getTranslation('name', app()->getLocale())]));
            }
        }
    }

    private function validateRequiredDynamicFields(Service $service, array $submittedFields): void
    {
        $required = DynamicField::where(function ($query) use ($service) {
            $query->where('dynamic_fieldable_type', Category::class)->where('dynamic_fieldable_id', $service->category_id);
            if ($service->sub_category_id) {
                $query->orWhere('dynamic_fieldable_type', SubCategory::class)->where('dynamic_fieldable_id', $service->sub_category_id);
            }
        })->where('is_required', true)->get();

        $submittedIds = collect($submittedFields)->pluck('dynamic_field_id')->toArray();
        $missing = $required->filter(fn($f) => !in_array($f->id, $submittedIds));
        if ($missing->isNotEmpty()) {
            $names = $missing->map(fn($f) => $f->getTranslation('name', app()->getLocale()))->implode(', ');
            throw new \Exception(__('service.missing_required_fields', ['fields' => $names]));
        }
    }

    private function validateDynamicFieldValues(Service $service, array $fields): void
    {
        foreach ($fields as $field) {
            $df = DynamicField::find($field['dynamic_field_id'] ?? null);
            if (!$df) throw new \Exception(__('dynamic_field.invalid_value'));
            if ($df->is_required && empty($field['value']) && $field['value'] !== '0') {
                throw new \Exception(__('service.field_required', ['field' => $df->getTranslation('name', app()->getLocale())]));
            }
            if (!empty($field['value'])) {
                if ($df->type === 'select' && $df->hasOptions() && !$df->isValidOptionValue($field['value'])) {
                    throw new \Exception(__('service.invalid_option', ['field' => $df->getTranslation('name', app()->getLocale())]));
                }
                if ($df->type === 'number' && !is_numeric($field['value'])) {
                    throw new \Exception(__('validation.numeric', ['attribute' => $df->getTranslation('name', app()->getLocale())]));
                }
            }
        }
    }

private function handleImages(Service $service, array $data, bool $isUpdate = false): void
{
    if (!$isUpdate) {
        if (!empty($data['main_image'])) {
            $service->addMedia($data['main_image'])->toMediaCollection('main_image');
        }
        if (!empty($data['images'])) {
            foreach ($data['images'] as $image) {
                $service->addMedia($image)->toMediaCollection('images');
            }
        }
        return;
    }


    if (!empty($data['main_image'])) {
        $service->addMedia($data['main_image'])->toMediaCollection('main_image');
    } elseif (!empty($data['delete_main_image'])) {
        $service->clearMediaCollection('main_image');
    }

    if (!empty($data['delete_image_ids'])) {
        $service->media()
            ->whereIn('id', $data['delete_image_ids'])
            ->where('collection_name', 'images')
            ->get()
            ->each->delete();
    }

    if (!empty($data['images'])) {
        foreach ($data['images'] as $image) {
            $service->addMedia($image)->toMediaCollection('images');
        }
    }
}
}
