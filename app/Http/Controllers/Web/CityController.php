<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreCityRequest;
use App\Http\Requests\Web\UpdateCityRequest;
use App\Models\City;
use App\Services\CityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CityController extends Controller
{
    public function __construct(protected CityService $cityService)
    {
    }

    public function index(Request $request): View
    {
        $search = $request->input('search');
        $cities = $this->cityService->searchAndPaginate($search, 12);

        return view('admin.cities.index', [
            'cities'       => $cities,
            'catName'      => 'cities',
            'title'        => __('admin.cities'),
            'breadcrumbs'  => [
                __('admin.cities_management'),
            ],
            'scrollspy'    => 0,
            'simplePage'   => 0,
        ]);
    }

    public function create(): View
    {
        return view('admin.cities.create', [
            'catName'     => 'cities',
            'title'       => __('admin.add_city'),
            'breadcrumbs' => [
                __('admin.dashboard'),
                __('admin.cities'),
                __('admin.add_city'),
            ],
            'scrollspy'  => 0,
            'simplePage' => 0,
        ]);
    }

    public function store(StoreCityRequest $request): RedirectResponse
    {
        $this->cityService->create($request->validated());

        return redirect()->route('admin.cities.index')
            ->with('success', __('admin.city_created'));
    }

    public function show(City $city): View
    {
        $city->load(['users', 'businessAccounts.user', 'businessAccounts.activityType']);

        return view('admin.cities.show', [
            'city'        => $city,
            'catName'     => 'cities',
            'title'       => __('admin.city_details'),
            'breadcrumbs' => [
                __('admin.dashboard'),
                __('admin.cities'),
                $city->getTranslation('name', app()->getLocale()),
            ],
            'scrollspy'  => 0,
            'simplePage' => 0,
        ]);
    }

    public function edit(City $city): View
    {
        return view('admin.cities.edit', [
            'city'        => $city,
            'catName'     => 'cities',
            'title'       => __('admin.edit_city'),
            'breadcrumbs' => [
                __('admin.dashboard'),
                __('admin.cities'),
                __('admin.edit'),
            ],
            'scrollspy'  => 0,
            'simplePage' => 0,
        ]);
    }

    public function update(UpdateCityRequest $request, City $city): RedirectResponse
    {
        $this->cityService->update($city, $request->validated());

        return redirect()->route('admin.cities.index')
            ->with('success', __('admin.city_updated'));
    }

    public function destroy(City $city): RedirectResponse
    {
        $this->cityService->delete($city);

        return redirect()->route('admin.cities.index')
            ->with('success', __('admin.city_deleted'));
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = json_decode($request->input('ids', '[]'), true);

        if (!empty($ids)) {
            $count = count($ids);
            $this->cityService->bulkDelete($ids);

            return redirect()->route('admin.cities.index')
                ->with('success', __('admin.cities_deleted', ['count' => $count]));
        }

        return redirect()->route('admin.cities.index');
    }
}
