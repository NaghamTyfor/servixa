<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreSliderRequest;
use App\Http\Requests\Web\UpdateSliderRequest;
use App\Models\Slider;
use App\Services\SliderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Exception;

class SliderController extends Controller
{
    public function __construct(protected SliderService $sliderService)
    {
    }

    public function index(Request $request): View
    {
        $search  = $request->input('search');
        $sliders = $this->sliderService->searchAndPaginate($search, 15);

        return view('admin.sliders.index', [
            'sliders'     => $sliders,
            'catName'     => 'sliders',
            'title'       => __('admin.sliders'),
            'breadcrumbs' => [__('admin.sliders_management')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function create(): View
    {
        return view('admin.sliders.create', [
            'catName'     => 'sliders',
            'title'       => __('admin.add_slider'),
            'breadcrumbs' => [__('admin.dashboard'), __('admin.sliders'), __('admin.add_slider')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function store(StoreSliderRequest $request): RedirectResponse
    {
        $this->sliderService->create($request->validated());

        return redirect()->route('admin.sliders.index')
            ->with('success', __('admin.slider_created'));
    }

    public function show(Slider $slider): View
    {
        return view('admin.sliders.show', [
            'slider'      => $slider,
            'catName'     => 'sliders',
            'title'       => __('admin.slider_details'),
            'breadcrumbs' => [__('admin.dashboard'), __('admin.sliders'), $slider->getTranslation('title', app()->getLocale())],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', [
            'slider'      => $slider,
            'catName'     => 'sliders',
            'title'       => __('admin.edit_slider'),
            'breadcrumbs' => [__('admin.dashboard'), __('admin.sliders'), __('admin.edit')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function update(UpdateSliderRequest $request, Slider $slider): RedirectResponse
    {
        $this->sliderService->update($slider, $request->validated());

        return redirect()->route('admin.sliders.index')
            ->with('success', __('admin.slider_updated'));
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        $this->sliderService->delete($slider);

        return redirect()->route('admin.sliders.index')
            ->with('success', __('admin.slider_deleted'));
    }

public function toggleActive(Slider $slider, Request $request)
{
    try {
        $this->sliderService->toggleActive($slider);
        $status = $slider->is_active ? 'activated' : 'deactivated';
        $message = __("admin.slider_{$status}");

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->back()->with('success', $message);
    } catch (Exception $e) {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
        return redirect()->back()->withErrors(['message' => $e->getMessage()]);
    }
}
}
