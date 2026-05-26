@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/src/sweetalerts2/sweetalerts2.css')}}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
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

        .show-activity-wrapper {
            animation: fadeIn 0.5s ease;
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

        .header-badge {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 60px;
            padding: 0.5rem 1.2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .badge-status {
            display: inline-block;
            padding: 0.25rem 0.8rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-approved {
            background: #dcfce7;
            color: #166534;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 1.2rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            animation: scaleIn 0.5s both;
        }

        .stat-card:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .stat-icon svg {
            width: 24px;
            height: 24px;
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
        }

        .stat-value .price-line {
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.4;
        }
        .stat-value .price-line:first-child {
            font-size: 1.4rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
            margin: 1.5rem 0;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-action-primary {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            backdrop-filter: blur(6px);
        }

        .btn-action-primary:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
            color: white;
        }

        .btn-action-danger {
            background: rgba(244,63,94,0.15);
            border: 1px solid rgba(244,63,94,0.3);
            color: #fda4af;
        }

        .btn-action-danger:hover {
            background: #f43f5e;
            color: white;
            transform: translateY(-2px);
        }

        .btn-action-warning {
            background: rgba(245,158,11,0.15);
            border: 1px solid rgba(245,158,11,0.3);
            color: #f59e0b;
        }

        .btn-action-warning:hover {
            background: #f59e0b;
            color: white;
        }

        .btn-action-secondary {
            background: rgba(107,114,128,0.15);
            border: 1px solid rgba(107,114,128,0.3);
            color: #6b7280;
        }

        .btn-action-secondary:hover {
            background: #6b7280;
            color: white;
        }

        .modern-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.8rem;
            margin-top: 2rem;
        }

        @media (max-width: 992px) {
            .modern-grid {
                grid-template-columns: 1fr;
            }
        }

        .section-card {
            background: #fff;
            border-radius: 28px;
            border: 1px solid #ede9fe;
            box-shadow: 0 20px 40px -12px rgba(124,58,237,0.12);
            overflow: hidden;
            animation: scaleIn 0.5s both;
            margin-bottom: 1.5rem;
        }

        body.dark .section-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.5);
        }

        .section-header {
            padding: 1.2rem 1.8rem;
            background: linear-gradient(to right, #faf5ff, #ffffff);
            border-bottom: 1px solid #ede9fe;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        body.dark .section-header {
            background: rgba(255,255,255,0.03);
            border-bottom-color: rgba(124,58,237,0.15);
        }

        .section-header-left {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .section-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .section-title {
            font-weight: 700;
            font-size: 1rem;
            color: #1e293b;
            margin: 0;
        }

        body.dark .section-title {
            color: #e2e8f0;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table th {
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary-purple);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #f8f7ff;
            border-bottom: 1px solid #e8e0fc;
            text-align: left;
        }

        body.dark .modern-table th {
            background: rgba(255,255,255,0.03);
            color: #a78bfa;
            border-bottom-color: rgba(124,58,237,0.15);
        }

        .modern-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f0f7;
            color: #334155;
            vertical-align: middle;
        }

        body.dark .modern-table td {
            color: #cbd5e1;
            border-bottom-color: rgba(124,58,237,0.1);
        }

        .modern-table tbody tr:last-child td {
            border-bottom: none;
        }

        .map-cell {
            padding: 0 !important;
        }
        .map-container {
            height: 320px;
            width: 100%;
        }
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
        }

        .info-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #ede9fe;
            padding: 1.8rem 1.5rem;
            box-shadow: 0 20px 30px -12px rgba(124,58,237,0.1);
            animation: scaleIn 0.5s 0.1s both;
        }

        body.dark .info-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }

        .info-card-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 700;
            color: var(--purple-dark);
            margin-bottom: 1.2rem;
        }

        body.dark .info-card-title {
            color: #a78bfa;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.6rem 0;
            font-size: 0.9rem;
            color: #475569;
            border-bottom: 1px dashed #f0eaff;
        }

        body.dark .info-list li {
            color: #a5b4cb;
            border-bottom-color: rgba(124,58,237,0.15);
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list li svg {
            width: 18px;
            height: 18px;
            stroke: var(--primary-purple);
            flex-shrink: 0;
        }

        .modern-media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.2rem;
            padding: 1.2rem;
        }

        .media-item {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #ede9fe;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        body.dark .media-item {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }

        .media-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px -8px rgba(124,58,237,0.2);
        }

        .media-preview {
            background: #f8f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 140px;
            overflow: hidden;
        }

        body.dark .media-preview {
            background: rgba(255,255,255,0.05);
        }

        .media-preview img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            transition: transform 0.2s;
        }

        .media-preview img:hover {
            transform: scale(1.02);
        }

        .file-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: var(--primary-purple);
            gap: 0.5rem;
        }

        .file-icon svg {
            width: 42px;
            height: 42px;
        }

        .media-info {
            padding: 0.75rem;
            border-top: 1px solid #f0eaff;
            background: #ffffff;
        }

        body.dark .media-info {
            background: #1e1b2e;
            border-top-color: rgba(124,58,237,0.15);
        }

        .media-name {
            display: block;
            font-size: 0.75rem;
            color: #334155;
            margin-bottom: 0.5rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }

        body.dark .media-name {
            color: #cbd5e1;
        }

        .media-actions {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-sm {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.2rem 0.6rem;
            font-size: 0.7rem;
            font-weight: 500;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-outline-primary {
            border: 1px solid var(--primary-purple);
            color: var(--primary-purple);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-purple);
            color: white;
        }

        .btn-outline-secondary {
            border: 1px solid #94a3b8;
            color: #475569;
            background: transparent;
        }

        .btn-outline-secondary:hover {
            background: #94a3b8;
            color: white;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--primary-purple);
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 1rem;
            transition: gap 0.2s;
        }

        .back-link:hover {
            gap: 0.7rem;
        }
    </style>
@endsection

@section('content')
<div class="show-activity-wrapper">
    <a href="{{ route('admin.services.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        {{ __('admin.back_to_list') }}
    </a>

    <div class="page-header-modern">
        <div class="header-bg-pattern"></div>
        <div class="header-content">
            <div class="header-title-area">
                <div class="header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/>
                        <line x1="9" y1="2" x2="9" y2="22"/>
                        <line x1="15" y1="2" x2="15" y2="22"/>
                        <line x1="2" y1="9" x2="22" y2="9"/>
                        <line x1="2" y1="15" x2="22" y2="15"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ $service->getTranslation('title', app()->getLocale()) }}</h1>
                    <p>{{ __('admin.service_details') }}</p>
                </div>
            </div>
            <div class="header-badge">
                @if($service->status == 'pending')
                    <span class="badge-status badge-pending">{{ __('admin.pending') }}</span>
                @elseif($service->status == 'approved')
                    <span class="badge-status badge-approved">{{ __('admin.approved') }}</span>
                @elseif($service->status == 'suspended')
                    <span class="badge-status" style="background:#fed7aa;color:#9b4d00;">{{ __('admin.suspended') }}</span>
                @else
                    <span class="badge-status badge-rejected">{{ __('admin.rejected') }}</span>
                @endif
            </div>
        </div>

        <div class="action-buttons">
            {{-- فقط الأزرار المسموحة حسب الحالة (مع SweetAlert) --}}
            @if($service->status == 'pending')
                @can('services.approve')
                <button type="button" class="btn-action btn-action-primary" id="approveBtn" data-url="{{ route('admin.services.approve', $service) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ __('admin.approve') }}
                </button>
                @endcan
                @can('services.reject')
                <button type="button" class="btn-action btn-action-danger" id="rejectBtn" data-url="{{ route('admin.services.reject', $service) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    {{ __('admin.reject') }}
                </button>
                @endcan
            @endif

            @if($service->status == 'approved')
                @can('services.suspend')
                <button type="button" class="btn-action btn-action-warning" id="suspendBtn" data-url="{{ route('admin.services.suspend', $service) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ __('admin.suspend') }}
                </button>
                @endcan
            @endif

            @if($service->status == 'suspended')
                @can('services.reactivate')
                <button type="button" class="btn-action btn-action-primary" id="reactivateBtn" data-url="{{ route('admin.services.reactivate', $service) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    {{ __('admin.reactivate') }}
                </button>
                @endcan
            @endif
        </div>

        {{-- Quick Stats --}}
        <div class="stats-grid">
            <div class="stat-card" style="animation-delay: 0.1s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.business_account') }}</div>
                    <div class="stat-value">{{ $service->businessAccount->getTranslation('business_name', app()->getLocale()) }}</div>
                </div>
            </div>
            <div class="stat-card" style="animation-delay: 0.15s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="9" y1="2" x2="9" y2="22"/><line x1="15" y1="2" x2="15" y2="22"/><line x1="2" y1="9" x2="22" y2="9"/><line x1="2" y1="15" x2="22" y2="15"/></svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.category') }}</div>
                    <div class="stat-value">{{ $service->category?->getTranslation('name', app()->getLocale()) }}</div>
                </div>
            </div>

            <div class="stat-card" style="animation-delay: 0.2s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.prices') }}</div>
                    <div class="stat-price">
                        <div class="price-value">
                            @if($service->price_syp !== null)
                                {{ number_format($service->price_syp, 2) }} <span class="price-currency">SYP</span>
                            @else
                                <span class="price-na">{{ __('admin.not_specified') }}</span> <span class="price-currency">SYP</span>
                            @endif
                        </div>
                        <div class="price-value">
                            @if($service->price_usd !== null)
                                {{ number_format($service->price_usd, 2) }} <span class="price-currency">USD</span>
                            @else
                                <span class="price-na">{{ __('admin.not_specified') }}</span> <span class="price-currency">USD</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="stat-card" style="animation-delay: 0.25s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15 8 22 9 17 14 18 21 12 17 6 21 7 14 2 9 9 8 12 2"/></svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.quantity') }}</div>
                    <div class="stat-value">{{ $service->quantity ?? __('admin.unlimited') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="modern-grid">
        <div>
            {{-- Service Details Card --}}
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-left">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="9" y1="2" x2="9" y2="22"/><line x1="15" y1="2" x2="15" y2="22"/><line x1="2" y1="9" x2="22" y2="9"/><line x1="2" y1="15" x2="22" y2="15"/></svg>
                        </div>
                        <h3 class="section-title">{{ __('admin.service_information') }}</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="modern-table">
                        <tr><th style="width:150px;">{{ __('admin.title_ar') }}</th><td>{{ $service->getTranslation('title', 'ar') }}</td></tr>
                        <tr><th>{{ __('admin.title_en') }}</th><td>{{ $service->getTranslation('title', 'en') }}</td></tr>
                        <tr><th>{{ __('admin.description_ar') }}</th><td>{{ $service->getTranslation('description', 'ar') }}</td></tr>
                        <tr><th>{{ __('admin.description_en') }}</th><td>{{ $service->getTranslation('description', 'en') }}</td></tr>
                        <tr><th>{{ __('admin.category') }}</th><td>{{ $service->category?->getTranslation('name', app()->getLocale()) }} @if($service->subCategory) ({{ $service->subCategory->getTranslation('name', app()->getLocale()) }}) @endif</td></tr>
                        <tr><th>{{ __('admin.service_type') }}</th><td>{{ $service->service_type === 'sale' ? __('admin.sale') : __('admin.rent') }}</td></tr>
                        <tr>
                            <th>{{ __('admin.price_syp') }}</th>
                            <td>
                                @if($service->price_syp !== null)
                                    {{ number_format($service->price_syp, 2) }} SYP
                                @else
                                    <span class="text-muted">{{ __('admin.not_specified') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.price_usd') }}</th>
                            <td>
                                @if($service->price_usd !== null)
                                    {{ number_format($service->price_usd, 2) }} USD
                                @else
                                    <span class="text-muted">{{ __('admin.not_specified') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.quantity') }}</th>
                            <td>{{ $service->quantity ?? __('admin.unlimited') }}</td>
                        </tr>
                        @if($service->lat && $service->lng)
                        <tr>
                            <th>{{ __('admin.location') }}</th>
                            <td class="map-cell">
                                <div class="map-container">
                                    <iframe src="https://maps.google.com/maps?q={{ $service->lat }},{{ $service->lng }}&z=15&output=embed" title="Google Map" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Dynamic Fields --}}
            @if($service->dynamicFieldValues->count())
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-left">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
                        </div>
                        <h3 class="section-title">{{ __('admin.dynamic_fields') }}</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="modern-table">
                        @foreach($service->dynamicFieldValues as $fieldValue)
                        <tr>
                            <th style="width:200px;">{{ $fieldValue->dynamicField->getTranslation('name', app()->getLocale()) }}</th>
                            <td>{{ $fieldValue->value }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endif

            {{-- Media Section --}}
            @if($service->getMedia('main_image')->count() || $service->getMedia('images')->count())
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-left">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="9" y1="2" x2="9" y2="22"/><line x1="15" y1="2" x2="15" y2="22"/><line x1="2" y1="9" x2="22" y2="9"/><line x1="2" y1="15" x2="22" y2="15"/></svg>
                        </div>
                        <h3 class="section-title">{{ __('admin.attachments') }}</h3>
                    </div>
                </div>
                <div class="media-gallery modern-media-grid">
                    @if($mainImage = $service->getFirstMedia('main_image'))
                        <div class="media-item">
                            <div class="media-preview"><a href="{{ asset('storage/' . $mainImage->getPathRelativeToRoot()) }}" target="_blank"><img src="{{ asset('storage/' . $mainImage->getPathRelativeToRoot()) }}" alt="{{ __('admin.main_image') }}"></a></div>
                            <div class="media-info"><span class="media-name">{{ __('admin.main_image') }}</span><div class="media-actions"><a href="{{ asset('storage/' . $mainImage->getPathRelativeToRoot()) }}" target="_blank" class="btn-sm btn-outline-primary">{{ __('admin.view') }}</a><a href="{{ asset('storage/' . $mainImage->getPathRelativeToRoot()) }}" download class="btn-sm btn-outline-secondary">{{ __('admin.download') }}</a></div></div>
                        </div>
                    @endif
                    @foreach($service->getMedia('images') as $image)
                        <div class="media-item">
                            <div class="media-preview"><a href="{{ asset('storage/' . $image->getPathRelativeToRoot()) }}" target="_blank"><img src="{{ asset('storage/' . $image->getPathRelativeToRoot()) }}" alt="{{ $image->name }}"></a></div>
                            <div class="media-info"><span class="media-name">{{ Str::limit($image->file_name, 30) }}</span><div class="media-actions"><a href="{{ asset('storage/' . $image->getPathRelativeToRoot()) }}" target="_blank" class="btn-sm btn-outline-primary">{{ __('admin.view') }}</a><a href="{{ asset('storage/' . $image->getPathRelativeToRoot()) }}" download class="btn-sm btn-outline-secondary">{{ __('admin.download') }}</a></div></div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="sidebar-modern">
            <div class="info-card">
                <div class="info-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>{{ __('admin.service_info') }}</span>
                </div>
                <ul class="info-list">
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg><strong>{{ __('admin.created_at') }}:</strong> {{ $service->created_at->format('Y-m-d H:i') }}</li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><strong>{{ __('admin.updated_at') }}:</strong> {{ $service->updated_at->diffForHumans() }}</li>
                    @if($service->submitted_at)
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><strong>{{ __('admin.submitted_at') }}:</strong> {{ $service->submitted_at->format('Y-m-d H:i') }}</li>
                    @endif
                    @if($service->reviewed_at)
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg><strong>{{ __('admin.reviewed_at') }}:</strong> {{ $service->reviewed_at->format('Y-m-d H:i') }}</li>
                    @endif
                    @if($service->reviewed_by)
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><strong>{{ __('admin.reviewed_by') }}:</strong> {{ $service->reviewer?->name }}</li>
                    @endif
                </ul>
            </div>

            <div class="info-card mt-3">
                <div class="info-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span>{{ __('admin.business_account_details') }}</span>
                </div>
                <div class="business-account-info">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @php $logo = $service->businessAccount->getFirstMediaUrl('logo', 'thumb'); @endphp
                        @if($logo)
                            <img src="{{ $logo }}" class="rounded-circle" width="60" height="60" style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="var(--primary-purple)" stroke-width="1.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-0">{{ $service->businessAccount->getTranslation('business_name', app()->getLocale()) }}</h5>
                            <small class="text-muted">{{ __('admin.business_account') }}</small>
                        </div>
                    </div>
                    <ul class="info-list">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <strong>{{ __('admin.email') }}:</strong> {{ $service->businessAccount->email }}
                        </li>
                        @if($service->businessAccount->phone)
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <strong>{{ __('admin.phone') }}:</strong> {{ $service->businessAccount->phone }}
                        </li>
                        @endif
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="16"/>
                                <line x1="8" y1="12" x2="16" y2="12"/>
                            </svg>
                            <strong>{{ __('admin.status') }}:</strong>
                            <span class="badge-status {{ $service->businessAccount->status === 'active' ? 'badge-approved' : 'badge-pending' }}">
                                {{ __('admin.'.$service->businessAccount->status) }}
                            </span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/>
                                <line x1="9" y1="2" x2="9" y2="22"/>
                                <line x1="15" y1="2" x2="15" y2="22"/>
                                <line x1="2" y1="9" x2="22" y2="9"/>
                                <line x1="2" y1="15" x2="22" y2="15"/>
                            </svg>
                            <strong>{{ __('admin.services_count') }}:</strong> {{ $service->businessAccount->services()->count() }}
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <strong>{{ __('admin.joined_at') }}:</strong> {{ $service->businessAccount->created_at->format('Y-m-d') }}
                        </li>
                    </ul>
                    <a href="{{ route('admin.business-accounts.show', $service->businessAccount) }}" class="btn-sm btn-outline-primary mt-3 w-100 text-center d-block">
                        {{ __('admin.view_business_account') }} →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden form for actions --}}
<form id="actionForm" method="POST" action="" style="display: none;">
    @csrf
    @method('PATCH')
</form>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script>
    (function() {
        // Helper function to handle action buttons
        function handleAction(buttonId, confirmTitle, confirmText, confirmButtonText, actionUrl) {
            const btn = document.getElementById(buttonId);
            if (!btn) return;

            btn.addEventListener('click', function(e) {
                Swal.fire({
                    title: confirmTitle,
                    text: confirmText,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#7c3aed',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: '{{ __('admin.cancel') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: '{{ __('admin.please_wait') }}',
                            text: '{{ __('admin.updating_status') }}',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });

                        const form = document.getElementById('actionForm');
                        form.action = actionUrl;
                        form.submit();
                    }
                });
            });
        }

        @if($service->status == 'pending')
            @can('services.approve')
                handleAction('approveBtn',
                    '{{ __('admin.confirm_approve') }}',
                    '{{ __('admin.confirm_approve_service_msg') ?? __('admin.confirm_approve') }}',
                    '{{ __('admin.approve') }}',
                    '{{ route('admin.services.approve', $service) }}'
                );
            @endcan
            @can('services.reject')
                handleAction('rejectBtn',
                    '{{ __('admin.confirm_reject') }}',
                    '{{ __('admin.confirm_reject_service_msg') ?? __('admin.confirm_reject') }}',
                    '{{ __('admin.reject') }}',
                    '{{ route('admin.services.reject', $service) }}'
                );
            @endcan
        @endif

        @if($service->status == 'approved')
            @can('services.suspend')
                handleAction('suspendBtn',
                    '{{ __('admin.confirm_suspend') }}',
                    '{{ __('admin.confirm_suspend_service_msg') ?? __('admin.confirm_suspend') }}',
                    '{{ __('admin.suspend') }}',
                    '{{ route('admin.services.suspend', $service) }}'
                );
            @endcan
        @endif

        @if($service->status == 'suspended')
            @can('services.reactivate')
                handleAction('reactivateBtn',
                    '{{ __('admin.confirm_reactivate') }}',
                    '{{ __('admin.confirm_reactivate_service_msg') ?? __('admin.confirm_reactivate') }}',
                    '{{ __('admin.reactivate') }}',
                    '{{ route('admin.services.reactivate', $service) }}'
                );
            @endcan
        @endif

        // Show success/error messages from session
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

        @if(session('error'))
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        }).fire({ icon: 'error', title: '{{ session('error') }}' });
        @endif
    })();
</script>
@endsection
