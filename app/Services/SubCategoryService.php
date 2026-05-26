<?php

namespace App\Services;

use App\Models\Service;
use App\Models\SubCategory;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class SubCategoryService
{
    public function searchAndPaginate(int $categoryId, ?string $search = null, int $perPage = 12): LengthAwarePaginator
    {
        return SubCategory::query()
            ->where('category_id', $categoryId)
            ->when($search, function ($query, $search) {
                $search = mb_strtolower($search);
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.ar"))) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.en"))) LIKE ?', ["%{$search}%"]);
                });
            })
            ->withCount('dynamicFields')
            ->latest()
            ->paginate($perPage);
    }

    public function create(int $categoryId, array $data): SubCategory
    {
        return SubCategory::create([
            'category_id' => $categoryId,
            'name'        => ['ar' => $data['name_ar'], 'en' => $data['name_en']],
        ]);
    }

    public function update(SubCategory $subCategory, array $data): SubCategory
    {
        $subCategory->update([
            'name' => [
                'ar' => $data['name_ar'] ?? $subCategory->getTranslation('name', 'ar'),
                'en' => $data['name_en'] ?? $subCategory->getTranslation('name', 'en'),
            ],
        ]);
        return $subCategory->fresh();
    }


public function delete(SubCategory $subCategory): void
{
    $servicesCount = Service::where('sub_category_id', $subCategory->id)->count();
    if ($servicesCount > 0) {
        throw new \Exception(__('admin.cannot_delete_subcategory_has_services', ['count' => $servicesCount]));
    }

    $subCategory->delete();
}

    public function bulkDelete(int $categoryId, array $ids): int
    {
        if (empty($ids)) {
            return 0;
        }

        $subCategories = SubCategory::where('category_id', $categoryId)
            ->whereIn('id', $ids)
            ->get();

        if ($subCategories->isEmpty()) {
            return 0;
        }

        $subCategoryIds = $subCategories->pluck('id')->toArray();
        $servicesCount = Service::whereIn('sub_category_id', $subCategoryIds)->count();

        if ($servicesCount > 0) {
            throw new Exception(__('admin.cannot_delete_subcategories_has_services', ['count' => $servicesCount]));
        }

        return SubCategory::whereIn('id', $subCategoryIds)->delete();
    }
}
