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

        /* Animations */
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
        @keyframes countUp {
            from { opacity:0; transform:translateY(60%); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes spinAnim {
            to { transform:translateY(-50%) rotate(360deg); }
        }

        /* ===== Modern Header ===== */
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
            top: 0; right: 0; bottom: 0; left: 0;
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
            width: 64px; height: 64px;
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
            width: 32px; height: 32px;
            stroke: white; stroke-width: 1.8;
        }

        .header-text h1 {
            font-size: 2.2rem; font-weight: 800; color: white;
            margin: 0; letter-spacing: -0.02em; line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .header-text p {
            color: rgba(255,255,255,0.7);
            margin: 0.3rem 0 0; font-size: 0.95rem;
        }

        .header-stats-cluster {
            display: flex;
            gap: 0.75rem;
        }

        .hstat {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.16);
            backdrop-filter: blur(8px);
            border-radius: 14px;
            padding: 0.65rem 1rem;
            min-width: 95px;
            text-align: center;
            animation: fadeIn 0.5s ease both;
        }

        .hstat-num {
            font-size: 1.5rem; font-weight: 800; color: #fff; line-height: 1; display: block; overflow: hidden;
        }

        .hstat-num span {
            display: block;
            animation: countUp 0.6s cubic-bezier(.22,1,.36,1) 0.5s both;
        }

        .hstat-lbl {
            font-size: 0.63rem; font-weight: 500; color: rgba(255,255,255,0.5);
            text-transform: uppercase; letter-spacing: 0.05em; margin-top: 2px;
        }

        /* ===== Toolbar ===== */
        .admins-toolbar {
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

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* كل حقل بحث مستقل */
        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 300px;
        }

        .search-wrapper .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a78bfa;
            pointer-events: none;
            z-index: 1;
        }

        .search-wrapper .search-field {
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

        body.dark .search-wrapper .search-field {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.3);
            color: #e2e8f0;
        }

        .search-wrapper .search-field:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 4px var(--purple-glow);
        }

        .search-wrapper .search-spinner {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 18px; height: 18px;
            border: 2px solid rgba(124,58,237,0.2);
            border-top-color: var(--primary-purple);
            border-radius: 50%;
            animation: spinAnim 0.6s linear infinite;
            display: none;
            pointer-events: none;
            z-index: 1;
        }

        .select-all-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--purple-soft);
            border: 2px solid #ddd6fe;
            border-radius: 60px;
            padding: 0.5rem 1.2rem;
            cursor: pointer;
            transition: all var(--transition);
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--purple-dark);
        }

        body.dark .select-all-wrapper {
            background: rgba(124,58,237,0.15);
            border-color: rgba(124,58,237,0.3);
            color: var(--purple-light);
        }

        .select-all-wrapper:hover {
            background: var(--primary-purple);
            color: #fff;
            border-color: var(--primary-purple);
            transform: translateY(-2px);
            box-shadow: 0 6px 14px var(--purple-glow);
        }

        .select-all-checkbox {
            width: 16px; height: 16px;
            accent-color: var(--primary-purple);
        }

        .btn-bulk-delete {
            display: none;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.2rem;
            border-radius: 60px;
            background: #fef2f2;
            border: 2px solid #fecaca;
            color: #dc2626;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
        }

        body.dark .btn-bulk-delete {
            background: rgba(220,38,38,0.1);
            border-color: rgba(220,38,38,0.3);
            color: #f87171;
        }

        .btn-bulk-delete.visible {
            display: inline-flex;
            animation: scaleIn 0.2s ease;
        }

        .btn-bulk-delete:hover {
            background: #dc2626;
            color: #fff;
            border-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(220,38,38,0.3);
        }

        .btn-add-admin {
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
            position: relative;
            overflow: hidden;
        }

        .btn-add-admin::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
            pointer-events: none;
        }

        .btn-add-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px var(--primary-purple);
        }

        /* ===== Grid ===== */
        .admins-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        /* Admin Card */
        .admin-card {
            background: #fff;
            border: 1.5px solid #f0eeff;
            border-radius: var(--card-radius);
            overflow: hidden;
            cursor: pointer;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.2s;
            animation: scaleIn 0.5s ease both;
            box-shadow: 0 6px 14px rgba(0,0,0,0.02);
        }

        body.dark .admin-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }

        .admin-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -10px var(--purple-glow);
            border-color: var(--purple-light);
        }

        .admin-card.selected {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px var(--purple-glow);
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

        .admin-card:hover .card-accent-bar {
            transform: scaleX(1);
        }

        .admin-card-header {
            padding: 1.2rem 1.2rem 0.5rem;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .admin-icon-wrapper {
            width: 50px; height: 50px;
            border-radius: 16px;
            background: var(--purple-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        body.dark .admin-icon-wrapper {
            background: rgba(124,58,237,0.2);
        }

        .admin-icon-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--purple-dark), var(--primary-purple));
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        .admin-card:hover .admin-icon-wrapper::before {
            transform: scale(1);
        }

        .admin-icon-wrapper svg {
            color: var(--primary-purple);
            transition: color 0.3s;
            position: relative;
            z-index: 1;
            width: 24px; height: 24px;
        }

        .admin-card:hover .admin-icon-wrapper svg {
            color: #fff;
        }

        .card-top-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-checkbox {
            width: 18px; height: 18px;
            accent-color: var(--primary-purple);
            cursor: pointer;
        }

        .admin-card-info {
            padding: 0.3rem 1.2rem 0.8rem;
        }

        .admin-name {
            font-size: 1.2rem; font-weight: 700; color: #1e1b4b; margin: 0 0 0.3rem;
        }

        body.dark .admin-name {
            color: #e2e8f0;
        }

        .admin-email {
            font-size: 0.85rem; color: #6b7280; margin-bottom: 0.5rem;
        }

        body.dark .admin-email {
            color: #9ca3af;
        }

        /* تنسيق قائمة الأدوار المتعددة */
        .roles-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
            margin-top: 0.3rem;
        }
        .role-badge {
            background: var(--purple-soft);
            color: var(--primary-purple);
            padding: 0.2rem 0.8rem;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid #ddd6fe;
            display: inline-block;
        }
        body.dark .role-badge {
            background: rgba(124,58,237,0.15);
            color: #a78bfa;
            border-color: rgba(124,58,237,0.3);
        }

        .admin-card-footer {
            padding: 0.8rem 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #f5f3ff;
            background: #fafafe;
        }

        body.dark .admin-card-footer {
            border-color: rgba(124,58,237,0.15);
            background: rgba(255,255,255,0.02);
        }

        .card-id-badge {
            font-size: 0.7rem; font-weight: 700; color: #a78bfa;
            background: #f5f3ff; padding: 0.2rem 0.8rem; border-radius: 40px;
        }

        body.dark .card-id-badge {
            background: rgba(124,58,237,0.2);
            color: var(--purple-light);
        }

        /* Action buttons */
        .card-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .action-icon-btn {
            width: 40px; height: 40px;
            border-radius: 14px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            background: transparent;
            position: relative;
            overflow: hidden;
        }

        .action-icon-btn svg {
            width: 20px; height: 20px;
            transition: transform 0.2s;
        }

        .action-icon-btn:hover svg {
            transform: scale(1.2);
        }

        .action-view {
            background: #eff6ff; color: #3b82f6;
        }
        .action-view:hover {
            background: #3b82f6; color: white; box-shadow: 0 6px 14px rgba(59,130,246,0.4);
        }

        .action-edit {
            background: #f0fdf4; color: #16a34a;
        }
        .action-edit:hover {
            background: #16a34a; color: white; box-shadow: 0 6px 14px rgba(22,163,74,0.4);
        }

        .action-delete {
            background: #fef2f2; color: #dc2626;
        }
        .action-delete:hover {
            background: #dc2626; color: white; box-shadow: 0 6px 14px rgba(220,38,38,0.4);
        }

        /* Empty state */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 90px; height: 90px;
            background: var(--purple-soft);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            position: relative;
        }

        .empty-icon::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px dashed #ddd6fe;
            animation: rotateSlow 12s linear infinite;
        }

        .empty-title {
            font-size: 1.4rem; font-weight: 700; color: #374151; margin-bottom: 0.5rem;
        }

        body.dark .empty-title {
            color: #e2e8f0;
        }

        .empty-subtitle {
            color: #9ca3af; font-size: 0.9rem;
        }

        /* Pagination - نفس تصميم activity-types */
        .admins-pagination {
            margin-top: 2.5rem;
        }

        .pagination-custom_solid {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pagination-custom_solid .prev,
        .pagination-custom_solid .next {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px !important;
            height: 40px !important;
            min-width: 40px !important;
            border-radius: 50% !important;
            background-color: var(--purple-soft) !important;
            color: var(--primary-purple) !important;
            border: 1px solid #ddd6fe !important;
            padding: 0 !important;
            line-height: 1 !important;
            flex-shrink: 0 !important;
            text-decoration: none !important;
            box-sizing: border-box !important;
        }

        .pagination-custom_solid .prev svg,
        .pagination-custom_solid .next svg {
            width: 20px;
            height: 20px;
            display: block;
        }

        .pagination-custom_solid .prev.disabled,
        .pagination-custom_solid .next.disabled {
            opacity: 0.5;
            pointer-events: none;
            background-color: #f1f5f9 !important;
            color: #9ca3af !important;
            border-color: #e2e8f0 !important;
        }

        body.dark .pagination-custom_solid .prev.disabled,
        body.dark .pagination-custom_solid .next.disabled {
            background-color: #2d2a3b !important;
            color: #6b7280 !important;
            border-color: rgba(255,255,255,0.1) !important;
        }

        .pagination-custom_solid .prev:hover:not(.disabled),
        .pagination-custom_solid .next:hover:not(.disabled) {
            background-color: var(--primary-purple) !important;
            color: #fff !important;
            border-color: var(--primary-purple) !important;
        }

        .pagination-custom_solid ul.pagination {
            display: flex;
            gap: 6px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .pagination-custom_solid ul.pagination li a,
        .pagination-custom_solid ul.pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px !important;
            height: 40px !important;
            min-width: 40px !important;
            border-radius: 50% !important;
            background-color: #fff !important;
            color: #1e293b !important;
            border: 1px solid transparent !important;
            transition: all var(--transition) !important;
            text-decoration: none !important;
            padding: 0 !important;
            line-height: 1 !important;
            font-weight: 600;
            box-sizing: border-box !important;
        }

        body.dark .pagination-custom_solid ul.pagination li a,
        body.dark .pagination-custom_solid ul.pagination li span {
            background-color: #1e1b2e !important;
            color: #e2e8f0 !important;
            border-color: rgba(124,58,237,0.2) !important;
        }

        .pagination-custom_solid ul.pagination li a:hover {
            background-color: var(--purple-soft) !important;
            color: var(--primary-purple) !important;
            border-color: var(--primary-purple) !important;
        }

        .pagination-custom_solid ul.pagination li a.active {
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-dark)) !important;
            color: #fff !important;
            border-color: transparent !important;
            box-shadow: 0 4px 10px var(--purple-glow) !important;
            font-weight: 700 !important;
        }

        .pagination-custom_solid ul.pagination li.disabled span {
            opacity: 0.5;
            pointer-events: none;
            background-color: #f1f5f9 !important;
            color: #9ca3af !important;
        }

        body.dark .pagination-custom_solid ul.pagination li.disabled span {
            background-color: #2d2a3b !important;
            color: #6b7280 !important;
        }

        mark {
            background: rgba(250,204,21,0.3);
            color: #854d0e;
            border-radius: 3px;
            padding: 0 2px;
        }
        body.dark mark {
            background: rgba(250,204,21,0.25);
            color: #fbbf24;
        }

        [data-bs-toggle="tooltip"] {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
<div class="layout-top-spacing">
    {{-- Modern Header --}}
    <div class="page-header-modern">
        <div class="header-bg-pattern"></div>
        <div class="header-content">
            <div class="header-title-area">
                <div class="header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.administrators') }}</h1>
                    <p>{{ __('admin.admins_management') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="admins-toolbar">
        <div class="toolbar-left">
            {{-- حقل البحث بالاسم --}}
            <div class="search-wrapper">
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
                <input type="text" id="searchName" class="search-field" value="{{ $nameSearch }}" placeholder="{{ __('admin.search_by_name') }}..." autocomplete="off">
                <div class="search-spinner" id="searchNameSpinner"></div>
            </div>

            {{-- حقل البحث بالبريد --}}
            <div class="search-wrapper">
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </div>
                <input type="text" id="searchEmail" class="search-field" value="{{ $emailSearch }}" placeholder="{{ __('admin.search_by_email') }}..." autocomplete="off">
                <div class="search-spinner" id="searchEmailSpinner"></div>
            </div>

            <label class="select-all-wrapper" id="selectAllWrapper">
                <input type="checkbox" class="select-all-checkbox" id="selectAllCheckbox">
                <span>{{ __('admin.select_all') }}</span>
            </label>
            <button class="btn-bulk-delete" id="btnBulkDelete">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
                {{ __('admin.bulk_delete') }} <span id="bulkCount"></span>
            </button>
        </div>
        <div class="toolbar-right">
            <a href="{{ route('admin.admins.create') }}" class="btn-add-admin">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                {{ __('admin.add_admin') }}
            </a>


            <a href="{{ route('admin.admins.trashed') }}" class="btn-add-admin btn-trash" style="background: #6c757d;">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
    </svg>
    {{ __('admin.trashed') }}
</a>
        </div>
    </div>

    {{-- Grid Container --}}
    <div id="adminsContainer">
        {{-- هذا الجزء هو الذي سيتم تحديثه عبر AJAX، لكننا سنكتبه هنا كاملاً --}}
        @include('admin.admins.partials.grid')
    </div>
</div>

{{-- Delete Forms --}}
<form id="bulkDeleteForm" method="POST" action="{{ route('admin.admins.bulk-destroy') }}" style="display:none;">
    @csrf
    <input type="hidden" name="ids" id="bulkIds">
</form>
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script src="{{asset('plugins/src/sweetalerts2/custom-sweetalert.js')}}"></script>
<script>
    // متغيرات عامة
    let checkboxes = document.querySelectorAll('.admin-checkbox');
    const bulkBtn = document.getElementById('btnBulkDelete');
    const bulkCountEl = document.getElementById('bulkCount');
    const bulkIdsEl = document.getElementById('bulkIds');
    let selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const selectAllWrapper = document.getElementById('selectAllWrapper');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');
    const singleDeleteForm = document.getElementById('deleteForm');
    const searchName = document.getElementById('searchName');
    const searchEmail = document.getElementById('searchEmail');
    const searchNameSpinner = document.getElementById('searchNameSpinner');
    const searchEmailSpinner = document.getElementById('searchEmailSpinner');
    const adminsContainer = document.getElementById('adminsContainer');
    let selectedIds = [], searchTimeout;

    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    function updateBulkBtn() {
        checkboxes = document.querySelectorAll('.admin-checkbox');
        selectedIds = [...document.querySelectorAll('.admin-checkbox:checked')].map(cb => cb.value);
        if (selectedIds.length > 0) {
            bulkBtn.classList.add('visible');
            bulkCountEl.textContent = '(' + selectedIds.length + ')';
        } else {
            bulkBtn.classList.remove('visible');
            bulkCountEl.textContent = '';
        }
        document.querySelectorAll('.admin-card').forEach(card => {
            card.classList.toggle('selected', !!card.querySelector('.admin-checkbox')?.checked);
        });
        if (selectAllCheckbox) {
            const total = checkboxes.length;
            if (selectedIds.length === total && total > 0) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else if (!selectedIds.length) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }
    }

    function cardClickHandler(e) {
        if (e.target.closest('a,button,input,.action-icon-btn,.admin-checkbox')) return;
        const url = this.dataset.url;
        if (url) window.location.href = url;
    }

    function deleteHandler(e) {
        e.preventDefault();
        e.stopPropagation();
        confirmDelete(this, 'single');
    }

    window.confirmDelete = function(btn, type = 'single') {
        let title, text;
        if (type === 'single') {
            title = '{{ __('admin.confirm_delete') }}';
            text = '{{ __('admin.delete_confirm_msg') }}: ' + btn.dataset.adminName;
        } else {
            if (!selectedIds.length) return;
            title = '{{ __('admin.confirm_bulk_delete') }}';
            text = '{{ __('admin.bulk_delete_confirm_msg') }} — {{ __('admin.selected_count') }}: ' + selectedIds.length;
        }
        Swal.fire({
            title,
            text,
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
            if (!r.isConfirmed) return;
            if (type === 'single') {
                singleDeleteForm.action = btn.dataset.deleteUrl;
                singleDeleteForm.submit();
            } else {
                bulkIdsEl.value = JSON.stringify(selectedIds);
                bulkDeleteForm.submit();
            }
        });
    };

    function rebindEvents() {
        checkboxes = document.querySelectorAll('.admin-checkbox');
        selectAllCheckbox = document.getElementById('selectAllCheckbox');
        checkboxes.forEach(cb => {
            cb.removeEventListener('change', updateBulkBtn);
            cb.addEventListener('change', updateBulkBtn);
        });
        document.querySelectorAll('.admin-card').forEach(card => {
            card.removeEventListener('click', cardClickHandler);
            card.addEventListener('click', cardClickHandler);
        });
        document.querySelectorAll('.action-delete').forEach(btn => {
            btn.removeEventListener('click', deleteHandler);
            btn.addEventListener('click', deleteHandler);
        });
        if (selectAllCheckbox) {
            selectAllCheckbox.removeEventListener('change', selectAllHandler);
            selectAllCheckbox.addEventListener('change', selectAllHandler);
        }
        updateBulkBtn();
        initTooltips();
    }

    function selectAllHandler() {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateBulkBtn();
    }

    if (selectAllWrapper) {
        selectAllWrapper.addEventListener('click', function(e) {
            if (e.target.tagName === 'INPUT') return;
            const cb = document.getElementById('selectAllCheckbox');
            if (cb) {
                cb.checked = !cb.checked;
                cb.dispatchEvent(new Event('change'));
            }
        });
    }

    bulkBtn.addEventListener('click', () => {
        if (selectedIds.length) confirmDelete(bulkBtn, 'bulk');
    });

    // دالة البحث
    function performSearch() {
        const name = searchName.value.trim();
        const email = searchEmail.value.trim();

        const url = new URL('{{ route('admin.admins.index') }}');
        if (name) url.searchParams.set('name', name);
        else url.searchParams.delete('name');
        if (email) url.searchParams.set('email', email);
        else url.searchParams.delete('email');
        url.searchParams.set('page', '1');

        window.history.pushState({}, '', url.toString());

        // إظهار الـ spinners
        if (searchNameSpinner) searchNameSpinner.style.display = 'block';
        if (searchEmailSpinner) searchEmailSpinner.style.display = 'block';

        fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const nc = doc.getElementById('adminsContainer');
                if (nc) adminsContainer.innerHTML = nc.innerHTML;
                rebindEvents();
                highlightSearch();
                // إخفاء الـ spinners
                if (searchNameSpinner) searchNameSpinner.style.display = 'none';
                if (searchEmailSpinner) searchEmailSpinner.style.display = 'none';
            })
            .catch(() => {
                if (searchNameSpinner) searchNameSpinner.style.display = 'none';
                if (searchEmailSpinner) searchEmailSpinner.style.display = 'none';
            });
    }

    // ربط أحداث البحث مع debounce
    [searchName, searchEmail].forEach(input => {
        input.addEventListener('input', function() {
            if (searchNameSpinner) searchNameSpinner.style.display = 'block';
            if (searchEmailSpinner) searchEmailSpinner.style.display = 'block';

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 300);
        });
    });

    // تمييز نتائج البحث
    function highlightSearch() {
        const nameTerm = new URLSearchParams(window.location.search).get('name');
        const emailTerm = new URLSearchParams(window.location.search).get('email');

        if (nameTerm) {
            const rxName = new RegExp(`(${nameTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            document.querySelectorAll('.admin-name').forEach(el => {
                el.innerHTML = el.innerText.replace(rxName, '<mark>$1</mark>');
            });
        }
        if (emailTerm) {
            const rxEmail = new RegExp(`(${emailTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            document.querySelectorAll('.admin-email').forEach(el => {
                el.innerHTML = el.innerText.replace(rxEmail, '<mark>$1</mark>');
            });
        }
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
            didOpen: t => { t.addEventListener('mouseenter', Swal.stopTimer); t.addEventListener('mouseleave', Swal.resumeTimer); }
        }).fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif
    });

    window.addEventListener('popstate', () => {
        const params = new URLSearchParams(window.location.search);
        searchName.value = params.get('name') || '';
        searchEmail.value = params.get('email') || '';
        performSearch();
    });
</script>
@endsection
