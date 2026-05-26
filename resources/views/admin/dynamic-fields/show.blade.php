{{-- resources/views/admin/dynamic-fields/show.blade.php --}}
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
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(.97); }
        to   { opacity: 1; transform: scale(1); }
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
    }
    .back-link:hover { background: var(--pp); color: white; gap: .7rem; }
    .back-link svg { transition: transform var(--t); }
    .back-link:hover svg { transform: translateX(-3px); }

    /* ========== الهيدر ========== */
    .page-header {
        position: relative;
        background: linear-gradient(135deg, #1a0533 0%, #3d0f8f 35%, #6d28d9 65%, #8b5cf6 100%);
        border-radius: 28px;
        padding: 2rem 2.25rem;
        margin-bottom: 2rem;
        overflow: hidden;
        box-shadow: 0 20px 48px rgba(124,58,237,.22), inset 0 1px 0 rgba(255,255,255,.1);
        animation: slideDown .55s cubic-bezier(.22,1,.36,1) both;
    }
    .ph-bg {
        position: absolute; inset: 0; pointer-events: none;
        background:
            radial-gradient(ellipse 60% 50% at 15% 50%, rgba(255,255,255,.06) 0%, transparent 100%),
            radial-gradient(ellipse 40% 60% at 85% 20%, rgba(167,139,250,.2) 0%, transparent 100%);
    }
    .ph-grid {
        position: absolute; inset: 0;
        background-image: linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                          linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }
    .ph-orb {
        position: absolute; right: -60px; top: -60px;
        width: 240px; height: 240px;
        background: radial-gradient(circle, rgba(139,92,246,.35) 0%, transparent 70%);
        border-radius: 50%; pointer-events: none;
    }
    .ph-inner {
        position: relative; z-index: 2;
        display: flex; align-items: flex-start;
        justify-content: space-between;
        gap: 1.5rem; flex-wrap: wrap;
    }
    .ph-left { display: flex; align-items: center; gap: 1.1rem; }
    .ph-icon {
        width: 58px; height: 58px;
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid rgba(255,255,255,.22);
        flex-shrink: 0;
    }
    .ph-icon svg { width: 28px; height: 28px; stroke: white; }
    .ph-title { font-size: 1.9rem; font-weight: 800; color: white; margin: 0; letter-spacing: -.03em; line-height: 1.15; }
    .ph-sub   { color: rgba(255,255,255,.6); margin: .25rem 0 0; font-size: .875rem; }

    /* أزرار الهيدر */
    .ph-actions { display: flex; gap: .6rem; flex-wrap: wrap; margin-top: .5rem; }
    .btn-hdr {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1.3rem;
        border-radius: 50px;
        font-size: .84rem; font-weight: 600; font-family: 'Sora', sans-serif;
        cursor: pointer; border: none; text-decoration: none;
        transition: all .2s; white-space: nowrap;
    }
    .btn-hdr svg { width: 15px; height: 15px; }
    .btn-hdr-edit {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.22);
        color: white;
        backdrop-filter: blur(6px);
    }
    .btn-hdr-edit:hover { background: rgba(255,255,255,.26); transform: translateY(-2px); color: white; }
    .btn-hdr-del {
        background: rgba(244,63,94,.14);
        border: 1px solid rgba(244,63,94,.28);
        color: #fda4af;
    }
    .btn-hdr-del:hover { background: #e11d48; color: white; transform: translateY(-2px); }

    /* إحصائيات الهيدر */
    .ph-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: .6rem;
        margin-top: 1.5rem;
    }
    @media (min-width: 640px) { .ph-stats { grid-template-columns: repeat(4, 1fr); } }

    .ph-stat {
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.13);
        backdrop-filter: blur(8px);
        border-radius: 16px;
        padding: .9rem 1rem;
        display: flex; align-items: center; gap: .8rem;
        transition: background .2s;
        animation: scaleIn .4s both;
    }
    .ph-stat:hover { background: rgba(255,255,255,.13); }
    .ph-stat-ico {
        width: 40px; height: 40px;
        background: rgba(255,255,255,.12);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ph-stat-ico svg { width: 20px; height: 20px; stroke: white; }
    .ph-stat-lbl { font-size: .65rem; font-weight: 500; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .06em; }
    .ph-stat-val { font-size: 1.1rem; font-weight: 700; color: white; line-height: 1.2; margin-top: 2px; }

    /* ========== شبكة المحتوى ========== */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
        animation: fadeUp .5s .1s both;
    }
    @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }

    /* ========== البطاقة الرئيسية ========== */
    .main-card {
        background: #fff;
        border-radius: 22px;
        border: 1px solid #ede9fe;
        box-shadow: 0 8px 24px rgba(124,58,237,.1);
        overflow: hidden;
    }
    body.dark .main-card { background: #16132a; border-color: rgba(124,58,237,.18); }

    .card-hdr {
        display: flex; align-items: center; gap: .75rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(to right, #faf5ff, #f5f0ff);
        border-bottom: 1px solid #e9e0fc;
    }
    body.dark .card-hdr { background: rgba(124,58,237,.06); border-bottom-color: rgba(124,58,237,.15); }
    .card-hdr-ico {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, var(--pp), var(--pd));
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .card-hdr-ico svg { width: 17px; height: 17px; stroke: white; }
    .card-hdr-title { font-weight: 700; font-size: .95rem; color: #1e293b; margin: 0; }
    body.dark .card-hdr-title { color: #e2e8f0; }

    /* جدول المعلومات */
    .info-tbl { width: 100%; border-collapse: collapse; }
    .info-tbl tr { border-bottom: 1px solid #f3f0ff; }
    body.dark .info-tbl tr { border-bottom-color: rgba(124,58,237,.08); }
    .info-tbl tr:last-child { border-bottom: none; }
    .info-tbl td { padding: .9rem 1.4rem; vertical-align: middle; }
    .info-lbl {
        width: 130px; font-size: .78rem; font-weight: 700;
        color: var(--pp); text-transform: uppercase; letter-spacing: .04em;
        white-space: nowrap;
    }
    body.dark .info-lbl { color: var(--pl); }
    .info-val { color: #334155; font-size: .9rem; }
    body.dark .info-val { color: #c4cfe0; }

    /* بادجات */
    .badge {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .23rem .8rem;
        border-radius: 30px; font-size: .74rem; font-weight: 700;
    }
    .badge-type { background: #f0ebff; color: #5b21b6; }
    body.dark .badge-type { background: rgba(124,58,237,.18); color: var(--pl); }
    .badge-req  { background: #fde8e8; color: #9b1c1c; }
    body.dark .badge-req { background: rgba(220,38,38,.15); color: #f87171; }
    .badge-opt  { background: #ecfdf5; color: #065f46; }
    body.dark .badge-opt { background: rgba(16,185,129,.12); color: #34d399; }

    /* خيارات الحقل */
    .options-wrap { display: flex; flex-direction: column; gap: .5rem; margin-top: .25rem; }
    .option-item {
        display: grid;
        grid-template-columns: 42px 1fr 42px 1fr;
        gap: .5rem;
        align-items: center;
        padding: .55rem .8rem;
        background: #faf7ff;
        border: 1px solid #ede9fe;
        border-radius: 10px;
        font-size: .84rem;
    }
    body.dark .option-item { background: rgba(124,58,237,.06); border-color: rgba(124,58,237,.14); }
    .opt-lang {
        font-size: .65rem; font-weight: 700; color: var(--pp);
        text-transform: uppercase; letter-spacing: .06em;
        background: var(--ps); padding: .15rem .4rem; border-radius: 5px;
        text-align: center;
    }
    body.dark .opt-lang { background: rgba(124,58,237,.18); color: var(--pl); }
    .opt-val { color: #334155; }
    body.dark .opt-val { color: #c4cfe0; }

    /* ========== الشريط الجانبي ========== */
    .sidebar { display: flex; flex-direction: column; gap: 1.25rem; }

    .side-card {
        background: #fff;
        border-radius: 22px;
        border: 1px solid #ede9fe;
        box-shadow: 0 8px 24px rgba(124,58,237,.1);
        padding: 1.4rem 1.3rem;
        animation: scaleIn .45s .15s both;
    }
    body.dark .side-card { background: #16132a; border-color: rgba(124,58,237,.18); }

    .side-card-title {
        display: flex; align-items: center; gap: .55rem;
        font-weight: 700; font-size: .9rem; color: var(--pd);
        margin: 0 0 1rem;
    }
    body.dark .side-card-title { color: var(--pl); }
    .side-card-title svg { width: 18px; height: 18px; stroke: var(--pp); }

    .meta-list { list-style: none; padding: 0; margin: 0; }
    .meta-list li {
        display: flex; align-items: flex-start; gap: .7rem;
        padding: .55rem 0;
        border-bottom: 1px dashed #ede9fe;
        font-size: .875rem; color: #475569;
        line-height: 1.5;
    }
    body.dark .meta-list li { color: #94a3b8; border-bottom-color: rgba(124,58,237,.12); }
    .meta-list li:last-child { border-bottom: none; padding-bottom: 0; }
    .meta-list li svg { width: 16px; height: 16px; stroke: var(--pp); flex-shrink: 0; margin-top: 2px; }
    .meta-key { font-weight: 600; color: #1e293b; }
    body.dark .meta-key { color: #e2e8f0; }
</style>
@endsection

@section('content')
<div class="layout-top-spacing">

    {{-- رابط الرجوع --}}
    <a href="{{ $ownerType === 'category'
        ? route('admin.categories.dynamic-fields.index', $owner)
        : route('admin.categories.sub-categories.dynamic-fields.index', [$parentCategory, $owner]) }}"
       class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        {{ __('admin.back_to_list') }}
    </a>

    {{-- الهيدر --}}
    <div class="page-header">
        <div class="ph-bg"></div>
        <div class="ph-grid"></div>
        <div class="ph-orb"></div>
        <div class="ph-inner">
            <div class="ph-left">
                <div class="ph-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
                <div>
                    <h1 class="ph-title">{{ $field->getTranslation('name', app()->getLocale()) }}</h1>
                    <p class="ph-sub">
                        {{ __('admin.dynamic_field_details') }} &mdash;
                        {{ $ownerType === 'category' ? __('admin.category') : __('admin.sub_category') }}:
                        {{ $owner->getTranslation('name', app()->getLocale()) }}
                    </p>
                    <div class="ph-actions">
                        @can('dynamic_fields.edit')
                        <a href="{{ $ownerType === 'category'
                            ? route('admin.categories.dynamic-fields.edit', [$owner, $field])
                            : route('admin.categories.sub-categories.dynamic-fields.edit', [$parentCategory, $owner, $field]) }}"
                           class="btn-hdr btn-hdr-edit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            {{ __('admin.edit') }}
                        </a>
                        @endcan
                        @can('dynamic_fields.delete')
                        <button type="button" class="btn-hdr btn-hdr-del" id="deleteBtn"
                            data-field-name="{{ $field->getTranslation('name', app()->getLocale()) }}"
                            data-delete-url="{{ $ownerType === 'category'
                                ? route('admin.categories.dynamic-fields.destroy', [$owner, $field])
                                : route('admin.categories.sub-categories.dynamic-fields.destroy', [$parentCategory, $owner, $field]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                            </svg>
                            {{ __('admin.delete') }}
                        </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        {{-- إحصائيات سريعة --}}
        <div class="ph-stats" style="position:relative;z-index:2;">
            <div class="ph-stat" style="animation-delay:.08s">
                <div class="ph-stat-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div>
                    <div class="ph-stat-lbl">{{ __('admin.field_type') }}</div>
                    <div class="ph-stat-val">{{ $field->type }}</div>
                </div>
            </div>
            <div class="ph-stat" style="animation-delay:.13s">
                <div class="ph-stat-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
                <div>
                    <div class="ph-stat-lbl">{{ __('admin.required') }}</div>
                    <div class="ph-stat-val">{{ $field->is_required ? __('admin.yes') : __('admin.no') }}</div>
                </div>
            </div>
            <div class="ph-stat" style="animation-delay:.18s">
                <div class="ph-stat-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <div class="ph-stat-lbl">{{ __('admin.created_at') }}</div>
                    <div class="ph-stat-val" style="font-size:.9rem;">{{ $field->created_at->format('Y-m-d') }}</div>
                </div>
            </div>
            <div class="ph-stat" style="animation-delay:.23s">
                <div class="ph-stat-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <div class="ph-stat-lbl">{{ __('admin.updated_at') }}</div>
                    <div class="ph-stat-val" style="font-size:.85rem;">{{ $field->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- شبكة المحتوى --}}
    <div class="content-grid">

        {{-- البطاقة الرئيسية --}}
        <div class="main-card">
            <div class="card-hdr">
                <div class="card-hdr-ico">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <h3 class="card-hdr-title">{{ __('admin.field_details') }}</h3>
            </div>

            <table class="info-tbl">
                <tr>
                    <td class="info-lbl">{{ __('admin.name_ar') }}</td>
                    <td class="info-val" dir="rtl">{{ $field->getTranslation('name', 'ar') ?: '—' }}</td>
                </tr>
                <tr>
                    <td class="info-lbl">{{ __('admin.name_en') }}</td>
                    <td class="info-val">{{ $field->getTranslation('name', 'en') ?: '—' }}</td>
                </tr>
                <tr>
                    <td class="info-lbl">{{ __('admin.field_type') }}</td>
                    <td class="info-val">
                        <span class="badge badge-type">{{ $field->type }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="info-lbl">{{ __('admin.required') }}</td>
                    <td class="info-val">
                        @if($field->is_required)
                            <span class="badge badge-req">{{ __('admin.required') }}</span>
                        @else
                            <span class="badge badge-opt">{{ __('admin.optional') }}</span>
                        @endif
                    </td>
                </tr>

                {{-- ✅ إصلاح خطأ foreach: تحويل options من string إلى array --}}
                @php
                    $options = $field->options ?? null;
                    if (is_string($options)) {
                        $options = json_decode($options, true);
                    }
                    $hasOptions = in_array($field->type, ['select', 'checkbox', 'radio'])
                        && is_array($options)
                        && count($options) > 0;
                @endphp

@if($hasOptions)
<tr>
    <td class="info-lbl">{{ __('admin.options') }}</td>
    <td class="info-val">
        <div class="options-wrap">
            @foreach($options as $option)
                <div class="option-item">
                    <span class="opt-lang">AR</span>
                    <span class="opt-val">{{ $option['label']['ar'] ?? '—' }}</span>   <!-- ✅ صحيح -->
                    <span class="opt-lang">EN</span>
                    <span class="opt-val">{{ $option['label']['en'] ?? '—' }}</span>   <!-- ✅ صحيح -->
                </div>
            @endforeach
        </div>
    </td>
</tr>
@endif
            </table>
        </div>

        {{-- الشريط الجانبي --}}
        <div class="sidebar">
            <div class="side-card">
                <p class="side-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                    </svg>
                    {{ __('admin.information') }}
                </p>
                <ul class="meta-list">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-6 9 6v11a2 2 0 0 1-2 2h-4v-7H9v7H5a2 2 0 0 1-2-2V9z"/>
                        </svg>
                        <span>
                            <span class="meta-key">{{ __('admin.owner') }}: </span>
                            {{ $owner->getTranslation('name', app()->getLocale()) }}
                        </span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8"  y1="2" x2="8"  y2="6"/>
                            <line x1="3"  y1="10" x2="21" y2="10"/>
                        </svg>
                        <span>
                            <span class="meta-key">{{ __('admin.owner_type') }}: </span>
                            {{ $ownerType === 'category' ? __('admin.category') : __('admin.sub_category') }}
                        </span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span>
                            <span class="meta-key">{{ __('admin.created_at') }}: </span>
                            {{ $field->created_at->format('Y-m-d H:i') }}
                        </span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span>
                            <span class="meta-key">{{ __('admin.updated_at') }}: </span>
                            {{ $field->updated_at->format('Y-m-d H:i') }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteBtn = document.getElementById('deleteBtn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            Swal.fire({
                title: '{{ __('admin.confirm_delete') }}',
                text:  '{{ __('admin.delete_confirm_msg') }}: ' + this.dataset.fieldName,
                icon:  'warning',
                showCancelButton:   true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor:  '#7c3aed',
                confirmButtonText:  '{{ __('admin.delete') }}',
                cancelButtonText:   '{{ __('admin.cancel') }}',
                reverseButtons:     true,
                background: document.body.classList.contains('dark') ? '#16132a' : '#fff',
                color:      document.body.classList.contains('dark') ? '#e2e8f0' : '#1e293b',
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = deleteBtn.dataset.deleteUrl;
                    form.submit();
                }
            });
        });
    }

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
