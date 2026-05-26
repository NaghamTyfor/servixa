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
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes changePop {
            0% { transform: scale(1); }
            40% { transform: scale(1.35); }
            100% { transform: scale(1); }
        }

        /* ===== رأس الصفحة ===== */
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
            width: 16px; height: 16px;
        }

        /* ===== الشبكة الرئيسية ===== */
        .modern-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.8rem;
        }
        @media (max-width: 992px) {
            .modern-grid { grid-template-columns: 1fr; }
        }

        /* ===== بطاقة النموذج ===== */
        .form-card {
            background: #fff;
            border-radius: 28px;
            border: 1px solid #ede9fe;
            box-shadow: 0 20px 40px -12px rgba(124,58,237,0.12);
            overflow: hidden;
            animation: scaleIn 0.5s 0.1s both;
        }
        body.dark .form-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.5);
        }
        .form-card-header {
            padding: 1.5rem 2rem;
            background: linear-gradient(to right, #faf5ff, #ffffff);
            border-bottom: 1px solid #ede9fe;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        body.dark .form-card-header {
            background: rgba(255,255,255,0.03);
            border-bottom-color: rgba(124,58,237,0.15);
        }
        .form-card-header-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-dark));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .form-card-header h3 {
            font-weight: 700; font-size: 1.2rem; color: #1e293b; margin: 0;
        }
        body.dark .form-card-header h3 { color: #e2e8f0; }
        .form-card-body {
            padding: 2rem;
        }

        /* ===== حقول الإدخال ===== */
        .input-group-modern {
            margin-bottom: 1.5rem;
        }
        .input-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--purple-dark);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        body.dark .input-label { color: #c4b5fd; }
        .input-label svg {
            width: 16px; height: 16px; stroke: var(--primary-purple);
        }
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            color: #a78bfa;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 2;
        }
        .input-icon svg { width: 18px; height: 18px; }
        .form-control-modern {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 3rem;
            border: 2px solid #e0d4fd;
            border-radius: 16px;
            font-size: 0.95rem;
            background: #fdfcff;
            transition: all var(--transition);
            outline: none;
            color: #1e293b;
        }
        body.dark .form-control-modern {
            background: #13111f;
            border-color: rgba(124,58,237,0.3);
            color: #e2e8f0;
        }
        .form-control-modern:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 4px var(--purple-glow);
            background: white;
        }
        body.dark .form-control-modern:focus {
            background: #1a1830;
            border-color: #a78bfa;
        }

        /* ===== مؤشر التغيير ===== */
        .is-changed {
            border-color: #f59e0b !important;
            box-shadow: 0 0 0 3px rgba(245,158,11,0.14) !important;
        }
        .change-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #f59e0b;
            display: inline-block;
            margin-left: 0.5rem;
            animation: changePop 0.3s ease;
        }

        /* ===== قسم الصلاحيات ===== */
        .permissions-section {
            margin: 2rem 0 1rem;
            border-top: 2px dashed #ede9fe;
            padding-top: 1.5rem;
        }
        .permissions-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--purple-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .module-group {
            background: #faf8ff;
            border-radius: 20px;
            padding: 1.2rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ede9fe;
        }
        body.dark .module-group {
            background: rgba(255,255,255,0.02);
            border-color: rgba(124,58,237,0.15);
        }
        .module-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }
        .module-header .select-all-module {
            accent-color: var(--primary-purple);
            width: 16px; height: 16px;
        }
        .module-name {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-purple);
            text-transform: capitalize;
        }
        .permission-checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem 1.5rem;
        }
        .permission-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 180px;
        }
        .permission-item input[type="checkbox"] {
            accent-color: var(--primary-purple);
            width: 16px; height: 16px;
        }
        .permission-item label {
            font-size: 0.9rem;
            color: #1e293b;
            cursor: pointer;
        }
        body.dark .permission-item label {
            color: #cbd5e1;
        }

        /* ===== أزرار الإجراءات ===== */
        .form-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px dashed #ede9fe;
        }
        .btn-primary-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.9rem 2.2rem;
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-dark));
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all var(--transition);
            box-shadow: 0 10px 20px -8px var(--primary-purple);
            position: relative;
            overflow: hidden;
        }
        .btn-primary-modern::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
            pointer-events: none;
        }
        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 30px -8px var(--primary-purple);
        }
        .btn-secondary-modern {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.9rem 2rem;
            background: transparent;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            color: #64748b;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all var(--transition);
            text-decoration: none;
        }
        body.dark .btn-secondary-modern {
            border-color: #334155;
            color: #94a3b8;
        }
        .btn-secondary-modern:hover {
            border-color: var(--primary-purple);
            color: var(--primary-purple);
            transform: translateY(-2px);
        }

        /* ===== الشريط الجانبي ===== */
        .sidebar-modern {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .live-preview-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #ede9fe;
            padding: 1.8rem 1.5rem;
            box-shadow: 0 20px 30px -12px rgba(124,58,237,0.1);
            animation: scaleIn 0.5s 0.2s both;
        }
        body.dark .live-preview-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }
        .preview-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0eaff;
        }
        body.dark .preview-header {
            border-bottom-color: rgba(124,58,237,0.15);
        }
        .preview-header svg {
            width: 22px; height: 22px;
            stroke: var(--primary-purple);
        }
        .preview-header h4 {
            font-weight: 700; font-size: 1rem; color: #334155; margin: 0;
        }
        body.dark .preview-header h4 { color: #cbd5e1; }
        .preview-city-icon {
            width: 70px; height: 70px;
            border-radius: 20px;
            background: linear-gradient(135deg, #a78bfa, #7c3aed);
            margin: 0 auto 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            box-shadow: 0 15px 25px -8px #7c3aed;
        }
        .preview-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 0;
            border-bottom: 1px dashed #f0eaff;
        }
        .preview-item:last-child { border-bottom: none; }
        .preview-item-icon {
            width: 32px; height: 32px;
            background: #ede9fe;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-purple);
        }
        body.dark .preview-item-icon {
            background: rgba(124,58,237,0.15);
        }
        .preview-item-content { flex: 1; }
        .preview-item-label {
            font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .preview-item-value {
            font-weight: 700; color: #1e293b; word-break: break-word;
        }
        body.dark .preview-item-value { color: #e2e8f0; }
        .preview-placeholder { color: #cbd5e1; font-style: italic; }

        .info-card {
            background: linear-gradient(145deg, #ede9fe, #ffffff);
            border-radius: 24px;
            padding: 1.5rem;
            border: 1px solid #ddd6fe;
            animation: scaleIn 0.5s 0.3s both;
        }
        body.dark .info-card {
            background: #1a1729;
            border-color: rgba(124,58,237,0.25);
        }
        .info-card-title {
            display: flex; align-items: center; gap: 0.6rem;
            font-weight: 700; color: var(--purple-dark); margin-bottom: 1.2rem;
        }
        .info-list {
            list-style: none; padding: 0; margin: 0;
        }
        .info-list li {
            display: flex; align-items: center; gap: 0.8rem;
            padding: 0.6rem 0; font-size: 0.9rem; color: #475569;
            border-bottom: 1px dashed #f0eaff;
        }
        body.dark .info-list li {
            color: #a5b4cb;
            border-bottom-color: rgba(124,58,237,0.15);
        }
        .info-list li:last-child { border-bottom: none; }
        .info-list li svg { width: 16px; height: 16px; stroke: var(--primary-purple); }

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

        /* رسائل التحقق */
        .validation-hint {
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
    </style>
@endsection

@section('content')
<div class="edit-city-wrapper">
    {{-- رابط رجوع --}}
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
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.edit_role') }}</h1>
                    <p>{{ $role->name }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- شبكة المحتوى --}}
    <div class="modern-grid">
        {{-- بطاقة النموذج --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <h3>{{ __('admin.edit_role_name') }}</h3>
            </div>
            <div class="form-card-body">
                <form action="{{ route('admin.roles.update', $role) }}" method="POST" id="editRoleForm">
                    @csrf
                    @method('PUT')

                    {{-- اسم الدور --}}
                    <div class="input-group-modern">
                        <label class="input-label" for="name">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                            {{ __('admin.role_name') }}
                            <span id="changeIndicator" class="change-indicator" style="display:none;"></span>
                        </label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control-modern @error('name') is-invalid @enderror"
                                   value="{{ old('name', $role->name) }}"
                                   data-original="{{ $role->name }}"
                                   placeholder="{{ __('admin.role_name_placeholder') }}"
                                   required
                                   autofocus>
                        </div>
                        @error('name')
                            <div class="validation-hint">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- قسم الصلاحيات --}}
                    <div class="permissions-section">
                        <div class="permissions-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            {{ __('admin.select_permissions') }}
                        </div>

                        @foreach($permissions as $module => $perms)
                            <div class="module-group" data-module="{{ $module }}">
                                <div class="module-header">
                                    <input type="checkbox" class="select-all-module" id="select-all-{{ $module }}" data-module="{{ $module }}">
                                    <label for="select-all-{{ $module }}" class="module-name">{{ $module }}</label>
                                </div>
                                <div class="permission-checkbox-group">
                                    @foreach($perms as $perm)
                                        <div class="permission-item">
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $perm->name }}"
                                                   id="perm-{{ Str::slug($perm->name) }}"
                                                   class="perm-checkbox"
                                                   data-module="{{ $module }}"
                                                   @if($role->hasPermissionTo($perm)) checked @endif
                                                   @if(in_array($perm->name, old('permissions', []))) checked @endif>
                                            <label for="perm-{{ Str::slug($perm->name) }}">{{ $perm->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        {{-- عرض أخطاء الصلاحيات --}}
                        @error('permissions')
                            <div class="validation-hint">{{ $message }}</div>
                        @enderror
                        @error('permissions.*')
                            <div class="validation-hint">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- أزرار الإجراءات --}}
                    <div class="form-actions">
                        <button type="submit" class="btn-primary-modern" id="updateBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                            </svg>
                            {{ __('admin.update') }}
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="btn-secondary-modern">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            {{ __('admin.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- الشريط الجانبي --}}
        <div class="sidebar-modern">
            {{-- معاينة حية --}}
            <div class="live-preview-card">
                <div class="preview-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                    <h4>{{ __('admin.live_preview') }}</h4>
                </div>
                <div class="preview-city-icon" id="previewIcon">
                    <span id="previewIconLetter">{{ strtoupper(substr($role->name, 0, 1)) }}</span>
                </div>
                <div class="preview-item">
                    <div class="preview-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div class="preview-item-content">
                        <div class="preview-item-label">{{ __('admin.role_name') }}</div>
                        <div class="preview-item-value" id="previewName">{{ $role->name }}</div>
                    </div>
                </div>
                <div class="preview-item">
                    <div class="preview-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div class="preview-item-content">
                        <div class="preview-item-label">{{ __('admin.permissions_count') }}</div>
                        <div class="preview-item-value" id="previewCount">{{ $role->permissions->count() }}</div>
                    </div>
                </div>
            </div>

            {{-- بطاقة معلومات --}}
            <div class="info-card">
                <div class="info-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>{{ __('admin.role_info') }}</span>
                </div>
                <ul class="info-list">

                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <strong>{{ __('admin.created_at') }}:</strong> {{ $role->created_at->format('Y-m-d') }}
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <strong>{{ __('admin.updated_at') }}:</strong> {{ $role->updated_at->diffForHumans() }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- نموذج الحذف المخفي (لن يتم استخدامه هنا، لكنه موجود للتوافق) --}}
<form id="deleteForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script src="{{asset('plugins/src/sweetalerts2/custom-swalalert.js')}}"></script>
<script>
    (function() {
        // عناصر المعاينة
        const nameInput = document.getElementById('name');
        const originalName = nameInput.dataset.original;
        const previewName = document.getElementById('previewName');
        const previewIcon = document.getElementById('previewIconLetter');
        const previewCount = document.getElementById('previewCount');
        const changeIndicator = document.getElementById('changeIndicator');

        function updatePreview() {
            const val = nameInput.value.trim();
            previewName.textContent = val || '—';
            previewIcon.textContent = val ? val.charAt(0).toUpperCase() : '👤';

            // مؤشر تغيير الاسم
            const changed = val !== originalName;
            nameInput.classList.toggle('is-changed', changed);
            changeIndicator.style.display = changed ? 'inline-block' : 'none';

            // عدد الصلاحيات المحددة
            const checked = document.querySelectorAll('.perm-checkbox:checked').length;
            previewCount.textContent = checked;
        }

        nameInput.addEventListener('input', updatePreview);
        document.querySelectorAll('.perm-checkbox').forEach(cb => cb.addEventListener('change', updatePreview));

        // تحديد / إلغاء تحديد كل صلاحيات module
        document.querySelectorAll('.select-all-module').forEach(selectAll => {
            selectAll.addEventListener('change', function() {
                const module = this.dataset.module;
                const checkboxes = document.querySelectorAll(`.perm-checkbox[data-module="${module}"]`);
                checkboxes.forEach(cb => cb.checked = this.checked);
                updatePreview();
            });
        });

        // تحديث حالة select-all لكل module عند تغيير فردي
        document.querySelectorAll('.perm-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const module = this.dataset.module;
                const allInModule = document.querySelectorAll(`.perm-checkbox[data-module="${module}"]`);
                const checkedInModule = document.querySelectorAll(`.perm-checkbox[data-module="${module}"]:checked`);
                const selectAll = document.querySelector(`.select-all-module[data-module="${module}"]`);
                if (selectAll) {
                    selectAll.checked = allInModule.length === checkedInModule.length;
                    selectAll.indeterminate = checkedInModule.length > 0 && checkedInModule.length < allInModule.length;
                }
            });
        });

        // تعطيل زر التحديث عند الإرسال
        document.getElementById('editRoleForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('updateBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __('admin.updating') }}';
        });

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
    })();
</script>
@endsection
