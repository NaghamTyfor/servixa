{{-- resources/views/admin/permissions/index.blade.php --}}
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
            --card-radius: 20px;
            --transition: 0.2s ease;
        }

        /* ===== الهيدر (يبقى كما هو دون تغيير) ===== */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes countUp {
            from { opacity:0; transform:translateY(60%); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes glowPulse {
            0%,100% { filter: drop-shadow(0 0 5px var(--primary-purple)); }
            50% { filter: drop-shadow(0 0 15px var(--purple-light)); }
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
            animation: glowPulse 3s infinite;
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

        .header-badge svg {
            width: 16px;
            height: 16px;
        }

        /* ===== بطاقات الوحدات ===== */
        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .module-card {
            background: #fff;
            border-radius: var(--card-radius);
            border: 1px solid #ede9fe;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            transition: all var(--transition);
        }

        body.dark .module-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }

        .module-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -8px rgba(124,58,237,0.2);
            border-color: var(--purple-light);
        }

        .module-header {
            padding: 1rem 1.5rem;
            background: #fafaff;
            border-bottom: 1px solid #ede9fe;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        body.dark .module-header {
            background: rgba(255,255,255,0.03);
            border-bottom-color: rgba(124,58,237,0.15);
        }

        .module-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .module-icon svg {
            width: 22px;
            height: 22px;
            stroke: white;
            stroke-width: 1.7;
        }

        .module-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1e293b;
            margin: 0;
            flex: 1;
        }

        body.dark .module-title {
            color: #e2e8f0;
        }

        .module-count {
            background: var(--purple-soft);
            color: var(--primary-purple);
            border-radius: 40px;
            padding: 0.2rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .module-body {
            padding: 1.2rem 1.5rem;
        }

        .permission-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            max-height: 300px;
            overflow-y: auto;
            padding-right: 0.3rem;
        }

        .permission-list::-webkit-scrollbar {
            width: 4px;
        }

        .permission-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .permission-list::-webkit-scrollbar-thumb {
            background: var(--purple-light);
            border-radius: 4px;
        }

        .permission-item {
            background: var(--purple-soft);
            border: 1px solid #ddd6fe;
            border-radius: 40px;
            padding: 0.3rem 0.9rem 0.3rem 0.7rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--purple-dark);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: background 0.2s, color 0.2s;
        }

        body.dark .permission-item {
            background: rgba(124,58,237,0.15);
            border-color: rgba(124,58,237,0.3);
            color: var(--purple-light);
        }

        .permission-item:hover {
            background: var(--primary-purple);
            color: white;
            border-color: var(--primary-purple);
        }

        .permission-item svg {
            width: 12px;
            height: 12px;
            stroke: currentColor;
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: var(--purple-soft);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
        }

        .empty-icon svg {
            width: 36px;
            height: 36px;
            stroke: var(--primary-purple);
        }

        .empty-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        body.dark .empty-title {
            color: #e2e8f0;
        }

        .empty-subtitle {
            color: #6b7280;
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
            color: var(--purple-dark);
        }

        .back-link svg {
            transition: transform 0.2s;
        }

        .back-link:hover svg {
            transform: translateX(-3px);
        }
    </style>
@endsection

@section('content')
<div class="create-city-wrapper">
    <a href="{{ route('admin.roles.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        {{ __('admin.back_to_roles') ?? 'العودة إلى الأدوار' }}
    </a>

    <div class="page-header-modern">
        <div class="header-bg-pattern"></div>
        <div class="header-content">
            <div class="header-title-area">
                <div class="header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 2l7 4v6c0 5.5-7 10-7 10s-7-4.5-7-10V6l7-4z"/>
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="8" y1="10" x2="16" y2="10"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.permissions') }}</h1>
                    <p>{{ __('admin.all_permissions_list') ?? 'جميع الصلاحيات المتاحة في النظام' }}</p>
                </div>
            </div>
            <div class="header-badge">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ __('admin.total_permissions') }}: {{ $permissions->flatten()->count() }}</span>
            </div>
        </div>
    </div>

    @if($permissions->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <h3 class="empty-title">{{ __('admin.no_data') }}</h3>
            <p class="empty-subtitle">{{ __('admin.no_permissions_found') ?? 'لا توجد صلاحيات لعرضها' }}</p>
        </div>
    @else
        <div class="permissions-grid">
            @foreach($permissions as $module => $modulePermissions)
                <div class="module-card">
                    <div class="module-header">
                        <div class="module-icon">
                            @switch($module)
                                @case('admins')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                    @break
                                @case('roles')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                    @break
                                @case('permissions')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                    @break
                                @case('cities')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M2 22h20"/>
                                        <path d="M3 22V8l7-3v14"/>
                                        <path d="M12 22V5l8 4v13"/>
                                        <path d="M8 14h.01"/>
                                        <path d="M16 14h.01"/>
                                    </svg>
                                    @break
                                @case('activity_types')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                                        <polyline points="2 17 12 22 22 17"/>
                                        <polyline points="2 12 12 17 22 12"/>
                                    </svg>
                                    @break
                                @case('categories')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M4 4h16v16H4z"/>
                                        <path d="M9 8h6"/>
                                        <path d="M9 12h6"/>
                                        <path d="M9 16h6"/>
                                    </svg>
                                    @break
                                @case('sub_categories')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M4 4h6v6H4z"/>
                                        <path d="M14 4h6v6h-6z"/>
                                        <path d="M4 14h6v6H4z"/>
                                        <path d="M14 14h6v6h-6z"/>
                                    </svg>
                                    @break
                                @case('business_accounts')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                    </svg>
                                    @break
                                @case('services')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="3"/>
                                        <path d="M19.4 15a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H5.78a1.65 1.65 0 0 0-1.51 1 1.65 1.65 0 0 0 .33 1.82l.07.08A10 10 0 0 0 12 18a10 10 0 0 0 6.33-2.22l.07-.08z"/>
                                    </svg>
                                    @break
                                @case('dynamic_fields')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="9" y1="9" x2="15" y2="15"/>
                                        <line x1="15" y1="9" x2="9" y2="15"/>
                                    </svg>
                                    @break
                                @case('sliders')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="2" y="4" width="20" height="16" rx="2" ry="2"/>
                                        <line x1="8" y1="10" x2="16" y2="10"/>
                                        <line x1="12" y1="10" x2="12" y2="14"/>
                                        <circle cx="12" cy="14" r="1"/>
                                        <line x1="16" y1="14" x2="22" y2="14"/>
                                        <line x1="2" y1="14" x2="8" y2="14"/>
                                    </svg>
                                    @break
                                @case('reports')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10 9 9 9 8 9"/>
                                    </svg>
                                    @break
                                @default
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                        <line x1="8" y1="21" x2="16" y2="21"/>
                                        <line x1="12" y1="17" x2="12" y2="21"/>
                                    </svg>
                            @endswitch
                        </div>
                        <h3 class="module-title">{{ ucfirst($module) }}</h3>
                        <span class="module-count">{{ $modulePermissions->count() }}</span>
                    </div>
                    <div class="module-body">
                        <div class="permission-list">
                            @foreach($modulePermissions as $permission)
                                <span class="permission-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                    {{ $permission->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script src="{{asset('plugins/src/sweetalerts2/custom-swalalert.js')}}"></script>
@endsection
