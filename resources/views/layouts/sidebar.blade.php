{{-- @extends('layouts.app') --}}

{{-- @section('sidebar') --}}
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{getRouterValue()}}dashboard/analytics">
                        <img src="{{Vite::asset('resources/images/logo.svg')}}" class="navbar-logo" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{getRouterValue()}}dashboard/analytics" class="nav-link">  </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                </div>
            </div>
        </div>
        <div class="shadow-bottom"></div>


        <ul class="list-unstyled menu-categories" id="accordionExample">


{{-- ══ DASHBOARD (بدون تبويبات فرعية) ══ --}}
<li class="menu {{ ($catName === 'dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>{{ __('admin.dashboard') }}</span>
        </div>
    </a>
</li>

{{-- ══ ADMINS & PERMISSIONS ══ --}}
@canany(['admins.view','roles.view'])
<li class="menu {{ in_array($catName, ['admins','roles','permissions']) ? 'active' : '' }}">
    <a href="#admins-menu" data-bs-toggle="collapse"
    aria-expanded="{{ in_array($catName, ['admins','roles','permissions']) ? 'true' : 'false' }}"
    class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            <span>{{ __('admin.admins_permissions') }}</span>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled {{ in_array($catName, ['admins','roles','permissions']) ? 'show' : '' }}"
        id="admins-menu" data-bs-parent="#accordionExample">
        @can('admins.view')
        <li class="{{ ($catName === 'admins' && !Request::routeIs('admin.roles.*') && !Request::routeIs('admin.permissions')) ? 'active' : '' }}">
            <a href="{{ route('admin.admins.index') }}">{{ __('admin.admins') }}</a>
        </li>
        @endcan
        @can('roles.view')
        <li class="{{ ($catName === 'roles') ? 'active' : '' }}">
            <a href="{{ route('admin.roles.index') }}">{{ __('admin.roles') }}</a>
        </li>
        <li class="{{ ($catName === 'permissions') ? 'active' : '' }}">
            <a href="{{ route('admin.permissions.index') }}">{{ __('admin.permissions') }}</a>
        </li>
        @endcan
    </ul>
</li>
@endcanany


{{-- ══ BUSINESS ACCOUNTS ══ --}}
@can('business_accounts.view')
<li class="menu {{ ($catName === 'business-accounts') ? 'active' : '' }}">
    <a href="{{ route('admin.business-accounts.index') }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
            <span>{{ __('admin.business_accounts') }}</span>
        </div>
    </a>
</li>
@endcan

{{-- ══ SERVICES ══ --}}
@canany(['services.view'])
<li class="menu {{ ($catName === 'services') ? 'active' : '' }}">
    <a href="{{ route('admin.services.index') }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect>
                <line x1="9" y1="2" x2="9" y2="22"></line>
                <line x1="15" y1="2" x2="15" y2="22"></line>
                <line x1="2" y1="9" x2="22" y2="9"></line>
                <line x1="2" y1="15" x2="22" y2="15"></line>
            </svg>
            <span>{{ __('admin.services') }}</span>
        </div>
    </a>
</li>
@endcanany

{{-- ══ CATEGORIES MANAGEMENT ══ --}}
@canany(['categories.view', 'sub_categories.view', 'dynamic_fields.view'])
<li class="menu {{ $catName === 'categories' ? 'active' : '' }}">
    <a href="{{ route('admin.categories.index') }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"/>
                <rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/>
                <rect x="3" y="14" width="7" height="7"/>
            </svg>
            <span>{{ __('admin.categories_management') }}</span>
        </div>
    </a>
</li>
@endcanany

{{-- ══ CITIES ══ --}}
@can('cities.view')
<li class="menu {{ ($catName === 'cities') ? 'active' : '' }}">
    <a href="{{ route('admin.cities.index') }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
            <span>{{ __('admin.cities_management') }}</span>
        </div>
    </a>
</li>
@endcan

{{-- ══ ACTIVITY TYPES ══ --}}
@can('activity_types.view')
<li class="menu {{ ($catName === 'activity-types') ? 'active' : '' }}">
    <a href="{{ route('admin.activity-types.index') }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                <polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline>
            </svg>
            <span>{{ __('admin.activity_management') }}</span>
        </div>
    </a>
</li>
@endcan

{{-- ══ SLIDERS (السلايدر الإعلاني) ══ --}}
@can('sliders.view')
<li class="menu {{ ($catName === 'sliders') ? 'active' : '' }}">
    <a href="{{ route('admin.sliders.index') }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-image">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
            </svg>
            <span>{{ __('admin.sliders_management') }}</span>
        </div>
    </a>
</li>
@endcan

{{-- ══ REPORTS (البلاغات) ══ --}}
@can('reports.view')
<li class="menu {{ ($catName === 'reports') ? 'active' : '' }}">
    <a href="{{ route('admin.reports.index') }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-flag">
                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                <line x1="4" y1="22" x2="4" y2="15"></line>
            </svg>
            <span>{{ __('admin.reports_management') }}</span>
        </div>
    </a>
</li>
@endcan

{{-- ══ CHAT (المحادثات) - بدون شرط صلاحية ══ --}}
<li class="menu {{ ($catName === 'chat') ? 'active' : '' }}">
    <a href="{{ route('chat.demo', [
        'userId1' => 3,
        'userId2' => 2,
        'serviceId' => 1
    ]) }}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
            </svg>
            <span>{{ __('admin.chatting') ?? 'المحادثات' }}</span>
        </div>
    </a>
</li>

    </nav>

</div>

{{-- @endsection --}}
