<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\Admin;
use App\Models\BusinessAccount;
use App\Models\Category;
use App\Models\City;
use App\Models\DynamicField;
use App\Models\Report;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role as ModelsRole;

class DashboardController extends Controller
{
    public function index(): View
    {
        $admin = Auth::guard('admin')->user();

        $stats = [
            'total_users'             => User::count(),
            'total_business_accounts' => BusinessAccount::count(),
            'total_services'          => Service::count(),
            'total_requests'          => ServiceRequest::count(),
            'total_categories'        => Category::count(),
            'total_subcategories'     => SubCategory::count(),
            'total_cities'            => City::count(),
            'total_activity_types'    => ActivityType::count(),
            'total_dynamic_fields'    => DynamicField::count(),
            'total_sliders'           => Slider::count(),
            'total_reports'           => Report::count(),
            'total_admins'            => Admin::count(),
            'total_roles'             => ModelsRole::count(),
        ];

        if ($admin->hasPermissionTo('business_accounts.approve')) {
            $stats['pending_business_accounts']   = BusinessAccount::where('status', 'pending')->count();
            $stats['suspended_business_accounts'] = BusinessAccount::where('status', 'suspended')->count();
        }
        if ($admin->hasPermissionTo('services.approve')) {
            $stats['pending_services']   = Service::where('status', 'pending')->count();
            $stats['suspended_services'] = Service::where('status', 'suspended')->count();
        }


        $servicesByType = Service::select('service_type', DB::raw('count(*) as total'))
            ->groupBy('service_type')
            ->pluck('total', 'service_type')
            ->toArray();

        $requestsLast7Days = ServiceRequest::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $businessByCity = BusinessAccount::select('city_id', DB::raw('count(*) as total'))
            ->with('city')
            ->groupBy('city_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->mapWithKeys(fn($item) => [$item->city?->name ?? 'غير محدد' => $item->total])
            ->toArray();

        $servicesByStatus = Service::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $businessByStatus = BusinessAccount::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('admin.dashboard', [
            'catName'            => 'dashboard',
            'title'              => __('dashboard.page_title') ?: 'لوحة التحكم',
            'breadcrumbs'        => [__('dashboard.dashboard') ?: 'الرئيسية', __('dashboard.analytics') ?: 'الإحصائيات'],
            'scrollspy'          => 0,
            'simplePage'         => 0,
            'stats'              => $stats,
            'servicesByType'     => $servicesByType,
            'requestsLast7Days'  => $requestsLast7Days,
            'businessByCity'     => $businessByCity,
            'servicesByStatus'   => $servicesByStatus,
            'businessByStatus'   => $businessByStatus,
        ]);
    }
}
