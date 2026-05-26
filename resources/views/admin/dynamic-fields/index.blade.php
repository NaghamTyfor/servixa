{{-- resources/views/admin/dynamic-fields/index.blade.php --}}
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/src/sweetalerts2/sweetalerts2.css')}}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap');

    :root {
        --pp: #7c3aed;
        --pl: #a78bfa;
        --pd: #5b21b6;
        --ps: #ede9fe;
        --pg: rgba(124,58,237,.18);
        --t: .3s cubic-bezier(.4,0,.2,1);
        --radius: 20px;
        --shadow-sm: 0 2px 8px rgba(124,58,237,.08);
        --shadow-md: 0 8px 24px rgba(124,58,237,.12);
        --shadow-lg: 0 20px 48px rgba(124,58,237,.18);
    }

.toolbar {
    display: flex;
    align-items: center;
    justify-content: flex-end;  /* جديد */
    gap: 1rem;
    margin-bottom: 1.4rem;
    min-height: 52px;           /* جديد */
    flex-wrap: wrap;
}


    * { box-sizing: border-box; }

    body { font-family: 'Sora', sans-serif; }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmer {
        0%   { background-position: -400px 0; }
        100% { background-position: 400px 0; }
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    @keyframes pulse-ring {
        0%   { box-shadow: 0 0 0 0 rgba(124,58,237,.35); }
        70%  { box-shadow: 0 0 0 10px rgba(124,58,237,0); }
        100% { box-shadow: 0 0 0 0 rgba(124,58,237,0); }
    }

    /* ========== رابط الرجوع ========== */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        color: var(--pp);
        font-weight: 600;
        font-size: .875rem;
        text-decoration: none;
        margin-bottom: 1.25rem;
        padding: .4rem .9rem .4rem .6rem;
        border-radius: 50px;
        background: var(--ps);
        transition: all var(--t);
        letter-spacing: -.01em;
    }
    .back-link:hover {
        background: var(--pp);
        color: white;
        gap: .7rem;
    }
    .back-link svg { transition: transform var(--t); }
    .back-link:hover svg { transform: translateX(-3px); }

    /* ========== الهيدر ========== */
    .page-header {
        position: relative;
        background: linear-gradient(135deg, #1a0533 0%, #3d0f8f 35%, #6d28d9 65%, #8b5cf6 100%);
        border-radius: 28px;
        padding: 2rem 2.25rem 1.75rem;
        margin-bottom: 1.75rem;
        overflow: hidden;
        box-shadow: var(--shadow-lg), inset 0 1px 0 rgba(255,255,255,.1);
        animation: slideDown .55s cubic-bezier(.22,1,.36,1) both;
    }

    .ph-bg {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background:
            radial-gradient(ellipse 60% 50% at 15% 50%, rgba(255,255,255,.06) 0%, transparent 100%),
            radial-gradient(ellipse 40% 60% at 85% 20%, rgba(167,139,250,.2) 0%, transparent 100%);
    }
    .ph-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }
    .ph-orb {
        position: absolute;
        right: -60px;
        top: -60px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(139,92,246,.35) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .ph-inner {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .ph-left {
        display: flex;
        align-items: center;
        gap: 1.1rem;
    }

    .ph-icon-wrap {
        width: 58px;
        height: 58px;
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,.22);
        flex-shrink: 0;
    }
    .ph-icon-wrap svg { width: 28px; height: 28px; stroke: white; }

    .ph-title {
        font-size: 1.9rem;
        font-weight: 800;
        color: white;
        margin: 0;
        letter-spacing: -.03em;
        line-height: 1.15;
    }
    .ph-subtitle {
        color: rgba(255,255,255,.62);
        margin: .25rem 0 0;
        font-size: .875rem;
        font-weight: 400;
    }

    /* ========== شريط الأدوات ========== */
    .toolbar {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.4rem;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 240px;
        max-width: 380px;
    }
    .search-box input {
        width: 100%;
        padding: .72rem 2.6rem .72rem 2.75rem;
        border: 1.5px solid #ddd6fe;
        border-radius: 14px;
        background: #fff;
        font-size: .875rem;
        font-family: 'Sora', sans-serif;
        color: #1e293b;
        outline: none;
        transition: all var(--t);
    }
    body.dark .search-box input {
        background: #16132a;
        border-color: rgba(124,58,237,.25);
        color: #e2e8f0;
    }
    .search-box input:focus {
        border-color: var(--pp);
        box-shadow: 0 0 0 4px var(--pg);
    }
    .search-box input::placeholder { color: #94a3b8; }
    .search-ico {
        position: absolute;
        left: .9rem;
        top: 50%;
        transform: translateY(-50%);
        color: #a78bfa;
        pointer-events: none;
        display: flex;
    }
    .search-spinner {
        position: absolute;
        right: .9rem;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
        height: 15px;
        border: 2px solid rgba(124,58,237,.15);
        border-top-color: var(--pp);
        border-radius: 50%;
        animation: spin .55s linear infinite;
        display: none;
    }

    .btn-new {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        padding: .72rem 1.6rem;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--pp), var(--pd));
        color: white;
        font-size: .875rem;
        font-weight: 700;
        font-family: 'Sora', sans-serif;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all var(--t);
        box-shadow: 0 6px 18px -4px rgba(124,58,237,.5);
        position: relative;
        overflow: hidden;
        letter-spacing: -.01em;
        white-space: nowrap;
    }
    .btn-new::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.15), transparent);
        background-size: 400px 100%;
        animation: shimmer 2.5s linear infinite;
    }
    .btn-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 26px -6px rgba(124,58,237,.6);
        color: white;
    }
    .btn-new:active { transform: translateY(0); }
    .btn-new svg { width: 16px; height: 16px; flex-shrink: 0; }

    /* ========== حاوية الجدول ========== */
    .tbl-card {
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid #ede9fe;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        animation: fadeUp .5s .1s both;
    }
    body.dark .tbl-card {
        background: #16132a;
        border-color: rgba(124,58,237,.18);
    }

    /* ========== الجدول ========== */
    .df-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .875rem;
    }

    .df-table thead tr {
        background: linear-gradient(to right, #faf5ff, #f3f0ff);
        border-bottom: 2px solid #e4d9fc;
    }
    body.dark .df-table thead tr {
        background: rgba(124,58,237,.07);
        border-bottom-color: rgba(124,58,237,.18);
    }

    .df-table th {
        padding: .9rem 1rem;
        font-size: .7rem;
        font-weight: 700;
        color: var(--pp);
        text-transform: uppercase;
        letter-spacing: .07em;
        white-space: nowrap;
    }
    .df-table th:first-child { padding-left: 1.75rem; }
    .df-table th:last-child  { padding-right: 1.75rem; text-align: right; }

    .df-table td {
        padding: .85rem 1rem;
        color: #334155;
        border-bottom: 1px solid #f3f0ff;
        vertical-align: middle;
        word-break: break-word;
    }
    body.dark .df-table td {
        color: #c4cfe0;
        border-bottom-color: rgba(124,58,237,.08);
    }
    .df-table td:first-child { padding-left: 1.75rem; }
    .df-table td:last-child  { padding-right: 1.75rem; }
    .df-table tbody tr:last-child td { border-bottom: none; }

    .df-table tbody tr {
        transition: background var(--t);
    }
    .df-table tbody tr:hover {
        background: #faf7ff;
    }
    body.dark .df-table tbody tr:hover {
        background: rgba(124,58,237,.055);
    }

    /* ID pill */
    .id-pill {
        font-family: 'JetBrains Mono', monospace;
        font-size: .75rem;
        font-weight: 600;
        color: var(--pp);
        background: var(--ps);
        padding: .2rem .6rem;
        border-radius: 6px;
        display: inline-block;
    }
    body.dark .id-pill {
        background: rgba(124,58,237,.15);
        color: var(--pl);
    }

    /* نص اللغة */
    .lang-text { font-size: .875rem; line-height: 1.5; }
    .lang-muted { color: #94a3b8; font-size: .8rem; }

    /* ========== البادجات ========== */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .22rem .75rem;
        border-radius: 30px;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .02em;
    }
    .badge-type {
        background: #f0ebff;
        color: #5b21b6;
    }
    body.dark .badge-type {
        background: rgba(124,58,237,.18);
        color: var(--pl);
    }
    .badge-req {
        background: #fde8e8;
        color: #9b1c1c;
    }
    body.dark .badge-req {
        background: rgba(220,38,38,.15);
        color: #f87171;
    }
    .badge-opt {
        background: #ecfdf5;
        color: #065f46;
    }
    body.dark .badge-opt {
        background: rgba(16,185,129,.12);
        color: #34d399;
    }

    /* ========== أزرار الإجراءات ========== */
    .row-actions {
        display: flex;
        gap: 6px;
        justify-content: flex-end;
    }
    .act-btn {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all .2s;
        background: transparent;
        flex-shrink: 0;
    }
    .act-btn svg { width: 15px; height: 15px; }
    .act-view  { background: #eef2ff; color: #4f46e5; }
    .act-view:hover  { background: #4f46e5; color: white; transform: scale(1.08); }
    .act-edit  { background: #fefce8; color: #b45309; }
    .act-edit:hover  { background: #d97706; color: white; transform: scale(1.08); }
    .act-del   { background: #fff1f2; color: #e11d48; }
    .act-del:hover   { background: #e11d48; color: white; transform: scale(1.08); }

    /* ========== حالة الفراغ ========== */
    .empty-state {
        text-align: center;
        padding: 3.5rem 1.5rem;
    }
    .empty-ring {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    body.dark .empty-ring {
        background: rgba(124,58,237,.12);
    }
    .empty-ring svg { width: 32px; height: 32px; stroke: var(--pp); opacity: .6; }
    .empty-state p {
        color: #94a3b8;
        font-size: .9rem;
        margin: 0;
    }

    /* ========== Pagination ========== */
    .pag {
        margin-top: 1.5rem;
        padding: 1rem 1rem 1.2rem;
        display: flex;
        justify-content: center;
        border-top: 1px solid #f0eeff;
    }
    body.dark .pag {
        border-top-color: rgba(124,58,237,.12);
    }
    .pag-wrap {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pag-wrap .prev, .pag-wrap .next {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: var(--ps);
        color: var(--pp);
        border: 1px solid #ddd6fe;
        text-decoration: none;
        transition: all var(--t);
        font-size: 1rem;
    }
    body.dark .pag-wrap .prev, body.dark .pag-wrap .next {
        background: rgba(124,58,237,.1);
        border-color: rgba(124,58,237,.2);
    }
    .pag-wrap .prev.disabled, .pag-wrap .next.disabled {
        opacity: 0.5;
        pointer-events: none;
        background: #f1f5f9;
        color: #9ca3af;
        border-color: #e2e8f0;
    }
    .pag-wrap .prev:hover:not(.disabled), .pag-wrap .next:hover:not(.disabled) {
        background: var(--pp);
        color: white;
        border-color: var(--pp);
        transform: translateY(-2px);
    }
    .pag-wrap ul {
        display: flex;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .pag-wrap ul li a, .pag-wrap ul li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 8px;
        border-radius: 12px;
        background: #fff;
        color: #1e293b;
        border: 1px solid #e9e4ff;
        transition: all var(--t);
        text-decoration: none;
        font-weight: 600;
        font-size: .85rem;
    }
    body.dark .pag-wrap ul li a {
        background: #1e1b2e;
        color: #e2e8f0;
        border-color: rgba(124,58,237,.2);
    }
    .pag-wrap ul li a:hover {
        background: var(--ps);
        color: var(--pp);
        border-color: var(--pp);
        transform: translateY(-2px);
    }
    .pag-wrap ul li a.active {
        background: linear-gradient(135deg, var(--pp), var(--pd));
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 10px var(--pg);
        font-weight: 700;
    }

    /* ========== تجاوب ========== */
    @media (max-width: 640px) {
        .ph-title { font-size: 1.4rem; }
        .ph-stats  { gap: .4rem; }
        .ph-stat   { min-width: 72px; padding: .5rem .75rem; }
        .ph-stat-n { font-size: 1.3rem; }
        .tbl-card  { border-radius: 14px; }
        .toolbar   { gap: .6rem; }
        .df-table th, .df-table td { padding: 0.7rem 0.5rem; }
        .df-table th:first-child, .df-table td:first-child { padding-left: 0.8rem; }
        .df-table th:last-child, .df-table td:last-child { padding-right: 0.8rem; }
        .row-actions { gap: 3px; }
        .act-btn { width: 30px; height: 30px; }
    }
</style>
@endsection

@section('content')
<div class="layout-top-spacing">

    {{-- رابط الرجوع --}}
    <a href="{{ $ownerType === 'category'
        ? route('admin.categories.show', $owner)
        : route('admin.categories.sub-categories.show', [$parentCategory, $owner]) }}"
       class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        {{ __('admin.back_to_details') }}
    </a>

    {{-- الهيدر --}}
    <div class="page-header">
        <div class="ph-bg"></div>
        <div class="ph-grid"></div>
        <div class="ph-orb"></div>
        <div class="ph-inner">
            <div class="ph-left">
                <div class="ph-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <div>
                    <h1 class="ph-title">{{ __('admin.dynamic_fields') }}</h1>
                    <p class="ph-subtitle">
                        {{ $owner->getTranslation('name', app()->getLocale()) }}
                        &mdash;
                        {{ $ownerType === 'category' ? __('admin.category') : __('admin.sub_category') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- شريط الأدوات --}}
    <div class="toolbar">


        @can('dynamic_fields.create')
        <a href="{{ $ownerType === 'category'
            ? route('admin.categories.dynamic-fields.create', $owner)
            : route('admin.categories.sub-categories.dynamic-fields.create', [$parentCategory, $owner]) }}"
           class="btn-new">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            {{ __('admin.add_dynamic_field') }}
        </a>
        @endcan
    </div>

    {{-- الجدول --}}
    <div class="tbl-card" id="tblWrap">
        @include('admin.dynamic-fields.partials.table')
    </div>
</div>

<form id="delForm" method="POST" style="display:none">@csrf @method('DELETE')</form>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script>
const searchInput   = document.getElementById('searchInput');
const searchSpinner = document.getElementById('searchSpinner');
const tblWrap       = document.getElementById('tblWrap');
const delForm       = document.getElementById('delForm');
let searchTimeout;

function isDark() { return document.body.classList.contains('dark'); }

function bindDeleteButtons() {
    document.querySelectorAll('.act-del').forEach(btn => {
        btn.removeEventListener('click', deleteHandler);
        btn.addEventListener('click', deleteHandler);
    });
}

function deleteHandler(e) {
    e.preventDefault();
    const name = this.dataset.name;
    const url  = this.dataset.url;
    Swal.fire({
        title: '{{ __('admin.confirm_delete') }}',
        text:  '{{ __('admin.delete_confirm_msg') }}: ' + name,
        icon:  'warning',
        showCancelButton:    true,
        confirmButtonColor:  '#e11d48',
        cancelButtonColor:   '#7c3aed',
        confirmButtonText:   '{{ __('admin.delete') }}',
        cancelButtonText:    '{{ __('admin.cancel') }}',
        reverseButtons:      true,
        background: isDark() ? '#16132a' : '#fff',
        color:      isDark() ? '#e2e8f0' : '#1e293b',
    }).then(result => {
        if (result.isConfirmed) {
            delForm.action = url;
            delForm.submit();
        }
    });
}

function performSearch() {
    const query = searchInput.value.trim();
    const url = new URL(window.location.href);
    if (query) {
        url.searchParams.set('search', query);
    } else {
        url.searchParams.delete('search');
    }
    url.searchParams.set('page', '1'); // reset to first page
    window.history.pushState({}, '', url.toString());

    fetch(url.toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newTblWrap = doc.getElementById('tblWrap');
        if (newTblWrap) {
            tblWrap.innerHTML = newTblWrap.innerHTML;
        }
        bindDeleteButtons(); // reattach delete handlers
        searchSpinner.style.display = 'none';
    })
    .catch(error => {
        console.error('Search error:', error);
        searchSpinner.style.display = 'none';
    });
}

if (searchInput) {
    searchInput.addEventListener('input', function() {
        searchSpinner.style.display = 'block';
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 400);
    });
}

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const searchVal = new URLSearchParams(window.location.search).get('search') || '';
    if (searchInput) searchInput.value = searchVal;
    performSearch();
});

document.addEventListener('DOMContentLoaded', function() {
    bindDeleteButtons();

    @if(session('success'))
    Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: t => {
            t.addEventListener('mouseenter', Swal.stopTimer);
            t.addEventListener('mouseleave', Swal.resumeTimer);
        }
    }).fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif
});
</script>
@endsection
