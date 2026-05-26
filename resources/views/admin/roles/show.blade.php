{{-- resources/views/admin/roles/show.blade.php --}}
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

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        @keyframes countUp {
            from { opacity: 0; transform: translateY(60%); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* الحاوية الرئيسية */
        .show-role-wrapper {
            animation: fadeIn 0.5s ease;
        }

        /* رأس الصفحة المتطور */
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
            background-image:
                radial-gradient(circle at 30% 40%, rgba(255, 255, 255, 0.08) 0%, transparent 30%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.05) 0%, transparent 40%),
                repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.02) 0px, rgba(255, 255, 255, 0.02) 2px, transparent 2px, transparent 8px);
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
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
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
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .header-text p {
            color: rgba(255, 255, 255, 0.7);
            margin: 0.3rem 0 0;
            font-size: 0.95rem;
        }

        .header-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
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

        /* أزرار الإجراءات */
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
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
            cursor: pointer;
            backdrop-filter: blur(6px);
        }

        .btn-action-primary {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: white;
        }

        .btn-action-primary:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            color: white;
        }

        .btn-action-danger {
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.3);
            color: #fda4af;
        }

        .btn-action-danger:hover {
            background: #f43f5e;
            color: white;
            transform: translateY(-2px);
        }

        /* إحصائيات سريعة */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 1.2rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            animation: scaleIn 0.5s both;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
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
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            animation: countUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) 0.5s both;
        }

        /* الشبكة الرئيسية (عمودان للشاشات الكبيرة) */
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

        /* بطاقة عرض الصلاحيات */
        .section-card {
            background: #fff;
            border-radius: 28px;
            border: 1px solid #ede9fe;
            box-shadow: 0 20px 40px -12px rgba(124, 58, 237, 0.12);
            overflow: hidden;
            animation: scaleIn 0.5s both;
        }

        body.dark .section-card {
            background: #1e1b2e;
            border-color: rgba(124, 58, 237, 0.2);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.5);
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
            background: rgba(255, 255, 255, 0.03);
            border-bottom-color: rgba(124, 58, 237, 0.15);
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

        .section-count {
            background: var(--purple-soft);
            color: var(--primary-purple);
            border-radius: 30px;
            padding: 0.2rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 700;
        }

        body.dark .section-count {
            background: rgba(124, 58, 237, 0.15);
            color: #a78bfa;
        }

        .form-card-body {
            padding: 2rem;
        }

        /* عرض الصلاحيات حسب الوحدة */
        .permission-module {
            margin-bottom: 2rem;
        }

        .module-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--purple-dark);
            margin-bottom: 0.8rem;
            padding-bottom: 0.3rem;
            border-bottom: 2px solid var(--purple-soft);
            text-transform: capitalize;
        }

        .permission-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .permission-badge {
            background: var(--purple-soft);
            color: var(--purple-dark);
            padding: 0.3rem 1rem;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid #ddd6fe;
            transition: all 0.2s ease;
        }

        .permission-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px var(--purple-glow);
        }

        .permission-badge.active {
            background: var(--primary-purple);
            color: white;
            border-color: var(--primary-purple);
        }

        .permission-badge.active:hover {
            background: var(--purple-dark);
        }

        /* بطاقة المعلومات الجانبية */
        .info-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #ede9fe;
            padding: 1.8rem 1.5rem;
            box-shadow: 0 20px 30px -12px rgba(124, 58, 237, 0.1);
            animation: scaleIn 0.5s 0.1s both;
            height: fit-content;
        }

        body.dark .info-card {
            background: #1e1b2e;
            border-color: rgba(124, 58, 237, 0.2);
        }

        .info-card-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 700;
            color: var(--purple-dark);
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid var(--purple-soft);
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
            padding: 0.8rem 0;
            font-size: 0.9rem;
            color: #475569;
            border-bottom: 1px dashed #f0eaff;
        }

        body.dark .info-list li {
            color: #a5b4cb;
            border-bottom-color: rgba(124, 58, 237, 0.15);
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

        .info-list li strong {
            min-width: 90px;
            font-weight: 700;
            color: #334155;
        }

        body.dark .info-list li strong {
            color: #cbd5e1;
        }

        /* رابط العودة */
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

        /* رسالة عدم وجود صلاحيات */
        .empty-permissions {
            text-align: center;
            padding: 2rem;
            color: #94a3b8;
        }
    </style>
@endsection

@section('content')
<div class="show-role-wrapper">
    {{-- رابط العودة إلى القائمة --}}
    <a href="{{ route('admin.roles.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        {{ __('admin.back_to_list') }}
    </a>

    {{-- رأس الصفحة --}}
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
                    <h1>{{ $role->name }}</h1>
                    <p>{{ __('admin.role_details') }}</p>
                </div>
            </div>

        </div>

        {{-- أزرار الإجراءات --}}
        <div class="action-buttons">
            <a href="{{ route('admin.roles.edit', $role) }}" class="btn-action btn-action-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                {{ __('admin.edit_role') }}
            </a>
            @if($role->name !== 'super-admin')
                <button type="button" class="btn-action btn-action-danger" id="deleteBtn"
                        data-role-name="{{ $role->name }}"
                        data-delete-url="{{ route('admin.roles.destroy', $role) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                    {{ __('admin.delete') }}
                </button>
            @endif
        </div>

        {{-- إحصائيات سريعة --}}
        <div class="stats-grid">

            <div class="stat-card" style="animation-delay: 0.15s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.permissions') }}</div>
                    <div class="stat-value">{{ $role->permissions->count() }}</div>
                </div>
            </div>
            <div class="stat-card" style="animation-delay: 0.2s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.created_at') }}</div>
                    <div class="stat-value">{{ $role->created_at->format('Y-m-d') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- الشبكة الرئيسية (عمودان) --}}
    <div class="modern-grid">
        {{-- بطاقة الصلاحيات --}}
        <div class="section-card">
            <div class="section-header">
                <div class="section-header-left">
                    <div class="section-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <h3 class="section-title">{{ __('admin.permissions_assigned') }}</h3>
                </div>
                <span class="section-count">{{ $role->permissions->count() }}</span>
            </div>
            <div class="form-card-body">
                @forelse($permissions as $module => $perms)
                    <div class="permission-module">
                        <div class="module-title">{{ $module }}</div>
                        <div class="permission-list">
                            @foreach($perms as $perm)
                                <span class="permission-badge @if($role->hasPermissionTo($perm->name)) active @endif">
                                    {{ $perm->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="empty-permissions">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        <p class="mt-3">{{ __('admin.no_permissions') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- بطاقة المعلومات الجانبية --}}
        <div class="info-card">
            <div class="info-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="12" x2="12" y2="16"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                <span>{{ __('admin.role_info') }}</span>
            </div>
            <ul class="info-list">
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <strong>{{ __('admin.role_name') }}:</strong>
                    <span>{{ $role->name }}</span>
                </li>

                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <strong>{{ __('admin.created_at') }}:</strong>
                    <span>{{ $role->created_at->format('Y-m-d H:i') }}</span>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <strong>{{ __('admin.updated_at') }}:</strong>
                    <span>{{ $role->updated_at->diffForHumans() }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- نموذج الحذف المخفي --}}
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script src="{{ asset('plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
<script src="{{ asset('plugins/src/sweetalerts2/custom-swalalert.js') }}"></script>
<script>
    (function() {
        const deleteBtn = document.getElementById('deleteBtn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                const roleName = this.dataset.roleName;
                const deleteUrl = this.dataset.deleteUrl;
                Swal.fire({
                    title: '{{ __('admin.confirm_delete') }}',
                    text: '{{ __('admin.delete_confirm_msg') }}: ' + roleName,
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
                        form.action = deleteUrl;
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
    })();
</script>
@endsection
