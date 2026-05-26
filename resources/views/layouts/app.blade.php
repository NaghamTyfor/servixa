<?php
    $lang  = session('locale', 'ar');
    $isRtl = $lang === 'ar';
?>
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@isset($title){{ $title }}@else SERVIXA @endisset</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/scss/layouts/vertical-light-menu/light/loader.scss'])
    @vite(['resources/scss/layouts/vertical-light-menu/dark/loader.scss'])
    @vite(['resources/layouts/vertical-light-menu/loader.js'])
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @if($isRtl)
        <link rel="stylesheet" href="{{ asset('plugins/src/bootstrap/css/bootstrap.rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('plugins/src/bootstrap/css/bootstrap.min.css') }}">
    @endif
    @vite(['resources/scss/light/assets/main.scss'])
    @vite(['resources/scss/dark/assets/main.scss'])
    @vite(['resources/scss/light/plugins/perfect-scrollbar/perfect-scrollbar.scss'])
    @vite(['resources/scss/dark/plugins/perfect-scrollbar/perfect-scrollbar.scss'])
    <link rel="stylesheet" href="{{ asset('plugins/src/waves/waves.min.css') }}">
    @vite(['resources/scss/layouts/vertical-light-menu/light/structure.scss'])
    @vite(['resources/scss/layouts/vertical-light-menu/dark/structure.scss'])
    @vite(['resources/css/navbar-theme.css'])
    @vite(['resources/js/laravel-app.js'])
    <link rel="stylesheet" href="{{ asset('plugins/src/highlight/styles/monokai-sublime.css') }}">

    <style>
        body:not(.dark) {
            background: linear-gradient(120deg, #f4f0ff 0%, #e9e0ff 100%);
            background-attachment: fixed;
        }
        body:not(.dark) .main-container {
            background: transparent;
        }

        body:not(.dark) .sidebar-wrapper,
        body:not(.dark) .sidebar-wrapper .sidebar-theme,
        body:not(.dark) .sidebar-wrapper #sidebar,
        body:not(.dark) .sidebar-wrapper nav#sidebar,
        body:not(.dark) .sidebar-wrapper .menu-categories,
        body:not(.dark) .sidebar-wrapper .navbar-nav {
            background: #f8f5ff !important;
        }
        body:not(.dark) .sidebar-wrapper,
        body:not(.dark) #sidebar {
            background: linear-gradient(145deg, #faf8ff, #f3efff) !important;
            border-right: 1px solid rgba(128, 90, 200, 0.25) !important;
        }

        body:not(.dark) #content .layout-px-spacing {
            background: rgba(255, 255, 255, 0.5);
            border-radius: 28px;
            padding: 20px;
            margin: -10px -10px 0 -10px;
        }

        /* ===== البطاقات ===== */
        body:not(.dark) .card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(128, 90, 200, 0.15);
            transition: all 0.2s ease;
        }
        body:not(.dark) .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(100, 70, 150, 0.12);
            background: rgba(255, 255, 255, 0.98);
        }

        /* ===== ألوان السايدبار ===== */
        body:not(.dark) .sidebar-wrapper .menu .dropdown-toggle span {
            color: #2d2d3f;
        }
        body:not(.dark) .sidebar-wrapper .menu.active .dropdown-toggle {
            background: linear-gradient(90deg, #e9e0ff, #f5efff);
            border-radius: 12px;
        }
        body:not(.dark) .sidebar-wrapper .menu.active .dropdown-toggle span {
            color: #6b46c0;
            font-weight: 600;
        }
        body:not(.dark) .sidebar-wrapper .menu .dropdown-toggle svg {
            stroke: #6b46c0;
        }

        /* ===== باقي الأنمطة الأساسية ===== */
        body:not(.dark) .logo-light { display: block; }
        body:not(.dark) .logo-dark { display: none; }
        body.dark .logo-light { display: none; }
        body.dark .logo-dark { display: block; }
        .sidebar-wrapper * { font-family: 'Nunito', 'Cairo', sans-serif !important; }
        .sidebar-wrapper .menu .dropdown-toggle span { font-weight: 500; }
        .sidebar-wrapper .submenu li a { font-weight: 400; }

        /* Navbar margins RTL/LTR */
        @if($isRtl)
        .navbar-expand-sm .navbar-item .nav-item.language-dropdown,
        .navbar-expand-sm .navbar-item .nav-item.theme-toggle-item,
        .navbar-expand-sm .navbar-item .nav-item.notification-dropdown,
        .navbar-expand-sm .navbar-item .nav-item.user-profile-dropdown {
            margin-right: 2px !important; margin-left: 0 !important;
        }
        .navbar .theme-toggle { margin-right: 5px !important; margin-left: 0 !important; }
        .navbar .navbar-item .nav-item.dropdown.language-dropdown .dropdown-menu,
        .navbar .navbar-item .nav-item.dropdown.notification-dropdown .dropdown-menu { left: -8px !important; right: auto !important; }
        .navbar .navbar-item .nav-item.dropdown.user-profile-dropdown .dropdown-menu { left: 4px !important; right: auto !important; }
        .search-animated .badge { left: 6px; right: auto; }
        @else
        .navbar-expand-sm .navbar-item .nav-item.language-dropdown,
        .navbar-expand-sm .navbar-item .nav-item.theme-toggle-item,
        .navbar-expand-sm .navbar-item .nav-item.notification-dropdown,
        .navbar-expand-sm .navbar-item .nav-item.user-profile-dropdown {
            margin-left: 2px !important; margin-right: 0 !important;
        }
        .navbar .theme-toggle { margin-left: 5px !important; margin-right: 0 !important; }
        .navbar .navbar-item .nav-item.dropdown.language-dropdown .dropdown-menu,
        .navbar .navbar-item .nav-item.dropdown.notification-dropdown .dropdown-menu { right: -8px !important; left: auto !important; }
        .navbar .navbar-item .nav-item.dropdown.user-profile-dropdown .dropdown-menu { right: 4px !important; left: auto !important; }
        .search-animated .badge { right: 6px; left: auto; }
        @endif

        @if($isRtl)
        .main-container .sidebar-wrapper { right: 0 !important; left: auto !important; border-right: 1px solid #e0e6ed; border-left: none; }
        .main-container { direction: rtl; padding: 0 16px 0 0 !important; }
        .main-container #content { margin-left: 0 !important; margin-right: 280px !important; }
        .main-container.sidebar-closed #content { margin-right: 0 !important; }
        .header-container { right: 0 !important; left: auto !important; }
        .header.navbar { padding: 0 24px !important; direction: rtl; }
        .navbar .action-area { margin-right: auto !important; margin-left: 0 !important; }
        .navbar-expand-sm .navbar-item .nav-item.language-dropdown,
        .navbar-expand-sm .navbar-item .nav-item.theme-toggle-item,
        .navbar-expand-sm .navbar-item .nav-item.notification-dropdown { margin-left: 20px; margin-right: 0; }
        .dropdown-menu { text-align: right; }
        .sidebar-closed .sidebar-wrapper { right: -280px !important; left: auto !important; }
        .sidebar-closed .sidebar-wrapper:hover { right: 0 !important; }
        .sidebar-toggle .btn-toggle svg { transform: rotate(180deg); }
        .breadcrumb .breadcrumb-item + .breadcrumb-item::before { content: "\F104" !important; float: right !important; }
        .sidebar-wrapper ul.menu-categories li.menu > .dropdown-toggle { padding: 10.2px 16px; }
        .sidebar-wrapper ul.menu-categories li.menu > .dropdown-toggle svg:not(.badge-icon) { margin-left: 10px; margin-right: 0; }
        .sidebar-wrapper ul.menu-categories ul.submenu > li a { padding: 10px 48px 10px 12px; margin-left: 36px; margin-right: 0; }
        .sidebar-wrapper ul.menu-categories ul.submenu > li a::before { right: 13px; left: auto; }
        .sidebar-wrapper ul.menu-categories ul.submenu > li a.dropdown-toggle { padding: 10px 48px 10px 12px; margin-left: 36px; margin-right: 0; }
        .sidebar-wrapper ul.menu-categories ul.submenu li ul.sub-submenu > li a { padding: 10px 48px 10px 12px; margin-left: 56px; margin-right: 0; }
        .sidebar-wrapper ul.menu-categories li.menu > .dropdown-toggle[aria-expanded="false"] svg.feather-chevron-right { transform: rotate(180deg); }
        .sidebar-wrapper ul.menu-categories li.menu > .dropdown-toggle[aria-expanded="true"] svg.feather-chevron-right { transform: rotate(90deg); }
        .shadow-bottom { right: -4px; left: auto; }
        @else
        .main-container .sidebar-wrapper { left: 0 !important; right: auto !important; border-left: 1px solid #e0e6ed; border-right: none; }
        .main-container { direction: ltr; padding: 0 0 0 16px !important; }
        .main-container #content { margin-right: 0 !important; margin-left: 280px !important; }
        .main-container.sidebar-closed #content { margin-left: 0 !important; }
        .header-container { left: 0 !important; right: auto !important; }
        .header.navbar { padding: 0 24px !important; direction: ltr; }
        .navbar .action-area { margin-left: auto !important; margin-right: 0 !important; }
        .navbar-expand-sm .navbar-item .nav-item.language-dropdown,
        .navbar-expand-sm .navbar-item .nav-item.theme-toggle-item,
        .navbar-expand-sm .navbar-item .nav-item.notification-dropdown { margin-right: 20px; margin-left: 0; }
        .dropdown-menu { text-align: left; }
        .sidebar-closed .sidebar-wrapper { left: -280px !important; right: auto !important; }
        .sidebar-closed .sidebar-wrapper:hover { left: 0 !important; }
        .sidebar-toggle .btn-toggle svg { transform: rotate(0deg); }
        .breadcrumb .breadcrumb-item + .breadcrumb-item::before { content: "\F105" !important; float: left !important; }
        .sidebar-wrapper ul.menu-categories li.menu > .dropdown-toggle { padding: 10.2px 16px; }
        .sidebar-wrapper ul.menu-categories li.menu > .dropdown-toggle svg:not(.badge-icon) { margin-right: 10px; margin-left: 0; }
        .sidebar-wrapper ul.menu-categories ul.submenu > li a { padding: 10px 12px 10px 48px; margin-right: 36px; margin-left: 0; }
        .sidebar-wrapper ul.menu-categories ul.submenu > li a::before { left: 13px; right: auto; }
        .sidebar-wrapper ul.menu-categories ul.submenu > li a.dropdown-toggle { padding: 10px 12px 10px 48px; margin-right: 36px; margin-left: 0; }
        .sidebar-wrapper ul.menu-categories ul.submenu li ul.sub-submenu > li a { padding: 10px 12px 10px 48px; margin-right: 56px; margin-left: 0; }
        .sidebar-wrapper ul.menu-categories li.menu > .dropdown-toggle[aria-expanded="false"] svg.feather-chevron-right { transform: rotate(0deg); }
        .sidebar-wrapper ul.menu-categories li.menu > .dropdown-toggle[aria-expanded="true"] svg.feather-chevron-right { transform: rotate(90deg); }
        .shadow-bottom { left: -4px; right: auto; }
        @endif

        .secondary-nav { right: 0; left: 0; }
        .footer-wrapper { direction: ltr; }
    </style>

    @isset($scrollspy)
        @if ($scrollspy)
            @vite(['resources/scss/light/assets/scrollspyNav.scss'])
            @vite(['resources/scss/dark/assets/scrollspyNav.scss'])
        @endif
    @endisset
    @yield('styles')
</head>
<body class="
    {{ Request::routeIs('error404') ? 'error text-center' : '' }}
    {{ Request::routeIs('maintenance') ? 'maintanence text-center' : '' }}
    {{
        (Request::routeIs('boxedSignIn') ||
         Request::routeIs('boxedSignUp') ||
         Request::routeIs('boxedLockscreen') ||
         Request::routeIs('boxedPasswordReset') ||
         Request::routeIs('boxed2sv')) ? 'form' : ''
    }}
    {{
        (Request::routeIs('coverSignIn') ||
         Request::routeIs('coverSignUp') ||
         Request::routeIs('coverLockscreen') ||
         Request::routeIs('coverPasswordReset') ||
         Request::routeIs('cover2sv')) ? 'form' : ''
    }}
    {{ Request::routeIs('collapsed') ? 'alt-menu' : '' }}
" layout="{{ Request::routeIs('boxed') ? 'boxed' : '' }}">

    <!-- LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>

    @isset($simplePage)
        @if ($simplePage)
            @yield('content')
        @else
            @if (!Request::routeIs('blank'))
                @include('layouts.navbar')
            @endif

            <div class="main-container" id="container">
                <div class="overlay"></div>
                <div class="search-overlay"></div>

                @if (!Request::routeIs('blank'))
                    @include('layouts.sidebar')
                @endif

                <div id="content" class="main-content {{ Request::routeIs('blank') ? 'ms-0 mt-0' : '' }}">
                    @isset($scrollspy)
                        @if ($scrollspy)
                            <div class="container">
                                <div class="container">
                                    <div class="middle-content container-xxl p-0">
                                        @include('layouts.secondaryNav')
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="layout-px-spacing">
                                <div class="middle-content {{ Request::routeIs('boxed') ? 'container-xxl' : '' }} p-0">
                                    @if (!Request::routeIs('blank'))
                                        @include('layouts.secondaryNav')
                                    @endif
                                    @yield('content')
                                </div>
                            </div>
                        @endif
                    @endisset

                    @if (!Request::routeIs('blank'))
                        @include('layouts.footer')
                    @endif
                </div>
            </div>
        @endif
    @endisset

    <!-- Scripts -->
    <script src="{{ asset('plugins/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('plugins/src/waves/waves.min.js') }}"></script>
    <script src="{{ asset('plugins/src/highlight/highlight.pack.js') }}"></script>
    @vite(['resources/layouts/vertical-light-menu/app.js'])
    @vite(['resources/js/app.js'])

    @isset($scrollspy)
        @if ($scrollspy)
            @vite(['resources/js/scrollspyNav.js'])
        @endif
    @endisset

    @yield('scripts')
    @include('admin.partials.firebase')

</body>
</html>
