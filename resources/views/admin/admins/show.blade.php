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
            --purple-glow: rgba(124,58,237,0.22);
            --card-radius: 24px;
            --transition: 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        /* الأنيميشن */
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
        @keyframes countUp {
            from { opacity:0; transform:translateY(60%); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes floatOrb {
            0%,100% { transform: translate(0,0) scale(1); }
            33%  { transform: translate(26px,-16px) scale(1.06); }
            66%  { transform: translate(-16px,12px) scale(.96); }
        }

        /* ===== رأس الصفحة (Hero Section) ===== */
        .show-hero {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #2e1065 0%, #5b21b6 35%, #7c3aed 65%, #a78bfa 100%);
            border-radius: 32px;
            margin-bottom: 2.5rem;
            animation: slideUp 0.6s cubic-bezier(0.22,1,0.36,1) both;
            box-shadow: 0 20px 40px -15px rgba(124,58,237,0.3);
        }
        .show-hero-orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .show-hero-orb-1 {
            width: 340px; height: 340px;
            right: -80px; top: -110px;
            background: radial-gradient(circle, rgba(167,139,250,0.3) 0%, transparent 70%);
            animation: floatOrb 9s ease-in-out infinite;
        }
        .show-hero-orb-2 {
            width: 200px; height: 200px;
            left: 20%; bottom: -90px;
            background: radial-gradient(circle, rgba(91,33,182,0.35) 0%, transparent 70%);
            animation: floatOrb 12s ease-in-out 2s infinite;
        }
        .show-hero-grid {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 36px 36px;
        }
        .show-hero-inner {
            position: relative;
            z-index: 1;
            padding: 2rem 2.5rem;
        }

        .show-identity {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.8rem;
        }
        .show-admin-avatar {
            width: 80px; height: 80px;
            border-radius: 24px;
            background: rgba(255,255,255,0.12);
            border: 1.5px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.2rem;
            font-weight: 700;
        }
        .show-admin-name {
            font-size: 2.4rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin: 0 0 0.2rem;
        }
        .show-id-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.8);
            border-radius: 50px;
            padding: 0.25rem 0.9rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .show-email {
            color: rgba(255,255,255,0.7);
            font-size: 1rem;
            margin-top: 0.3rem;
        }

        .show-hero-actions {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }
        .hero-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.4rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
        }
        .hero-action-btn-white {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: white;
            backdrop-filter: blur(6px);
        }
        .hero-action-btn-white:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-2px);
        }
        .hero-action-btn-red {
            background: rgba(244,63,94,0.15);
            border: 1px solid rgba(244,63,94,0.3);
            color: #fda4af;
        }
        .hero-action-btn-red:hover {
            background: #f43f5e;
            color: white;
            border-color: #f43f5e;
            transform: translateY(-2px);
        }

        /* ===== إحصائيات سريعة ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }
        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
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
            width: 48px; height: 48px;
            background: rgba(255,255,255,0.15);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .stat-icon svg { width: 24px; height: 24px; }
        .stat-content { flex: 1; }
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
            animation: countUp 0.6s cubic-bezier(.22,1,.36,1) 0.5s both;
        }

        /* ===== الشبكة الرئيسية (عمودين) ===== */
        .modern-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.8rem;
            margin-top: 2rem;
        }
        @media (max-width: 992px) {
            .modern-grid { grid-template-columns: 1fr; }
        }

        /* ===== بطاقة الأقسام ===== */
        .section-card {
            background: #fff;
            border-radius: 28px;
            border: 1px solid #ede9fe;
            box-shadow: 0 20px 40px -12px rgba(124,58,237,0.12);
            overflow: hidden;
            animation: scaleIn 0.5s both;
            margin-bottom: 1.5rem;
            height: fit-content;
        }
        body.dark .section-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }
        .section-header {
            padding: 1.2rem 1.8rem;
            background: linear-gradient(to right, #faf5ff, #ffffff);
            border-bottom: 1px solid #ede9fe;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        body.dark .section-header {
            background: rgba(255,255,255,0.03);
            border-bottom-color: rgba(124,58,237,0.15);
        }
        .section-icon {
            width: 38px; height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .section-title {
            font-weight: 700; font-size: 1rem; color: #1e293b; margin: 0;
        }
        body.dark .section-title { color: #e2e8f0; }
        .section-body {
            padding: 1.8rem;
        }

        /* ===== عرض الصلاحيات (شبكة منظمة) ===== */
        .permission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 0.75rem;
            margin-top: 1rem;
        }
        .permission-badge {
            background: var(--purple-soft);
            color: var(--primary-purple);
            padding: 0.4rem 1rem;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid #ddd6fe;
            text-align: center;
            transition: all 0.2s;
        }
        .permission-badge:hover {
            background: var(--primary-purple);
            color: white;
            border-color: var(--primary-purple);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px var(--purple-glow);
        }
        body.dark .permission-badge {
            background: rgba(124,58,237,0.15);
            color: #a78bfa;
            border-color: rgba(124,58,237,0.3);
        }
        body.dark .permission-badge:hover {
            background: var(--primary-purple);
            color: white;
        }
        .role-badge {
            background: var(--purple-soft);
            color: var(--primary-purple);
            padding: 0.3rem 1.2rem;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            border: 1px solid #ddd6fe;
        }
        body.dark .role-badge {
            background: rgba(124,58,237,0.15);
            color: #a78bfa;
            border-color: rgba(124,58,237,0.3);
        }

        /* ===== بطاقة المعلومات الجانبية ===== */
        .info-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #ede9fe;
            padding: 1.8rem 1.5rem;
            box-shadow: 0 20px 30px -12px rgba(124,58,237,0.1);
            animation: scaleIn 0.5s 0.1s both;
            height: fit-content;
        }
        body.dark .info-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }
        .info-card-title {
            display: flex; align-items: center; gap: 0.6rem;
            font-weight: 700; color: var(--purple-dark); margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid var(--purple-soft);
        }
        .info-card-title svg {
            width: 20px; height: 20px;
            stroke: var(--primary-purple);
        }
        .info-list {
            list-style: none; padding: 0; margin: 0;
        }
        .info-list li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.7rem 0;
            font-size: 0.9rem;
            color: #475569;
            border-bottom: 1px dashed #f0eaff;
        }
        body.dark .info-list li {
            color: #a5b4cb;
            border-bottom-color: rgba(124,58,237,0.15);
        }
        .info-list li:last-child { border-bottom: none; }
        .info-list li svg {
            width: 18px; height: 18px;
            stroke: var(--primary-purple);
            flex-shrink: 0;
        }
        .info-list li strong {
            min-width: 85px;
            font-weight: 600;
            color: #334155;
        }
        body.dark .info-list li strong {
            color: #cbd5e1;
        }

        /* ===== رابط العودة ===== */
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
        .back-link:hover { gap: 0.7rem; }

        /* ===== حالة عدم وجود صلاحيات ===== */
        .empty-permissions {
            text-align: center;
            padding: 2rem;
            color: #94a3b8;
        }
    </style>
@endsection

@section('content')
<div class="layout-top-spacing">
    <a href="{{ route('admin.admins.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        {{ __('admin.back_to_list') }}
    </a>

    {{-- Hero Section --}}
    <div class="show-hero">
        <div class="show-hero-orb show-hero-orb-1"></div>
        <div class="show-hero-orb show-hero-orb-2"></div>
        <div class="show-hero-grid"></div>
        <div class="show-hero-inner">
            <div class="show-identity">
                <div class="show-admin-avatar">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="show-admin-name">{{ $admin->name }}</h1>
                    <div class="show-email">{{ $admin->email }}</div>
                </div>
            </div>

            <div class="show-hero-actions">
                <a href="{{ route('admin.admins.edit', $admin) }}" class="hero-action-btn hero-action-btn-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    {{ __('admin.edit_admin') }}
                </a>
                @if(!$admin->hasRole('super-admin'))
                <button class="hero-action-btn hero-action-btn-red" id="deleteBtn"
                        data-admin-name="{{ $admin->name }}"
                        data-delete-url="{{ route('admin.admins.destroy', $admin) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                    {{ __('admin.delete') }}
                </button>
                @endif
            </div>

            {{-- إحصائيات سريعة محدثة --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">{{ __('admin.roles_count') }}</div>
                        <div class="stat-value">{{ $admin->roles->count() }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">{{ __('admin.permissions_count') }}</div>
                        <div class="stat-value">{{ $admin->getAllPermissions()->count() }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">{{ __('admin.joined') }}</div>
                        <div class="stat-value">{{ $admin->created_at->format('Y-m-d') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- المحتوى الرئيسي (عمودين) --}}
    <div class="modern-grid">
        {{-- العمود الأيسر: الدور والصلاحيات --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <span class="section-title">{{ __('admin.role_and_permissions') }}</span>
            </div>
            <div class="section-body">
                @if($admin->roles->isNotEmpty())
                    <div style="margin-bottom: 1.5rem;">
                        <strong>{{ __('admin.roles') }} ({{ $admin->roles->count() }}):</strong>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                            @foreach($admin->roles as $role)
                                <span class="role-badge">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <strong>{{ __('admin.permissions') }} ({{ $admin->getAllPermissions()->count() }}):</strong>
                        <div class="permission-grid">
                            @forelse($admin->getAllPermissions() as $permission)
                                <span class="permission-badge">{{ $permission->name }}</span>
                            @empty
                                <div class="empty-permissions">
                                    <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#94a3b8" stroke-width="1.5">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                    <p class="mt-2">{{ __('admin.no_permissions') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @else
                    <div class="empty-permissions">
                        <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#94a3b8" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <p class="mt-2">{{ __('admin.no_role_assigned') }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- العمود الأيمن: معلومات الحساب (بدون دور رئيسي) --}}
        <div class="info-card">
            <div class="info-card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="12" x2="12" y2="16"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <span>{{ __('admin.account_info') }}</span>
            </div>
            <ul class="info-list">
                <li>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 7L2 7"/>
                    </svg>
                    <strong>{{ __('admin.email') }}:</strong> {{ $admin->email }}
                </li>
                <li>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <strong>{{ __('admin.created_at') }}:</strong> {{ $admin->created_at->format('Y-m-d H:i') }}
                </li>
                <li>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <strong>{{ __('admin.updated_at') }}:</strong> {{ $admin->updated_at->diffForHumans() }}
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- نموذج الحذف المخفي --}}
<form id="deleteForm" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script src="{{ asset('plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
<script src="{{ asset('plugins/src/sweetalerts2/custom-sweetalert.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBtn = document.getElementById('deleteBtn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                Swal.fire({
                    title: '{{ __('admin.confirm_delete') }}',
                    text: '{{ __('admin.delete_confirm_msg') }}: ' + this.dataset.adminName,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#7c3aed',
                    confirmButtonText: '{{ __('admin.delete') }}',
                    cancelButtonText: '{{ __('admin.cancel') }}',
                    reverseButtons: true,
                    background: document.body.classList.contains('dark') ? '#1e1b2e' : '#fff',
                    color: document.body.classList.contains('dark') ? '#e2e8f0' : '#1e293b',
                }).then(result => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('deleteForm');
                        form.action = this.dataset.deleteUrl;
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
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        }).fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
        @endif
    });
</script>
@endsection
