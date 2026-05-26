<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreActivityTypeRequest;
use App\Http\Requests\Web\UpdateActivityTypeRequest;
use App\Models\ActivityType;
use App\Services\ActivityTypeService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View; 

class ActivityTypeController extends Controller
{
    public function __construct(protected ActivityTypeService $activityTypeService)
    {
    }

    public function index(Request $request): View
    {
        $search      = $request->input('search');
        $activityTypes = $this->activityTypeService->searchAndPaginate($search, 12);

        return view('admin.activity-types.index', [
            'activityTypes' => $activityTypes,
            'catName'        => 'activity-types',
            'title'          => __('admin.activity_types'),
            'breadcrumbs'    => [
                __('admin.activity_types_management'),
            ],
            'scrollspy'  => 0,
            'simplePage' => 0,
        ]);
    }

    public function create(): View
    {
        return view('admin.activity-types.create', [
            'catName'     => 'activity-types',
            'title'       => __('admin.add_activity_type'),
            'breadcrumbs' => [
                __('admin.dashboard'),
                __('admin.activity_types'),
                __('admin.add_activity_type'),
            ],
            'scrollspy'  => 0,
            'simplePage' => 0,
        ]);
    }

    public function store(StoreActivityTypeRequest $request): RedirectResponse
    {
        $this->activityTypeService->create($request->validated());

        return redirect()->route('admin.activity-types.index')
            ->with('success', __('admin.activity_type_created'));
    }

    public function show(ActivityType $activityType): View
    {
        $activityType->load(['businessAccounts.user', 'businessAccounts.city']);

        return view('admin.activity-types.show', [
            'activityType' => $activityType,
            'catName'       => 'activity-types',
            'title'         => __('admin.activity_type_details'),
            'breadcrumbs'   => [
                __('admin.dashboard'),
                __('admin.activity_types'),
                $activityType->getTranslation('name', app()->getLocale()),
            ],
            'scrollspy'  => 0,
            'simplePage' => 0,
        ]);
    }

    public function edit(ActivityType $activityType): View
    {
        return view('admin.activity-types.edit', [
            'activityType' => $activityType,
            'catName'       => 'activity-types',
            'title'         => __('admin.edit_activity_type'),
            'breadcrumbs'   => [
                __('admin.dashboard'),
                __('admin.activity_types'),
                __('admin.edit'),
            ],
            'scrollspy'  => 0,
            'simplePage' => 0,
        ]);
    }

    public function update(UpdateActivityTypeRequest $request, ActivityType $activityType): RedirectResponse
    {
        $this->activityTypeService->update($activityType, $request->validated());

        return redirect()->route('admin.activity-types.index')
            ->with('success', __('admin.activity_type_updated'));
    }

    public function destroy(ActivityType $activityType): RedirectResponse
    {
        $this->activityTypeService->delete($activityType);

        return redirect()->route('admin.activity-types.index')
            ->with('success', __('admin.activity_type_deleted'));
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = json_decode($request->input('ids', '[]'), true);

        if (!empty($ids)) {
            $count = ActivityType::whereIn('id', $ids)->count();
            ActivityType::whereIn('id', $ids)->delete();

            return redirect()->route('admin.activity-types.index')
                ->with('success', __('admin.activity_types_deleted', ['count' => $count]));
        }

        return redirect()->route('admin.activity-types.index');
    }
}

