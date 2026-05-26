@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('plugins/src/apex/apexcharts.css')}}">
@vite(['resources/scss/light/assets/dashboard/dash_1.scss'])
@vite(['resources/scss/dark/assets/dashboard/dash_1.scss'])
<style>
    :root {
        --card-white: #ffffff;
        --card-border: #eef2f6;
        --card-shadow: 0 12px 24px -12px rgba(0, 0, 0, 0.08);
        --hover-shadow: 0 24px 36px -16px rgba(0, 0, 0, 0.15);
        --grad-blue: linear-gradient(135deg, #3b82f6, #2563eb);
        --grad-green: linear-gradient(135deg, #10b981, #059669);
        --grad-orange: linear-gradient(135deg, #f59e0b, #d97706);
        --grad-red: linear-gradient(135deg, #ef4444, #dc2626);
        --grad-purple: linear-gradient(135deg, #8b5cf6, #6d28d9);
        --grad-pink: linear-gradient(135deg, #ec489a, #db2777);
    }
    .dark {
        --card-white: #1e293b;
        --card-border: #334155;
        --card-shadow: 0 12px 24px -12px rgba(0, 0, 0, 0.3);
        --hover-shadow: 0 24px 36px -12px rgba(0, 0, 0, 0.5);
    }

    .stat-card, .chart-card, .entity-card {
        background: var(--card-white);
        border: 1px solid var(--card-border);
        border-radius: 1.5rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover, .chart-card:hover, .entity-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--hover-shadow);
    }

    .stat-card::before, .chart-card::before, .entity-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec489a);
        opacity: 0;
        transition: opacity 0.3s;
    }
    .stat-card:hover::before, .chart-card:hover::before, .entity-card:hover::before {
        opacity: 1;
    }

    .stat-mini {
        padding: 1.2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-mini-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(145deg, #f8fafc, #eef2f6);
        border-radius: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        transition: all 0.3s;
    }
    .dark .stat-mini-icon {
        background: #0f172a;
    }
    .stat-card:hover .stat-mini-icon {
        transform: scale(1.05) rotate(2deg);
    }
    .stat-mini-value {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.2;
        color: #0f172a;
    }
    .dark .stat-mini-value {
        color: #f1f5f9;
    }
    .stat-mini-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: #64748b;
    }

    .metric-big {
        padding: 1.2rem;
        text-align: center;
        border-top: 3px solid;
        border-radius: 1.5rem 1.5rem 1rem 1rem;
    }
    .metric-big .value {
        font-size: 2.2rem;
        font-weight: 800;
        margin: 0.5rem 0;
    }
    .metric-big .label {
        font-size: 0.8rem;
        font-weight: 500;
    }

    .icon-blue { color: #3b82f6; stroke: #3b82f6; }
    .icon-green { color: #10b981; stroke: #10b981; }
    .icon-orange { color: #f59e0b; stroke: #f59e0b; }
    .icon-red { color: #ef4444; stroke: #ef4444; }
    .icon-purple { color: #8b5cf6; stroke: #8b5cf6; }
    .icon-pink { color: #ec489a; stroke: #ec489a; }

    .entity-card {
        text-align: center;
        padding: 1.2rem 0.8rem;
    }
    .entity-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(145deg, #f8fafc, #eef2f6);
        border-radius: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        transition: transform 0.2s;
    }
    .entity-icon svg {
        width: 28px;
        height: 28px;
        stroke-width: 1.8;
        fill: none;
    }
    .dark .entity-icon {
        background: #0f172a;
    }
    .entity-card:hover .entity-icon {
        transform: scale(1.08);
    }
    .entity-value {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1.2;
    }
    .entity-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin: 0.5rem 0 0.25rem;
        color: #475569;
    }
    .dark .entity-label {
        color: #94a3b8;
    }
    .entity-link {
        font-size: 0.7rem;
        font-weight: 500;
        text-decoration: none;
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    .entity-link:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .chart-card {
        padding: 1rem;
    }
    .chart-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-bottom: 1px dashed var(--card-border);
        padding-bottom: 0.5rem;
    }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-card {
        animation: fadeSlideUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        opacity: 0;
    }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }
    .delay-3 { animation-delay: 0.15s; }
    .delay-4 { animation-delay: 0.2s; }
    .delay-5 { animation-delay: 0.25s; }
    .delay-6 { animation-delay: 0.3s; }
    .delay-7 { animation-delay: 0.35s; }
    .delay-8 { animation-delay: 0.4s; }
    .delay-9 { animation-delay: 0.45s; }
    .delay-10 { animation-delay: 0.5s; }
    .delay-11 { animation-delay: 0.55s; }
    .delay-12 { animation-delay: 0.6s; }
    .delay-13 { animation-delay: 0.65s; }

    .page-header-modern {
        position: relative;
        background: linear-gradient(135deg, #2e1065 0%, #5b21b6 40%, #7c3aed 80%, #a78bfa 100%);
        border-radius: 32px;
        padding: 2rem 2.5rem;
        margin-bottom: 2.5rem;
        margin-top: 1.5rem;
        overflow: hidden;
        box-shadow: 0 20px 40px -15px rgba(124,58,237,0.3);
        animation: slideUp 0.6s ease;
    }
    .header-bg-pattern {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-image: radial-gradient(circle at 30% 40%, rgba(255,255,255,0.08) 0%, transparent 30%),
                          radial-gradient(circle at 80% 70%, rgba(255,255,255,0.05) 0%, transparent 40%),
                          repeating-linear-gradient(45deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 2px, transparent 2px, transparent 8px);
        pointer-events: none;
    }
    .header-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    .header-title-area {
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }
    .header-icon {
        width: 64px;
        height: 64px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,0.25);
    }
    .header-icon svg {
        stroke: white;
        stroke-width: 1.8;
        width: 32px;
        height: 32px;
    }
    .header-text h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: white;
        margin: 0;
    }
    .header-text p {
        color: rgba(255,255,255,0.7);
        margin: 0.3rem 0 0;
        font-size: 0.95rem;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 768px) {
        .page-header-modern { padding: 1.5rem; margin-top: 1rem; }
        .header-text h1 { font-size: 1.6rem; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- الهيدر – جميع النصوص مترجمة (دون صلاحية) -->
    <div class="page-header-modern">
        <div class="header-bg-pattern"></div>
        <div class="header-content">
            <div class="header-title-area">
                <div class="header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('dashboard.dashboard') }}</h1>
                    <p>{{ __('dashboard.dashboard_subtitle') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسوم البيانية – مرتبة بجانب بعضها في ثلاثة أعمدة متساوية -->
    <div class="row g-4 mb-4">
        @can('business_accounts.view')
            <div class="col-xl-4 col-lg-6 animate-card delay-11">
                <div class="chart-card">
                    <div class="chart-title"><i class="fas fa-chart-bar icon-purple"></i> {{ __('dashboard.business_by_city') }}</div>
                    <div id="businessCityChart"></div>
                </div>
            </div>
        @endcan

        @can('services.view')
            <div class="col-xl-4 col-lg-6 animate-card delay-12">
                <div class="chart-card h-100">
                    <div class="chart-title text-center"><i class="fas fa-chart-pie icon-blue"></i> {{ __('dashboard.services_by_status') }}</div>
                    <div id="servicesStatusChart"></div>
                </div>
            </div>
        @endcan

        @can('business_accounts.view')
            <div class="col-xl-4 col-lg-6 animate-card delay-13">
                <div class="chart-card h-100">
                    <div class="chart-title text-center"><i class="fas fa-chart-pie icon-green"></i> {{ __('dashboard.business_by_status') }}</div>
                    <div id="businessStatusChart"></div>
                </div>
            </div>
        @endcan
    </div>

    <!-- الكيانات – كل بطاقة محمية بصلاحيتها الخاصة -->
    <div class="row g-4">
        @php
            // تعريف الكيانات مع ربط كل كيان بالصلاحية المناسبة
            $entitiesWithIcons = [
                'total_categories' => [
                    'label' => __('dashboard.main_categories'),
                    'color' => 'icon-blue',
                    'route' => route('admin.categories.index'),
                    'svg' => '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4h6v6H4V4zM14 4h6v6h-6V4zM4 14h6v6H4v-6zM14 14h6v6h-6v-6z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
                    'permission' => 'categories.view'
                ],
                'total_subcategories' => [
                    'label' => __('dashboard.subcategories'),
                    'color' => 'icon-blue',
                    'route' => route('admin.categories.index'),
                    'svg' => '<svg viewBox="0 0 24 24" fill="none"><path d="M4 4h6v6H4V4zM14 4h6v6h-6V4zM4 14h6v6H4v-6z" stroke="currentColor" stroke-width="1.8"/><path d="M14 14h6v6h-6v-6z" stroke="currentColor" stroke-width="1.8"/></svg>',
                    'permission' => 'sub_categories.view'
                ],
                'total_cities' => [
                    'label' => __('dashboard.cities'),
                    'color' => 'icon-green',
                    'route' => route('admin.cities.index'),
                    'svg' => '<svg viewBox="0 0 24 24" fill="none"><path d="M12 2c-4 0-7 3-7 7 0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="1.8"/></svg>',
                    'permission' => 'cities.view'
                ],
                'total_activity_types' => [
                    'label' => __('dashboard.activity_types'),
                    'color' => 'icon-purple',
                    'route' => route('admin.activity-types.index'),
                    'svg' => '<svg viewBox="0 0 24 24" fill="none"><path d="M20 7h-4.18A3 3 0 0 0 16 5.18V4a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" stroke="currentColor" stroke-width="1.8"/><path d="M8 4v8M12 4v4M16 4v2" stroke="currentColor" stroke-width="1.8"/></svg>',
                    'permission' => 'activity_types.view'
                ],
                'total_dynamic_fields' => [
                    'label' => __('dashboard.dynamic_fields'),
                    'color' => 'icon-pink',
                    'route' => '#',  // يمكن تعديله لاحقاً إلى route('admin.dynamic-fields.index')
                    'svg' => '<svg viewBox="0 0 24 24" fill="none"><path d="M3 6h18M9 12h6M7 18h10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.8"/></svg>',
                    'permission' => 'dynamic_fields.view'
                ],
                'total_sliders' => [
                    'label' => __('dashboard.sliders'),
                    'color' => 'icon-orange',
                    'route' => route('admin.sliders.index'),
                    'svg' => '<svg viewBox="0 0 24 24" fill="none"><path d="M2 12h20M12 2v20M18 8l4 4-4 4M6 8l-4 4 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
                    'permission' => 'sliders.view'
                ],
                'total_reports' => [
                    'label' => __('dashboard.reports'),
                    'color' => 'icon-red',
                    'route' => route('admin.reports.index'),
                    'svg' => '<svg viewBox="0 0 24 24" fill="none"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg>',
                    'permission' => 'reports.view'
                ],
                'total_admins' => [
                    'label' => __('dashboard.admins'),
                    'color' => 'icon-purple',
                    'route' => route('admin.admins.index'),
                    'svg' => '<svg viewBox="0 0 24 24" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.8"/><path d="M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="1.8"/></svg>',
                    'permission' => 'admins.view'
                ],
                'total_roles' => [
                    'label' => __('dashboard.roles'),
                    'color' => 'icon-green',
                    'route' => route('admin.roles.index'),
                    'svg' => '<svg viewBox="0 0 24 24" fill="none"><path d="M12 8c2.21 0 4 1.79 4 4s-1.79 4-4 4-4-1.79-4-4 1.79-4 4-4z" stroke="currentColor" stroke-width="1.8"/><path d="M12 2v2M22 12h-2M4 12H2M12 20v2M18.36 5.64l-1.42 1.42M7.05 16.95l-1.42 1.42M16.95 16.95l1.42 1.42M5.64 5.64l1.42 1.42" stroke="currentColor" stroke-width="1.8"/></svg>',
                    'permission' => 'roles.view'
                ],
            ];
        @endphp

        @foreach($entitiesWithIcons as $key => $entity)
            @if(isset($stats[$key]) && $stats[$key] > 0 && auth()->user()->can($entity['permission']))
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 animate-card delay-13">
                    <div class="entity-card">
                        <div class="entity-icon {{ $entity['color'] }}">
                            {!! $entity['svg'] !!}
                        </div>
                        <div class="entity-value counter" data-target="{{ $stats[$key] }}">0</div>
                        <div class="entity-label">{{ $entity['label'] }}</div>
                        <a href="{{ $entity['route'] }}" class="entity-link text-primary">{{ __('dashboard.view') }} →</a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/apex/apexcharts.min.js')}}"></script>
<script>
    function animateCounters() {
        document.querySelectorAll('.counter').forEach(el => {
            const target = parseInt(el.dataset.target);
            if (isNaN(target)) return;
            let current = 0;
            const step = target / 50;
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    el.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current).toLocaleString();
                }
            }, 20);
        });
    }

    // رسم المخططات الموجودة فقط (business_by_city, services_by_status, business_by_status)
    const cityData = @json($businessByCity);
    const cityNames = Object.keys(cityData);
    const cityCounts = Object.values(cityData);
    new ApexCharts(document.querySelector('#businessCityChart'), {
        series: [{ name: @json(__('dashboard.business_accounts')), data: cityCounts }],
        chart: { type: 'bar', height: 280 },
        xaxis: { categories: cityNames },
        colors: ['#8b5cf6'],
        plotOptions: { bar: { borderRadius: 8 } }
    }).render();

    const statusLabels = [
        @json(__('dashboard.approved')),
        @json(__('dashboard.pending')),
        @json(__('dashboard.rejected')),
        @json(__('dashboard.suspended'))
    ];

    const servicesStatusData = [{{ $servicesByStatus['approved'] ?? 0 }}, {{ $servicesByStatus['pending'] ?? 0 }}, {{ $servicesByStatus['rejected'] ?? 0 }}, {{ $servicesByStatus['suspended'] ?? 0 }}];
    new ApexCharts(document.querySelector('#servicesStatusChart'), {
        series: servicesStatusData,
        labels: statusLabels,
        chart: { type: 'donut', height: 220 },
        colors: ['#10b981', '#f59e0b', '#ef4444', '#6b7280'],
        legend: { position: 'bottom' }
    }).render();

    const businessStatusData = [{{ $businessByStatus['approved'] ?? 0 }}, {{ $businessByStatus['pending'] ?? 0 }}, {{ $businessByStatus['rejected'] ?? 0 }}, {{ $businessByStatus['suspended'] ?? 0 }}];
    new ApexCharts(document.querySelector('#businessStatusChart'), {
        series: businessStatusData,
        labels: statusLabels,
        chart: { type: 'donut', height: 220 },
        colors: ['#10b981', '#f59e0b', '#ef4444', '#6b7280'],
        legend: { position: 'bottom' }
    }).render();

    window.addEventListener('load', animateCounters);
</script>
@endsection
