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
    <a href="{{ route('admin.business-accounts.index') }}" class="back-link">
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
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ $account->getTranslation('business_name', app()->getLocale()) }}</h1>
                    <p>{{ __('admin.business_account_details') }}</p>
                </div>
            </div>
            <div class="header-badge">
                @if($account->status == 'pending')
                    <span class="badge-status badge-pending">{{ __('admin.pending') }}</span>
                @elseif($account->status == 'approved')
                    <span class="badge-status badge-approved">{{ __('admin.approved') }}</span>
                @elseif($account->status == 'suspended')
                    <span class="badge-status" style="background:#fed7aa;color:#9b4d00;">{{ __('admin.suspended') }}</span>
                @else
                    <span class="badge-status badge-rejected">{{ __('admin.rejected') }}</span>
                @endif
                @if($account->is_active)
                    <span class="badge-status badge-approved" style="margin-left:0.5rem;">{{ __('admin.active') }}</span>
                @else
                    <span class="badge-status badge-rejected" style="margin-left:0.5rem;">{{ __('admin.inactive') }}</span>
                @endif
            </div>
        </div>

        <div class="action-buttons">
            {{-- Status actions based on current status --}}
            @if($account->status == 'pending')
                @can('business_accounts.approve')
                <button type="button" class="btn-action btn-action-primary" id="approveBtn" data-url="{{ route('admin.business-accounts.approve', $account) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    {{ __('admin.approve') }}
                </button>
                @endcan
                @can('business_accounts.reject')
                <button type="button" class="btn-action btn-action-danger" id="rejectBtn" data-url="{{ route('admin.business-accounts.reject', $account) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    {{ __('admin.reject') }}
                </button>
                @endcan
            @endif

            @if($account->status == 'approved')
                @can('business_accounts.suspend')
                <button type="button" class="btn-action btn-action-warning" id="suspendBtn" data-url="{{ route('admin.business-accounts.suspend', $account) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ __('admin.suspend') }}
                </button>
                @endcan
            @endif

            @if($account->status == 'suspended')
                @can('business_accounts.reactivate')
                <button type="button" class="btn-action btn-action-primary" id="reactivateBtn" data-url="{{ route('admin.business-accounts.reactivate', $account) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    {{ __('admin.reactivate') }}
                </button>
                @endcan
            @endif
        </div>

        {{-- Quick Stats --}}
        <div class="stats-grid">
            <div class="stat-card" style="animation-delay: 0.1s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.license_number') }}</div>
                    <div class="stat-value">{{ $account->license_number ?? '—' }}</div>
                </div>
            </div>
            <div class="stat-card" style="animation-delay: 0.15s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.activity_type') }}</div>
                    <div class="stat-value">{{ $account->activityType?->getTranslation('name', app()->getLocale()) ?? '—' }}</div>
                </div>
            </div>
            <div class="stat-card" style="animation-delay: 0.2s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.city') }}</div>
                    <div class="stat-value">{{ $account->city?->getTranslation('name', app()->getLocale()) ?? '—' }}</div>
                </div>
            </div>
            <div class="stat-card" style="animation-delay: 0.25s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.submitted_at') }}</div>
                    <div class="stat-value">{{ optional($account->submitted_at)->format('Y-m-d') ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="modern-grid">
        <div>
            {{-- Owner Info Card --}}
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-left">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <h3 class="section-title">{{ __('admin.owner_information') }}</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="modern-table">
                        <tr>
                            <th style="width:150px;">{{ __('admin.name') }}</th>
                            <td>{{ $account->user?->first_name }} {{ $account->user?->last_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.phone') }}</th>
                            <td>{{ $account->user?->phone ?? '—' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Business Details Card --}}
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-left">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <h3 class="section-title">{{ __('admin.business_details') }}</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="modern-table">
                        <tr>
                            <th style="width:150px;">{{ __('admin.business_name_ar') }}</th>
                            <td>{{ $account->getTranslation('business_name', 'ar') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.business_name_en') }}</th>
                            <td>{{ $account->getTranslation('business_name', 'en') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.license_number') }}</th>
                            <td>{{ $account->license_number ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.activity_type') }}</th>
                            <td>{{ $account->activityType?->getTranslation('name', app()->getLocale()) ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.city') }}</th>
                            <td>{{ $account->city?->getTranslation('name', app()->getLocale()) ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('admin.location') }}</th>
                            <td class="map-cell">
                                @if($account->lat && $account->lng)
                                    <div class="map-container">
                                        <iframe
                                            src="https://maps.google.com/maps?q={{ $account->lat }},{{ $account->lng }}&z=15&output=embed"
                                            title="Google Map"
                                            allowfullscreen=""
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade">
                                        </iframe>
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        @if($account->activities)
                        <tr>
                            <th>{{ __('admin.activities') }}</th>
                            <td>{{ $account->activities }}</td>
                        </tr>
                        @endif
                        @if($account->details)
                        <tr>
                            <th>{{ __('admin.details') }}</th>
                            <td>{{ $account->details }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- Media Section --}}
            @if($account->getMedia('images')->count() || $account->getMedia('documents')->count())
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-left">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/>
                                <line x1="9" y1="2" x2="9" y2="22"/>
                                <line x1="15" y1="2" x2="15" y2="22"/>
                                <line x1="2" y1="9" x2="22" y2="9"/>
                                <line x1="2" y1="15" x2="22" y2="15"/>
                            </svg>
                        </div>
                        <h3 class="section-title">{{ __('admin.attachments') }}</h3>
                    </div>
                </div>
                <div class="media-gallery modern-media-grid">
                    {{-- الصور --}}
                    @foreach($account->getMedia('images') as $image)
                        <div class="media-item">
                            <div class="media-preview">
                                <a href="{{ asset('storage/' . $image->getPathRelativeToRoot()) }}" target="_blank" class="media-link">
                                    <img src="{{ asset('storage/' . $image->getPathRelativeToRoot()) }}" alt="{{ $image->name }}" loading="lazy">
                                </a>
                            </div>
                            <div class="media-info">
                                <span class="media-name" title="{{ $image->file_name }}">{{ Str::limit($image->file_name, 30) }}</span>
                                <div class="media-actions">
                                    <a href="{{ asset('storage/' . $image->getPathRelativeToRoot()) }}" target="_blank" class="btn-sm btn-outline-primary" title="{{ __('admin.view') }}">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        {{ __('admin.view') }}
                                    </a>
                                    <a href="{{ asset('storage/' . $image->getPathRelativeToRoot()) }}" download class="btn-sm btn-outline-secondary" title="{{ __('admin.download') }}">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                                        </svg>
                                        {{ __('admin.download') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- المستندات --}}
                    @foreach($account->getMedia('documents') as $doc)
                        <div class="media-item">
                            <div class="media-preview file-icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                                    <polyline points="13 2 13 9 20 9"/>
                                </svg>
                            </div>
                            <div class="media-info">
                                <span class="media-name" title="{{ $doc->file_name }}">{{ Str::limit($doc->file_name, 30) }}</span>
                                <div class="media-actions">
                                    <a href="{{ asset('storage/' . $doc->getPathRelativeToRoot()) }}" target="_blank" class="btn-sm btn-outline-primary" title="{{ __('admin.view') }}">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        {{ __('admin.view') }}
                                    </a>
                                    <a href="{{ asset('storage/' . $doc->getPathRelativeToRoot()) }}" download class="btn-sm btn-outline-secondary" title="{{ __('admin.download') }}">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                                        </svg>
                                        {{ __('admin.download') }}
                                    </a>
                                </div>
                            </div>
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
                    <span>{{ __('admin.business_account_info') }}</span>
                </div>
                <ul class="info-list">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <strong>{{ __('admin.created_at') }}:</strong> {{ optional($account->created_at)->format('Y-m-d H:i') ?? '—' }}
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <strong>{{ __('admin.updated_at') }}:</strong> {{ optional($account->updated_at)->diffForHumans() ?? '—' }}
                    </li>
                    @if($account->reviewed_at)
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <strong>{{ __('admin.reviewed_at') }}:</strong> {{ $account->reviewed_at->format('Y-m-d H:i') }}
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <strong>{{ __('admin.reviewed_by') }}:</strong> {{ $account->reviewer?->name ?? '—' }}
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Form for actions (used by JavaScript to submit via POST) --}}
<form id="actionForm" method="POST" action="" style="display:none;">
    @csrf
    @method('PATCH')
</form>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script>
    (function() {
        // Helper function to handle action buttons
        function handleAction(buttonId, confirmTitle, confirmText, confirmButtonText, actionUrl, successMessage) {
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

        // Handle approve (pending)
        @if($account->status == 'pending')
            handleAction('approveBtn',
                '{{ __('admin.confirm_approve') }}',
                '{{ __('admin.confirm_approve_account_msg') }}',
                '{{ __('admin.approve') }}',
                '{{ route('admin.business-accounts.approve', $account) }}',
                '{{ __('admin.business_account_approved') }}'
            );
            handleAction('rejectBtn',
                '{{ __('admin.confirm_reject') }}',
                '{{ __('admin.confirm_reject_account_msg') }}',
                '{{ __('admin.reject') }}',
                '{{ route('admin.business-accounts.reject', $account) }}',
                '{{ __('admin.business_account_rejected') }}'
            );
        @endif

        // Handle suspend (approved)
        @if($account->status == 'approved')
            handleAction('suspendBtn',
                '{{ __('admin.confirm_suspend') }}',
                '{{ __('admin.confirm_suspend_account_msg') }}',
                '{{ __('admin.suspend') }}',
                '{{ route('admin.business-accounts.suspend', $account) }}',
                '{{ __('admin.business_account_suspended') }}'
            );
        @endif

        // Handle reactivate (suspended)
        @if($account->status == 'suspended')
            handleAction('reactivateBtn',
                '{{ __('admin.confirm_reactivate') }}',
                '{{ __('admin.confirm_reactivate_account_msg') }}',
                '{{ __('admin.reactivate') }}',
                '{{ route('admin.business-accounts.reactivate', $account) }}',
                '{{ __('admin.business_account_reactivated') }}'
            );
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
