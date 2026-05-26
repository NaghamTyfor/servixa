<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(private ServiceService $service) {}

    public function index(Request $request): View
    {
        $search   = $request->input('search');
        $status   = $request->input('status');
        $services = $this->service->searchAndPaginate($search, $status, 15);

        if ($request->ajax()) {
            return view('admin.services.partials.grid', compact('services'));
        }

        return view('admin.services.index', [
            'services'    => $services,
            'catName'     => 'services',
            'title'       => 'SERVIXA - Services',
            'breadcrumbs' => [__('admin.services')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function show(Service $service): View
    {
        $service->load([
            'businessAccount.user',
            'category',
            'subCategory',
            'reviewer',
            'dynamicFieldValues.dynamicField',
            'media',
        ]);

        return view('admin.services.show', [
            'service'     => $service,
            'catName'     => 'services',
            'title'       => 'SERVIXA - Service Details',
            'breadcrumbs' => [__('admin.services'), __('admin.details')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function approve(Service $service): RedirectResponse
    {
        try {
            $this->service->approve($service, auth('admin')->id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', __('admin.service_approved'));
    }

    public function reject(Service $service): RedirectResponse
    {
        try {
            $this->service->reject($service, auth('admin')->id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', __('admin.service_rejected'));
    }

    public function suspend(Service $service): RedirectResponse
    {
        try {
            $this->service->suspend($service, auth('admin')->id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', __('admin.service_suspended'));
    }

    public function reactivate(Service $service): RedirectResponse
    {
        try {
            $this->service->reactivate($service, auth('admin')->id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', __('admin.service_reactivated'));
    }
}
