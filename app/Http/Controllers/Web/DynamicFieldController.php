<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreDynamicFieldRequest;
use App\Http\Requests\Web\UpdateDynamicFieldRequest;
use App\Models\Category;
use App\Models\DynamicField;
use App\Models\SubCategory;
use App\Services\DynamicFieldService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DynamicFieldController extends Controller
{
    public function __construct(
        private readonly DynamicFieldService $service
    ) {}

public function indexForCategory(Request $request, Category $category): View
{
    $query = $category->dynamicFields()->latest();

    if ($request->filled('search')) {
        $searchTerm = '%' . $request->search . '%';
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name->ar', 'like', $searchTerm)
            ->orWhere('name->en', 'like', $searchTerm);
        });
    }

    $fields = $query->paginate(10);

    if ($request->ajax()) {
        return view('admin.dynamic-fields.partials.table', [
            'fields' => $fields,
            'owner' => $category,
            'ownerType' => 'category',
            'parentCategory' => null,
        ]);
    }

    return view('admin.dynamic-fields.index', [
        'fields' => $fields,
        'owner' => $category,
        'ownerType' => 'category',
        'parentCategory' => null,
        'title' => 'SERVIXA - Dynamic Fields',
        'catName' => 'dynamicFields',
        'scrollspy' => 0,
        'simplePage' => 0,
    ]);
}
    public function createForCategory(Category $category): View
    {
        return view('admin.dynamic-fields.create', [
            'owner' => $category,
            'ownerType' => 'category',
            'parentCategory' => null,
            'title'       => 'SERVIXA - Dynamic Fields',
            'catName'      => 'dynamicFields',
            'scrollspy'    => 0,
            'simplePage'   => 0,
        ]);
    }

    public function storeForCategory(StoreDynamicFieldRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['options'] = $request->getOptionsArray();

        $this->service->create($category, $data);

        return redirect()->route('admin.categories.dynamic-fields.index', $category)
            ->with('success', __('dynamic_field.created'));
    }

    public function showForCategory(Category $category, DynamicField $dynamicField): View
    {
        return view('admin.dynamic-fields.show', [
            'owner' => $category,
            'field' => $dynamicField,
            'ownerType' => 'category',
            'parentCategory' => null,
            'title'       => 'SERVIXA - Dynamic Fields',
            'catName'      => 'dynamicFields',
            'scrollspy'    => 0,
            'simplePage'   => 0,
        ]);
    }

    public function editForCategory(Category $category, DynamicField $dynamicField): View
    {
        return view('admin.dynamic-fields.edit', [
            'owner' => $category,
            'field' => $dynamicField,
            'ownerType' => 'category',
            'parentCategory' => null,
            'title'       => 'SERVIXA - Dynamic Fields',
            'catName'      => 'dynamicFields',
            'scrollspy'    => 0,
            'simplePage'   => 0,
        ]);
    }

    public function updateForCategory(UpdateDynamicFieldRequest $request, Category $category, DynamicField $dynamicField): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasAny(['options_ar', 'options_en', 'options_keys'])) {
            $data['options'] = $request->getOptionsArray();
        }

        $this->service->update($dynamicField, $data);

        return redirect()->route('admin.categories.dynamic-fields.index', $category)
            ->with('success', __('dynamic_field.updated'));
    }

    public function destroyForCategory(Category $category, DynamicField $dynamicField): RedirectResponse
    {
        $this->service->delete($dynamicField);

        return redirect()->route('admin.categories.dynamic-fields.index', $category)
            ->with('success', __('dynamic_field.deleted'));
    }

public function indexForSubCategory(Request $request, Category $category, SubCategory $subCategory): View
{
    $query = $subCategory->dynamicFields()->latest();

    if ($request->filled('search')) {
        $searchTerm = '%' . $request->search . '%';
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name->ar', 'like', $searchTerm)
            ->orWhere('name->en', 'like', $searchTerm);
        });
    }

    $fields = $query->paginate(10);

    if ($request->ajax()) {
        return view('admin.dynamic-fields.partials.table', [
            'fields' => $fields,
            'owner' => $subCategory,
            'ownerType' => 'sub_category',
            'parentCategory' => $category,
        ]);
    }

    return view('admin.dynamic-fields.index', [
        'fields' => $fields,
        'owner' => $subCategory,
        'ownerType' => 'sub_category',
        'parentCategory' => $category,
        'title' => 'SERVIXA - Dynamic Fields',
        'catName' => 'dynamicFields',
        'scrollspy' => 0,
        'simplePage' => 0,
    ]);
}

    public function createForSubCategory(Category $category, SubCategory $subCategory): View
    {
        return view('admin.dynamic-fields.create', [
            'owner' => $subCategory,
            'ownerType' => 'sub_category',
            'parentCategory' => $category,
            'title'       => 'SERVIXA - Dynamic Fields',
            'catName'      => 'dynamicFields',
            'scrollspy'    => 0,
            'simplePage'   => 0,
        ]);
    }

    public function storeForSubCategory(StoreDynamicFieldRequest $request, Category $category, SubCategory $subCategory): RedirectResponse
    {
        $data = $request->validated();
        $data['options'] = $request->getOptionsArray();

        $this->service->create($subCategory, $data);

        return redirect()->route('admin.categories.sub-categories.dynamic-fields.index', [$category, $subCategory])
            ->with('success', __('dynamic_field.created'));
    }

    public function showForSubCategory(Category $category, SubCategory $subCategory, DynamicField $dynamicField): View
    {
        return view('admin.dynamic-fields.show', [
            'owner' => $subCategory,
            'field' => $dynamicField,
            'ownerType' => 'sub_category',
            'parentCategory' => $category,
            'title'       => 'SERVIXA - Dynamic Fields',
            'catName'      => 'dynamicFields',
            'scrollspy'    => 0,
            'simplePage'   => 0,
        ]);
    }

    public function editForSubCategory(Category $category, SubCategory $subCategory, DynamicField $dynamicField): View
    {
        return view('admin.dynamic-fields.edit', [
            'owner' => $subCategory,
            'field' => $dynamicField,
            'ownerType' => 'sub_category',
            'parentCategory' => $category,
            'title'       => 'SERVIXA - Dynamic Fields',
            'catName'      => 'dynamicFields',
            'scrollspy'    => 0,
            'simplePage'   => 0,
        ]);
    }

    public function updateForSubCategory(UpdateDynamicFieldRequest $request, Category $category, SubCategory $subCategory, DynamicField $dynamicField): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasAny(['options_ar', 'options_en', 'options_keys'])) {
            $data['options'] = $request->getOptionsArray();
        }

        $this->service->update($dynamicField, $data);

        return redirect()->route('admin.categories.sub-categories.dynamic-fields.index', [$category, $subCategory])
            ->with('success', __('dynamic_field.updated'));
    }

    public function destroyForSubCategory(Category $category, SubCategory $subCategory, DynamicField $dynamicField): RedirectResponse
    {
        $this->service->delete($dynamicField);

        return redirect()->route('admin.categories.sub-categories.dynamic-fields.index', [$category, $subCategory])
            ->with('success', __('dynamic_field.deleted'));
    }
}
