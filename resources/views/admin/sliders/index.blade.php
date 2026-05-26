{{-- resources/views/admin/sliders/index.blade.php --}}
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
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .header-text p {
            color: rgba(255,255,255,0.7);
            margin: 0.3rem 0 0;
            font-size: 0.95rem;
        }

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
            animation: spin 0.6s linear infinite;
            display: none;
        }

        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.7rem 1.8rem;
            border-radius: 60px;
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-dark));
            color: #fff;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 8px 18px -6px var(--primary-purple);
            transition: all var(--transition);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px var(--primary-purple);
        }

        .sliders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
        }

        .slider-card {
            background: #fff;
            border: 1.5px solid #f0eeff;
            border-radius: var(--card-radius);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: scaleIn 0.5s ease both;
        }

        body.dark .slider-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }

        .slider-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -10px var(--purple-glow);
            border-color: var(--purple-light);
        }

        .slider-image {
            height: 160px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .slider-image-placeholder {
            height: 160px;
            background: linear-gradient(135deg, #a78bfa, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .slider-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            border-radius: 20px;
            padding: 0.25rem 0.8rem;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
        }

        .badge-active {
            background: #10b981;
        }

        .badge-inactive {
            background: #ef4444;
        }

        .slider-content {
            padding: 1.2rem;
        }

        .slider-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e1b4b;
            margin-bottom: 0.5rem;
        }

        body.dark .slider-title {
            color: #e2e8f0;
        }

        .slider-meta {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.75rem;
            color: #94a3b8;
            margin-bottom: 0.5rem;
            flex-wrap: wrap;
        }

        .slider-meta svg {
            width: 14px;
            height: 14px;
        }

        .slider-link {
            font-size: 0.8rem;
            color: var(--primary-purple);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.5rem;
        }

        .slider-link:hover {
            text-decoration: underline;
        }

        .card-actions {
            display: flex;
            gap: 0.5rem;
            padding: 0.8rem 1.2rem 1.2rem;
            border-top: 1px solid #f5f3ff;
        }

        body.dark .card-actions {
            border-top-color: rgba(124,58,237,0.15);
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
        .action-edit {
            background: #f0fdf4;
            color: #16a34a;
        }
        .action-edit:hover {
            background: #16a34a;
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
        /* Bilingual names styling for sliders (same as cities) */
.names-bilingual {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border: 1px solid #f0eeff;
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 0.75rem;
}
body.dark .names-bilingual {
    border-color: rgba(124,58,237,0.2);
}
.name-col {
    padding: 0.6rem 0.8rem;
}
.name-col-ar {
    border-inline-end: 1px solid #f0eeff;
    background: #fafafe;
}
body.dark .name-col-ar {
    border-inline-end-color: rgba(124,58,237,0.2);
    background: rgba(255,255,255,0.02);
}
.name-col-en {
    background: #fff;
}
body.dark .name-col-en {
    background: rgba(255,255,255,0.03);
}
.name-lang-tag {
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--purple-light);
    display: block;
    margin-bottom: 0.2rem;
}
.slider-name-text {
    font-size: 0.95rem;
    font-weight: 700;
    line-height: 1.4;
    color: #1e1b4b;
    margin: 0;
}
body.dark .slider-name-text {
    color: #e2e8f0;
}
.name-col-ar .slider-name-text {
    direction: rtl;
    text-align: right;
}
.name-col-en .slider-name-text {
    direction: ltr;
    text-align: left;
}
/* تحسين تظليل البحث ليشمل النصين */
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
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="M8 12h8"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.sliders') }}</h1>
                    <p>{{ __('admin.sliders_management') }}</p>
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
            <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="{{ __('admin.search_sliders') }}..." autocomplete="off">
            <div class="search-spinner" id="searchSpinner"></div>
        </div>
        <a href="{{ route('admin.sliders.create') }}" class="btn-add">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            {{ __('admin.add_slider') }}
        </a>
    </div>

    <div id="slidersContainer">
        @include('admin.sliders.partials.grid')
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
    let container = document.getElementById('slidersContainer');
    let searchTimeout;
    let deleteForm = document.getElementById('deleteForm');

    function performSearch(val) {
        let url = new URL('{{ route('admin.sliders.index') }}');
        if (val) url.searchParams.set('search', val);
        else url.searchParams.delete('search');
        url.searchParams.set('page', '1');
        window.history.pushState({}, '', url.toString());
        fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => {
                let doc = new DOMParser().parseFromString(html, 'text/html');
                let newContainer = doc.getElementById('slidersContainer');
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
    document.querySelectorAll('.slider-name-text').forEach(el => {
        el.innerHTML = el.innerText.replace(rx, '<mark>$1</mark>');
    });
}

    function rebindEvents() {
        document.querySelectorAll('.action-delete').forEach(btn => {
            btn.removeEventListener('click', deleteHandler);
            btn.addEventListener('click', deleteHandler);
        });
    }

    function deleteHandler(e) {
        e.preventDefault();
        e.stopPropagation();
        let btn = this;
        Swal.fire({
            title: '{{ __('admin.confirm_delete') }}',
            text: '{{ __('admin.delete_confirm_msg') }}: ' + btn.dataset.sliderTitle,
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
