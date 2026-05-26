<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreSubCategoryRequest;
use App\Http\Requests\Web\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\SubCategoryService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubCategoryController extends Controller
{
    public function __construct(
        private readonly SubCategoryService $service
    ) {}

    public function index(Request $request, Category $category): View
    {
        $subCategories = $this->service->searchAndPaginate(
            categoryId: $category->id,
            search: $request->input('search'),
            perPage: 12
        );

        return view('admin.sub-categories.index', [
            'category'      => $category,
            'subCategories' => $subCategories,
            'catName'       => 'categories',
            'title'         => 'SERVIXA - Sub Categories',
            'breadcrumbs'   => [__('admin.categories'), $category->name, __('admin.sub_categories')],
            'scrollspy'     => 0,
            'simplePage'    => 0,
        ]);
    }

    public function create(Category $category): View
    {
        return view('admin.sub-categories.create', [
            'category'    => $category,
            'catName'     => 'categories',
            'title'       => 'SERVIXA - Add Sub Category',
            'breadcrumbs' => [__('admin.categories'), $category->name, __('admin.add')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function store(StoreSubCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->service->create($category->id, $request->validated());

        return redirect()->route('admin.categories.sub-categories.index', $category)
            ->with('success', __('admin.sub_category_created'));
    }

    public function show(Category $category, SubCategory $subCategory): View
    {
        $subCategory->load('dynamicFields');
        $subCategory->loadCount('dynamicFields');

        return view('admin.sub-categories.show', [
            'category'    => $category,
            'subCategory' => $subCategory,
            'catName'     => 'categories',
            'title'       => 'SERVIXA - Sub Category Details',
            'breadcrumbs' => [__('admin.categories'), $category->name, __('admin.details')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function edit(Category $category, SubCategory $subCategory): View
    {
        return view('admin.sub-categories.edit', [
            'category'    => $category,
            'subCategory' => $subCategory,
            'catName'     => 'categories',
            'title'       => 'SERVIXA - Edit Sub Category',
            'breadcrumbs' => [__('admin.categories'), $category->name, __('admin.edit')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function update(UpdateSubCategoryRequest $request, Category $category, SubCategory $subCategory): RedirectResponse
    {
        $this->service->update($subCategory, $request->validated());

        return redirect()->route('admin.categories.sub-categories.index', $category)
            ->with('success', __('admin.sub_category_updated'));
    }

public function destroy(Category $category, SubCategory $subCategory): RedirectResponse
{
    try {
        $this->service->delete($subCategory);
        return redirect()->route('admin.categories.sub-categories.index', $category)
            ->with('success', __('admin.sub_category_deleted'));
    } catch (\Exception $e) {
        return redirect()->route('admin.categories.sub-categories.index', $category)
            ->with('error', $e->getMessage());
    }
}

    public function bulkDestroy(Request $request, Category $category): RedirectResponse
    {
        $ids = json_decode($request->input('ids'), true);

        try {
            $deletedCount = $this->service->bulkDelete($category->id, $ids ?? []);
            return redirect()->route('admin.categories.sub-categories.index', $category)
                ->with('success', __('admin.sub_categories_deleted', ['count' => $deletedCount]));
        } catch (Exception $e) {
            return redirect()->route('admin.categories.sub-categories.index', $category)
                ->with('error', $e->getMessage());
        }
    }
}
