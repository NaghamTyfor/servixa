@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/src/sweetalerts2/sweetalerts2.css')}}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite([
        'resources/scss/light/assets/elements/custom-pagination.scss',
        'resources/scss/dark/assets/elements/custom-pagination.scss'
    ])
    <style>
        :root {
            --primary-purple: #7c3aed;
            --purple-light: #a78bfa;
            --purple-dark: #5b21b6;
            --purple-soft: #ede9fe;
            --purple-glow: rgba(124,58,237,0.22);
            --card-radius: 24px;
            --transition: 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to   { opacity: 1; transform: scale(1); }
        }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes spinAnim {
            to { transform: translateY(-50%) rotate(360deg); }
        }

        /* Modern Header */
        .page-header-modern {
            position: relative;
            background: linear-gradient(135deg, #2e1065 0%, #5b21b6 40%, #7c3aed 80%, #a78bfa 100%);
            border-radius: 32px;
            padding: 2rem 2.5rem;
            margin-bottom: 2.5rem;
            overflow: hidden;
            box-shadow: 0 20px 40px -15px rgba(124,58,237,0.3);
            animation: slideUp 0.6s cubic-bezier(0.22,1,0.36,1);
        }
        .header-bg-pattern {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image:
                radial-gradient(circle at 30% 40%, rgba(255,255,255,0.08) 0%, transparent 30%),
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
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .header-text p {
            color: rgba(255,255,255,0.7);
            margin: 0.3rem 0 0;
            font-size: 0.95rem;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
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
            transition: all var(--transition);
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
            animation: spinAnim 0.6s linear infinite;
            display: none;
        }

        /* Reports Grid (Cards) */
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
        }
        .report-card {
            background: #fff;
            border: 1.5px solid #f0eeff;
            border-radius: var(--card-radius);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: scaleIn 0.5s ease both;
            cursor: pointer;
        }
        body.dark .report-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }
        .report-card:hover {
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
        .report-card:hover .card-accent-bar {
            transform: scaleX(1);
        }
        .report-card-header {
            padding: 1.2rem 1.2rem 0.5rem;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }
        .report-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            background: var(--purple-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        body.dark .report-icon-wrapper {
            background: rgba(124,58,237,0.2);
        }
        .report-icon-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--purple-dark), var(--primary-purple));
            transform: scale(0);
            transition: transform 0.3s ease;
        }
        .report-card:hover .report-icon-wrapper::before {
            transform: scale(1);
        }
        .report-icon-wrapper svg {
            color: var(--primary-purple);
            transition: color 0.3s;
            position: relative;
            z-index: 1;
            width: 24px;
            height: 24px;
        }
        .report-card:hover .report-icon-wrapper svg {
            color: #fff;
        }
        .report-badge {
            background: var(--purple-soft);
            color: var(--purple-dark);
            padding: 0.25rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .report-content {
            padding: 0.5rem 1.2rem 0.8rem;
        }
        .info-row-card {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            padding: 0.5rem 0;
            border-bottom: 1px dashed #f0eeff;
        }
        .info-row-card:last-child {
            border-bottom: none;
        }
        .info-label-card {
            min-width: 70px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--purple-light);
        }
        .info-value-card {
            flex: 1;
            font-size: 0.85rem;
            font-weight: 500;
            color: #1e293b;
            word-break: break-word;
        }
        body.dark .info-value-card {
            color: #cbd5e1;
        }
        .reason-badge-card {
            background: var(--purple-soft);
            color: var(--purple-dark);
            padding: 0.2rem 0.8rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        .report-date {
            font-size: 0.7rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.5rem;
        }
        .report-card-footer {
            padding: 0.8rem 1.2rem;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            border-top: 1px solid #f5f3ff;
            background: #fafafe;
        }
        body.dark .report-card-footer {
            border-color: rgba(124,58,237,0.15);
            background: rgba(255,255,255,0.02);
        }
        .card-actions {
            display: flex;
            gap: 0.5rem;
        }
        .action-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
        .action-view {
            background: #eff6ff;
            color: #3b82f6;
        }
        .action-view:hover {
            background: #3b82f6;
            color: white;
        }
        .action-delete {
            background: #fef2f2;
            color: #dc2626;
        }
        .action-delete:hover {
            background: #dc2626;
            color: white;
        }

        /* Empty state */
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

        /* Pagination */
        .pagination-custom_solid {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
            margin-top: 2rem;
        }
        mark {
            background: rgba(250,204,21,0.3);
            border-radius: 3px;
            padding: 0 2px;
        }
        body.dark mark {
            background: rgba(250,204,21,0.25);
            color: #fbbf24;
        }
    </style>
@endsection

@section('content')
<div class="layout-top-spacing">
    <div class="page-header-modern">
        <div class="header-bg-pattern"></div>
        <div class="header-content">
            <div class="header-title-area">
                <div class="header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.reports') }}</h1>
                    <p>{{ __('admin.reports_management') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="toolbar">
        <div class="toolbar-search">
            <div class="search-ico">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="{{ __('admin.search_reports') }}..." autocomplete="off">
            <div class="search-spinner" id="searchSpinner"></div>
        </div>
    </div>

    <div id="reportsContainer">
        @include('admin.reports.partials.grid')
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script src="{{asset('plugins/src/sweetalerts2/custom-sweetalert.js')}}"></script>
<script>
    let searchInput = document.getElementById('searchInput');
    let searchSpinner = document.getElementById('searchSpinner');
    let container = document.getElementById('reportsContainer');
    let searchTimeout;
    let deleteForm = document.getElementById('deleteForm');

    function performSearch(val) {
        let url = new URL('{{ route('admin.reports.index') }}');
        if (val) url.searchParams.set('search', val);
        else url.searchParams.delete('search');
        url.searchParams.set('page', '1');
        window.history.pushState({}, '', url.toString());
        fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => {
                let doc = new DOMParser().parseFromString(html, 'text/html');
                let newContainer = doc.getElementById('reportsContainer');
                if (newContainer) container.innerHTML = newContainer.innerHTML;
                rebindEvents();
                highlightSearch();
                if (searchSpinner) searchSpinner.style.display = 'none';
            })
            .catch(() => {
                if (searchSpinner) searchSpinner.style.display = 'none';
            });
    }

    function highlightSearch() {
        let term = new URLSearchParams(window.location.search).get('search');
        if (!term) return;
        let rx = new RegExp(`(${term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
        document.querySelectorAll('.user-name-card, .service-title-card, .reason-badge-card').forEach(el => {
            el.innerHTML = el.innerText.replace(rx, '<mark>$1</mark>');
        });
    }

    function rebindEvents() {
        document.querySelectorAll('.action-delete').forEach(btn => {
            btn.removeEventListener('click', deleteHandler);
            btn.addEventListener('click', deleteHandler);
        });
        document.querySelectorAll('.report-card').forEach(card => {
            card.removeEventListener('click', cardClickHandler);
            card.addEventListener('click', cardClickHandler);
        });
        // Re-init tooltips
        if (typeof bootstrap !== 'undefined') {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
        }
    }

    function cardClickHandler(e) {
        if (e.target.closest('.action-icon-btn, .action-delete, a, button')) return;
        const url = this.dataset.url;
        if (url) window.location.href = url;
    }

    function deleteHandler(e) {
        e.preventDefault();
        e.stopPropagation();
        let btn = this;
        Swal.fire({
            title: '{{ __('admin.confirm_delete') }}',
            text: '{{ __('admin.delete_report_confirm') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#7c3aed',
            confirmButtonText: '{{ __('admin.delete') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            reverseButtons: true,
            background: document.body.classList.contains('dark') ? '#1e1b2e' : '#fff',
            color: document.body.classList.contains('dark') ? '#e2e8f0' : '#1e293b',
        }).then(r => {
            if (r.isConfirmed) {
                deleteForm.action = btn.dataset.deleteUrl;
                deleteForm.submit();
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            if (searchSpinner) searchSpinner.style.display = 'block';
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => performSearch(this.value.trim()), 300);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        rebindEvents();
        highlightSearch();
        @if(session('success'))
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
        }).fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif
    });

    window.addEventListener('popstate', () => {
        let val = new URLSearchParams(window.location.search).get('search') || '';
        if (searchInput) searchInput.value = val;
        performSearch(val);
    });
</script>
@endsection
