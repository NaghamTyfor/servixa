@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/src/sweetalerts2/sweetalerts2.css') }}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
    <style>
        :root {
            --primary-purple: #7c3aed;
            --purple-light: #a78bfa;
            --purple-dark: #5b21b6;
            --purple-soft: #ede9fe;
            --purple-glow: rgba(124, 58, 237, 0.22);
            --card-radius: 24px;
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Animations */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to   { opacity: 1; transform: scale(1); }
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        /* Modern Header */
        .page-header-modern {
            position: relative;
            background: linear-gradient(135deg, #2e1065 0%, #5b21b6 40%, #7c3aed 80%, #a78bfa 100%);
            border-radius: 32px;
            padding: 2rem 2.5rem;
            margin-bottom: 2.5rem;
            overflow: hidden;
            box-shadow: 0 20px 40px -15px rgba(124, 58, 237, 0.3);
            animation: slideUp 0.6s cubic-bezier(0.22, 1, 0.36, 1);
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
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .header-icon svg {
            width: 32px;
            height: 32px;
            stroke: white;
            stroke-width: 1.8;
        }

        .header-text h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            margin: 0;
            letter-spacing: -0.02em;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .header-text p {
            color: rgba(255,255,255,0.7);
            margin: 0.3rem 0 0;
            font-size: 0.95rem;
        }

        /* Toolbar */
        .services-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
            flex-wrap: wrap;
        }

        .toolbar-search {
            position: relative;
            min-width: 260px;
            flex: 1;
            max-width: 360px;
        }

        .toolbar-search input {
            width: 100%;
            border-radius: 12px;
            padding: 0.7rem 2.8rem 0.7rem 2.8rem;
            border: 2px solid #e0d4fd;
            background: #fff;
            font-size: 0.9rem;
            color: #1e293b;
            transition: all var(--transition);
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            outline: none;
        }

        body.dark .toolbar-search input {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.3);
            color: #e2e8f0;
        }

        .toolbar-search input:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 4px var(--purple-glow);
        }

        .search-ico {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a78bfa;
            pointer-events: none;
        }

        .search-spinner {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            border: 2px solid rgba(124,58,237,0.2);
            border-top-color: var(--primary-purple);
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }

        .form-select-custom {
            border-radius: 12px;
            background: var(--purple-soft);
            border-color: #ddd6fe;
            padding: 0.5rem 2rem 0.5rem 1rem;
            font-size: 0.9rem;
            cursor: pointer;
        }

        /* Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .service-card {
            background: #fff;
            border: 1.5px solid #f0eeff;
            border-radius: var(--card-radius);
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: scaleIn 0.5s ease both;
            box-shadow: 0 6px 14px rgba(0,0,0,0.02);
        }

        body.dark .service-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }

        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -10px var(--purple-glow);
            border-color: var(--purple-light);
        }

        .card-accent-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--purple-dark), var(--primary-purple), var(--purple-light));
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .service-card:hover .card-accent-bar {
            transform: scaleX(1);
        }

        .service-card-header {
            padding: 1.2rem 1.2rem 0.5rem;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .service-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: var(--purple-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body.dark .service-icon-wrapper {
            background: rgba(124,58,237,0.2);
        }

        .service-icon-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--purple-dark), var(--primary-purple));
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        .service-card:hover .service-icon-wrapper::before {
            transform: scale(1);
        }

        .service-icon-wrapper svg {
            color: var(--primary-purple);
            position: relative;
            z-index: 1;
            width: 24px;
            height: 24px;
        }

        .service-card:hover .service-icon-wrapper svg {
            color: #fff;
        }

        .badge-status {
            display: inline-block;
            padding: 0.25rem 0.8rem;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }
        .badge-suspended { background: #fed7aa; color: #9b4d00; }

        .service-title {
            padding: 0.3rem 1.2rem 0.5rem;
            font-size: 1rem;
            font-weight: 700;
            color: #1e1b4b;
            margin: 0;
        }

        body.dark .service-title { color: #e2e8f0; }

        .service-description {
            padding: 0 1.2rem 0.5rem;
            font-size: 0.8rem;
            color: #6b7280;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .service-card-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            padding: 0.7rem 1.2rem;
            border-top: 1px solid #f5f3ff;
        }

        .stat-chip {
            background: #fafafe;
            border: 1px solid #f0eeff;
            border-radius: 12px;
            padding: 0.6rem 0.5rem;
            text-align: center;
            transition: all 0.2s;
        }

        .service-card:hover .stat-chip {
            background: var(--purple-soft);
            border-color: #ddd6fe;
        }

        .stat-chip-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--primary-purple);
            display: block;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stat-chip-label {
            font-size: 0.6rem;
            color: #9ca3af;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .service-card-footer {
            padding: 0.8rem 1.2rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            border-top: 1px solid #f5f3ff;
            background: #fafafe;
        }

        .action-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            text-decoration: none;
            background: #eff6ff;
            color: #3b82f6;
        }

        .action-icon-btn:hover {
            background: #3b82f6;
            color: white;
            transform: scale(1.05);
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 90px;
            height: 90px;
            background: var(--purple-soft);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .empty-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        mark {
            background: rgba(250,204,21,0.3);
            color: #854d0e;
            border-radius: 3px;
            padding: 0 2px;
        }

        /* Pagination */
        .pagination-custom_solid {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 2rem;
            justify-content: center;
        }

        .pagination-custom_solid .prev,
        .pagination-custom_solid .next {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--purple-soft);
            color: var(--primary-purple);
            border: 1px solid #ddd6fe;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .pagination-custom_solid ul.pagination {
            display: flex;
            gap: 6px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pagination-custom_solid ul.pagination li a,
        .pagination-custom_solid ul.pagination li span {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #fff;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: 600;
        }

        body.dark .pagination-custom_solid ul.pagination li a {
            background-color: #1e1b2e;
            color: #e2e8f0;
        }

        .pagination-custom_solid ul.pagination li a.active {
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-dark));
            color: #fff;
        }

        .pagination-custom_solid .prev:hover:not(.disabled),
        .pagination-custom_solid .next:hover:not(.disabled),
        .pagination-custom_solid ul.pagination li a:hover:not(.active) {
            background-color: var(--purple-soft);
            color: var(--primary-purple);
        }
    </style>
@endsection

@section('content')
<div class="layout-top-spacing">
    <!-- Modern Header -->
    <div class="page-header-modern">
        <div class="header-bg-pattern"></div>
        <div class="header-content">
            <div class="header-title-area">
                <div class="header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect>
                        <line x1="9" y1="2" x2="9" y2="22"></line>
                        <line x1="15" y1="2" x2="15" y2="22"></line>
                        <line x1="2" y1="9" x2="22" y2="9"></line>
                        <line x1="2" y1="15" x2="22" y2="15"></line>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.services') }}</h1>
                    <p>{{ __('admin.services_management') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="services-toolbar">
        <div class="toolbar-left">
            <div class="toolbar-search">
                <div class="search-ico">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="{{ __('admin.search_services') }}..." autocomplete="off">
                <div class="search-spinner" id="searchSpinner"></div>
            </div>

            <select id="statusFilter" class="form-select-custom">
                <option value="">{{ __('admin.all_statuses') }}</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('admin.pending') }}</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('admin.approved') }}</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('admin.rejected') }}</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>{{ __('admin.suspended') }}</option>
            </select>
        </div>
    </div>

    <!-- Services Grid Container -->
    <div id="servicesGridContainer">
        @include('admin.services.partials.grid', ['services' => $services])
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
<script>
    (function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const searchSpinner = document.getElementById('searchSpinner');
        const gridContainer = document.getElementById('servicesGridContainer');
        let searchTimeout;

        // دالة جلب الخدمات عبر AJAX
        function fetchServices(search, status, page = 1) {
            const params = new URLSearchParams();
            if (search) params.set('search', search);
            if (status) params.set('status', status);
            if (page > 1) params.set('page', page);
            params.set('ajax', '1');

            const url = '{{ route("admin.services.index") }}?' + params.toString();

            // تحديث عنوان URL في المتصفح
            const newUrl = '{{ route("admin.services.index") }}' + (params.toString() ? '?' + params.toString() : '');
            window.history.pushState({}, '', newUrl);

            if (searchSpinner) searchSpinner.style.display = 'block';

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                if (gridContainer) {
                    gridContainer.innerHTML = html;
                    bindCardEvents();
                    highlightSearchTerm(search);
                }
                if (searchSpinner) searchSpinner.style.display = 'none';
            })
            .catch(error => {
                console.error('Fetch error:', error);
                if (searchSpinner) searchSpinner.style.display = 'none';
            });
        }

        // تمييز كلمة البحث
        function highlightSearchTerm(term) {
            if (!term) return;
            const regex = new RegExp(`(${term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            document.querySelectorAll('.service-title, .service-description').forEach(el => {
                el.innerHTML = el.innerText.replace(regex, '<mark>$1</mark>');
            });
        }

        // جعل البطاقة قابلة للنقر
        function bindCardEvents() {
            document.querySelectorAll('.service-card').forEach(card => {
                card.removeEventListener('click', cardClickHandler);
                card.addEventListener('click', cardClickHandler);
            });

            if (typeof bootstrap !== 'undefined') {
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                    new bootstrap.Tooltip(el);
                });
            }
        }

        function cardClickHandler(e) {
            if (e.target.closest('a, button, .action-icon-btn, .service-card-footer a')) return;
            const url = this.dataset.url;
            if (url) window.location.href = url;
        }

        // معالجة تغيير البحث
        function onSearchInput() {
            if (searchTimeout) clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchServices(searchInput.value.trim(), statusFilter.value, 1);
            }, 300);
        }

        function onStatusChange() {
            fetchServices(searchInput.value.trim(), statusFilter.value, 1);
        }

        // استخدام التفويض (delegation) لالتقاط النقر على روابط التصفح
        function setupPaginationDelegation() {
            if (!gridContainer) return;
            gridContainer.addEventListener('click', function(e) {
                const link = e.target.closest('.pagination-custom_solid a');
                if (!link) return;

                const href = link.getAttribute('href');
                // تجاهل الروابط التي لا تحتوي على href حقيقي أو التي تحمل الفئة active
                if (!href || href === 'javascript:void(0);' || link.classList.contains('active')) {
                    e.preventDefault();
                    return;
                }

                e.preventDefault();

                // استخراج رقم الصفحة من الرابط
                let page = 1;
                try {
                    const url = new URL(href, window.location.origin);
                    page = url.searchParams.get('page') || 1;
                } catch (e) {
                    // إذا لم يكن الرابط صالحاً، نستخرج الرقم من البيانات المباشرة
                    const pageAttr = link.getAttribute('data-page');
                    if (pageAttr) page = pageAttr;
                }

                const search = searchInput ? searchInput.value.trim() : '';
                const status = statusFilter ? statusFilter.value : '';
                fetchServices(search, status, page);
            });
        }

        // الاستماع لتغير عنوان URL (أزرار الرجوع/التقدم)
        window.addEventListener('popstate', function() {
            const params = new URLSearchParams(window.location.search);
            const search = params.get('search') || '';
            const status = params.get('status') || '';
            if (searchInput) searchInput.value = search;
            if (statusFilter) statusFilter.value = status;
            fetchServices(search, status, params.get('page') || 1);
        });

        // ربط الأحداث
        if (searchInput) searchInput.addEventListener('input', onSearchInput);
        if (statusFilter) statusFilter.addEventListener('change', onStatusChange);

        document.addEventListener('DOMContentLoaded', function() {
            bindCardEvents();
            setupPaginationDelegation();
            const initialSearch = searchInput ? searchInput.value.trim() : '';
            if (initialSearch) highlightSearchTerm(initialSearch);

            @if(session('success'))
            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).fire({ icon: 'success', title: '{{ session('success') }}' });
            @endif
        });
    })();
</script>
@endsection
