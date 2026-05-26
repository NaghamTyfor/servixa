<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Service;
use App\Models\SubCategory;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function searchAndPaginate(?string $search = null, int $perPage = 12): LengthAwarePaginator
    {
        return Category::query()
            ->when($search, function ($query, $search) {
                $search = mb_strtolower($search);
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.ar"))) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, "$.en"))) LIKE ?', ["%{$search}%"]);
                });
            })
            ->withCount(['subCategories', 'dynamicFields'])
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Category
    {
        return Category::create([
            'name' => ['ar' => $data['name_ar'], 'en' => $data['name_en']],
        ]);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update([
            'name' => [
                'ar' => $data['name_ar'] ?? $category->getTranslation('name', 'ar'),
                'en' => $data['name_en'] ?? $category->getTranslation('name', 'en'),
            ],
        ]);

        return $category->fresh();
    }


public function delete(Category $category): void
{
    $servicesCount = Service::where('category_id', $category->id)->count();
    if ($servicesCount > 0) {
        throw new \Exception(__('admin.cannot_delete_category_has_services', ['count' => $servicesCount]));
    }

    SubCategory::where('category_id', $category->id)->delete();

    $category->delete();
}

public function bulkDelete(array $ids): int
{
    if (empty($ids)) {
        return 0;
    }

    $categories = Category::whereIn('id', $ids)->get();
    if ($categories->isEmpty()) {
        return 0;
    }

    $categoryIds = $categories->pluck('id')->toArray();

    $servicesCount = Service::whereIn('category_id', $categoryIds)->count();
    if ($servicesCount > 0) {
        throw new \Exception(__('admin.cannot_delete_categories_has_services', ['count' => $servicesCount]));
    }

    SubCategory::whereIn('category_id', $categoryIds)->delete();

    return Category::whereIn('id', $categoryIds)->delete();
}
}
