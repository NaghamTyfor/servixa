<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreCategoryRequest;
use App\Http\Requests\Web\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $service
    ) {}
    public function index(Request $request): View
    {
        $categories = $this->service->searchAndPaginate(
            search: $request->input('search'),
            perPage: 12
        );
        return view('admin.categories.index', [
            'categories'  => $categories,
            'catName'     => 'categories',
            'title'       => 'SERVIXA - Categories',
            'breadcrumbs' => [__('admin.categories')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }
    public function create(): View
    {
        return view('admin.categories.create', [
            'catName'     => 'categories',
            'title'       => 'SERVIXA - Add Category',
            'breadcrumbs' => [__('admin.categories'), __('admin.add')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('admin.categories.index')
            ->with('success', __('admin.category_created'));
    }
    public function show(Category $category): View
    {
        $category->load(['subCategories.dynamicFields', 'dynamicFields']);
        $category->loadCount(['subCategories', 'dynamicFields']);

        return view('admin.categories.show', [
            'category'    => $category,
            'catName'     => 'categories',
            'title'       => 'SERVIXA - Category Details',
            'breadcrumbs' => [__('admin.categories'), __('admin.details')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category'    => $category,
            'catName'     => 'categories',
            'title'       => 'SERVIXA - Edit Category',
            'breadcrumbs' => [__('admin.categories'), __('admin.edit')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->service->update($category, $request->validated());

        return redirect()->route('admin.categories.index')
            ->with('success', __('admin.category_updated'));
    }
public function destroy(Category $category): RedirectResponse
{
    try {
        $this->service->delete($category);
        return redirect()->route('admin.categories.index')
            ->with('success', __('admin.category_deleted'));
    } catch (\Exception $e) {
        return redirect()->route('admin.categories.index')
            ->with('error', $e->getMessage());
    }
}
public function bulkDestroy(Request $request): RedirectResponse
{
    $ids = json_decode($request->input('ids'), true);
    try {
        $deletedCount = $this->service->bulkDelete($ids ?? []);
        return redirect()->route('admin.categories.index')
            ->with('success', __('admin.categories_deleted', ['count' => $deletedCount]));
    } catch (Exception $e) {
        return redirect()->route('admin.categories.index')
            ->with('error', $e->getMessage());
    }
}
}
