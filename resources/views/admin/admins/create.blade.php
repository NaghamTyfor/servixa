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
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        /* رأس الصفحة المتطور */
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

        /* الشبكة الرئيسية */
        .modern-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.8rem;
        }
        @media (max-width: 992px) {
            .modern-grid { grid-template-columns: 1fr; }
        }

        /* بطاقة النموذج */
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

        /* حقول الإدخال الأساسية */
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
            padding: 0.85rem 3.2rem 0.85rem 3rem;
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

        /* زر إظهار/إخفاء كلمة المرور */
        .password-wrapper {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(124,58,237,0.08);
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-purple);
            cursor: pointer;
            transition: all 0.2s;
            z-index: 3;
            backdrop-filter: blur(4px);
        }
        .password-toggle:hover {
            background: var(--primary-purple);
            color: white;
            transform: translateY(-50%) scale(1.05);
        }
        .password-toggle svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
        }

        /* ===== بطاقة الأدوار الجديدة (Role Card) ===== */
        .roles-card {
            background: #f8f6ff;
            border-radius: 24px;
            border: 2px dashed #d8cdfe;
            padding: 1.5rem;
            margin: 2rem 0 1rem;
            transition: all var(--transition);
        }
        body.dark .roles-card {
            background: rgba(124,58,237,0.05);
            border-color: rgba(124,58,237,0.3);
        }
        .roles-card:hover {
            border-color: var(--primary-purple);
            background: #fff;
            box-shadow: 0 10px 30px -10px var(--purple-glow);
        }
        body.dark .roles-card:hover {
            background: #1e1b2e;
        }

        .roles-card-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }
        .roles-card-header svg {
            width: 28px;
            height: 28px;
            stroke: var(--primary-purple);
        }
        .roles-card-header h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--purple-dark);
            margin: 0;
        }

        /* حقل البحث داخل البطاقة */
        .role-search-wrapper {
            position: relative;
            margin-bottom: 1.2rem;
        }
        .role-search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--purple-light);
        }
        .role-search-input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            border: 2px solid #e0d4fd;
            border-radius: 50px;
            font-size: 0.95rem;
            background: #fff;
            transition: all var(--transition);
            outline: none;
        }
        body.dark .role-search-input {
            background: #13111f;
            border-color: rgba(124,58,237,0.3);
            color: #e2e8f0;
        }
        .role-search-input:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 4px var(--purple-glow);
        }

        /* قائمة الأدرار (نتائج البحث) */
        .role-options-list {
            max-height: 200px;
            overflow-y: auto;
            border-radius: 20px;
            background: #fff;
            border: 2px solid #ede9fe;
            margin-bottom: 1.2rem;
            display: none; /* مخفية افتراضياً، تظهر عند البحث */
        }
        body.dark .role-options-list {
            background: #1a1729;
            border-color: rgba(124,58,237,0.2);
        }
        .role-options-list.active {
            display: block;
        }
        .role-option-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.7rem 1rem;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid #f0eaff;
        }
        .role-option-item:last-child {
            border-bottom: none;
        }
        .role-option-item:hover {
            background: var(--purple-soft);
        }
        body.dark .role-option-item:hover {
            background: rgba(124,58,237,0.2);
        }
        .role-option-checkbox {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-purple);
        }
        .role-option-name {
            flex: 1;
            font-size: 0.95rem;
            color: #1e293b;
        }
        body.dark .role-option-name {
            color: #e2e8f0;
        }

        /* الأدوار المختارة (Chips) */
        .selected-roles-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            min-height: 40px;
            padding: 0.5rem;
            background: #fff;
            border-radius: 20px;
            border: 2px solid #ede9fe;
        }
        body.dark .selected-roles-container {
            background: #13111f;
            border-color: rgba(124,58,237,0.2);
        }
        .role-chip {
            background: var(--purple-soft);
            border: 1px solid var(--primary-purple);
            border-radius: 30px;
            padding: 0.3rem 1rem 0.3rem 1.2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--purple-dark);
            transition: all 0.2s;
        }
        body.dark .role-chip {
            background: rgba(124,58,237,0.2);
            color: #a78bfa;
            border-color: #7c3aed;
        }
        .role-chip:hover {
            background: var(--primary-purple);
            color: #fff;
            border-color: var(--primary-purple);
        }
        .role-chip-remove {
            background: transparent;
            border: none;
            color: currentColor;
            font-size: 1.2rem;
            line-height: 1;
            cursor: pointer;
            padding: 0 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }
        .role-chip-remove:hover {
            transform: scale(1.2);
            color: #ef4444;
        }

        /* أزرار الإجراءات */
        .form-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 2px dashed #ede9fe;
        }
        body.dark .form-actions { border-top-color: rgba(124,58,237,0.2); }
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
        .btn-primary-modern:disabled {
            opacity: 0.7;
            cursor: not-allowed;
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

        /* الشريط الجانبي (كما هو) */
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
        .preview-header svg { width: 22px; height: 22px; stroke: var(--primary-purple); }
        .preview-header h4 { font-weight: 700; font-size: 1rem; color: #334155; margin: 0; }
        body.dark .preview-header h4 { color: #cbd5e1; }
        .preview-avatar {
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
        .info-card-title svg { width: 20px; height: 20px; stroke: var(--primary-purple); }
        .info-list {
            list-style: none; padding: 0; margin: 0;
        }
        .info-list li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.5rem 0;
            font-size: 0.9rem;
            color: #475569;
        }
        body.dark .info-list li { color: #a5b4cb; }
        .info-list li svg { width: 18px; height: 18px; stroke: var(--primary-purple); }

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
<div class="create-admin-wrapper">
    <a href="{{ route('admin.admins.index') }}" class="back-link">
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
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.add_admin') }}</h1>
                    <p>{{ __('admin.admin_tip') }}</p>
                </div>
            </div>
            <div class="header-badge">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ __('admin.total_admins') }}: {{ \App\Models\Admin::count() }}</span>
            </div>
        </div>
    </div>

    <div class="modern-grid">
        {{-- بطاقة النموذج --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                </div>
                <h3>{{ __('admin.new_admin_account') }}</h3>
            </div>
            <div class="form-card-body">
                <form action="{{ route('admin.admins.store') }}" method="POST" id="createAdminForm">
                    @csrf

                    {{-- حقول أساسية: الاسم، البريد، كلمة المرور --}}
                    <div class="input-group-modern">
                        <label class="input-label">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            {{ __('admin.name') }}
                        </label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <input type="text"
                                   name="name"
                                   class="form-control-modern @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="{{ __('admin.name_placeholder') }}"
                                   required
                                   autocomplete="off"
                                   id="adminName">
                        </div>
                        @error('name')
                            <div class="validation-hint">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group-modern">
                        <label class="input-label">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="4" width="20" height="16" rx="2"/>
                                <path d="m22 7-10 7L2 7"/>
                            </svg>
                            {{ __('admin.email') }}
                        </label>
                        <div class="input-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <path d="m22 7-10 7L2 7"/>
                                </svg>
                            </span>
                            <input type="email"
                                   name="email"
                                   class="form-control-modern @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="{{ __('admin.email_placeholder') }}"
                                   required
                                   autocomplete="off"
                                   id="adminEmail">
                        </div>
                        @error('email')
                            <div class="validation-hint">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group-modern">
                        <label class="input-label">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            {{ __('admin.password') }}
                        </label>
                        <div class="input-wrapper password-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <input type="password"
                                   name="password"
                                   class="form-control-modern @error('password') is-invalid @enderror"
                                   required
                                   id="adminPassword">
                            <button type="button" class="password-toggle" onclick="togglePassword('adminPassword')" aria-label="{{ __('admin.toggle_password') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="validation-hint">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group-modern">
                        <label class="input-label">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                <line x1="17" y1="17" x2="7" y2="17"/>
                            </svg>
                            {{ __('admin.confirm_password') }}
                        </label>
                        <div class="input-wrapper password-wrapper">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control-modern"
                                   required
                                   id="adminPasswordConfirm">
                            <button type="button" class="password-toggle" onclick="togglePassword('adminPasswordConfirm')" aria-label="{{ __('admin.toggle_password') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- ===== بطاقة الأدوار الجديدة (منفصلة ومطورة) ===== --}}
                    <div class="roles-card">
                        <div class="roles-card-header">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <h4>{{ __('admin.roles') }}</h4>
                        </div>

                        {{-- حقل البحث --}}
                        <div class="role-search-wrapper">
                            <span class="role-search-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                            </span>
                            <input type="text" id="roleSearch" class="role-search-input" placeholder="{{ __('admin.search_roles') }}" autocomplete="off">
                        </div>

                        {{-- قائمة النتائج --}}
                        <div id="roleOptionsList" class="role-options-list">
                            @foreach($roles as $role)
                            <div class="role-option-item" data-role-name="{{ $role->name }}">
                                <input type="checkbox" class="role-option-checkbox" value="{{ $role->name }}" id="role_{{ $loop->index }}">
                                <label for="role_{{ $loop->index }}" class="role-option-name">{{ $role->name }}</label>
                            </div>
                            @endforeach
                        </div>

                        {{-- الأدوار المختارة (Chips) --}}
                        <div id="selectedRolesContainer" class="selected-roles-container">
                            {{-- تظهر هنا الأدوار المختارة كشريط --}}
                        </div>

                        {{-- حقل مخفي لإرسال الأدوار المختارة --}}
                        <div id="hiddenRolesInputs"></div>
                    </div>
                    @error('roles')
                        <div class="validation-hint">{{ $message }}</div>
                    @enderror
                    @error('roles.*')
                        <div class="validation-hint">{{ $message }}</div>
                    @enderror

                    {{-- أزرار الإجراءات --}}
                    <div class="form-actions">
                        <button type="submit" class="btn-primary-modern" id="saveBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                <polyline points="17 21 17 13 7 13 7 21"/>
                                <polyline points="7 3 7 8 15 8"/>
                            </svg>
                            {{ __('admin.save') }}
                        </button>
                        <a href="{{ route('admin.admins.index') }}" class="btn-secondary-modern">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            {{ __('admin.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- الشريط الجانبي (نفسه) --}}
        <div class="sidebar-modern">
            <div class="live-preview-card">
                <div class="preview-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <h4>{{ __('admin.live_preview') }}</h4>
                </div>
                <div class="preview-avatar" id="previewAvatar">A</div>
                <div class="preview-item">
                    <div class="preview-item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div class="preview-item-content">
                        <div class="preview-item-label">{{ __('admin.name') }}</div>
                        <div class="preview-item-value" id="previewName">—</div>
                    </div>
                </div>
                <div class="preview-item">
                    <div class="preview-item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-10 7L2 7"/>
                        </svg>
                    </div>
                    <div class="preview-item-content">
                        <div class="preview-item-label">{{ __('admin.email') }}</div>
                        <div class="preview-item-value" id="previewEmail">—</div>
                    </div>
                </div>
                <div class="preview-item">
                    <div class="preview-item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <div class="preview-item-content">
                        <div class="preview-item-label">{{ __('admin.roles') }}</div>
                        <div class="preview-item-value" id="previewRoles">—</div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="info-card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>{{ __('admin.tips') }}</span>
                </div>
                <ul class="info-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>{{ __('admin.tip_name') }}</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>{{ __('admin.tip_password') }}</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>{{ __('admin.tip_role') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
<script src="{{ asset('plugins/src/sweetalerts2/custom-sweetalert.js') }}"></script>
<script>
    // عناصر الصفحة
    const nameInput = document.getElementById('adminName');
    const emailInput = document.getElementById('adminEmail');
    const previewName = document.getElementById('previewName');
    const previewEmail = document.getElementById('previewEmail');
    const previewRoles = document.getElementById('previewRoles');
    const previewAvatar = document.getElementById('previewAvatar');

    // عناصر حقل الأدوار
    const roleSearch = document.getElementById('roleSearch');
    const roleOptionsList = document.getElementById('roleOptionsList');
    const selectedRolesContainer = document.getElementById('selectedRolesContainer');
    const hiddenRolesDiv = document.getElementById('hiddenRolesInputs');
    const roleCheckboxes = document.querySelectorAll('.role-option-checkbox');
    let selectedRoles = []; // مصفوفة لحفظ الأدوار المختارة

    // تحديث المعاينة الحية
    function updatePreview() {
        const name = nameInput.value.trim();
        previewName.textContent = name || '—';
        previewAvatar.textContent = name ? name.charAt(0).toUpperCase() : 'A';
        previewEmail.textContent = emailInput.value.trim() || '—';

        if (selectedRoles.length > 0) {
            previewRoles.textContent = selectedRoles.join(', ');
        } else {
            previewRoles.textContent = '—';
        }
    }

    // إضافة حقل مخفي لكل دور مختار
    function updateHiddenInputs() {
        hiddenRolesDiv.innerHTML = '';
        selectedRoles.forEach(role => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'roles[]';
            input.value = role;
            hiddenRolesDiv.appendChild(input);
        });
    }

    // إزالة دور من المختارة
    function removeRole(roleName) {
        selectedRoles = selectedRoles.filter(r => r !== roleName);
        // تحديث حالة checkbox المقابل
        roleCheckboxes.forEach(cb => {
            if (cb.value === roleName) {
                cb.checked = false;
            }
        });
        renderSelectedChips();
        updateHiddenInputs();
        updatePreview();
    }

    // عرض الأدوار المختارة كشريط (Chips)
    function renderSelectedChips() {
        selectedRolesContainer.innerHTML = '';
        if (selectedRoles.length === 0) {
            // عرض رسالة افتراضية
            selectedRolesContainer.innerHTML = '<span class="text-muted" style="font-size:0.9rem;">{{ __('admin.no_roles_selected') }}</span>';
        } else {
            selectedRoles.forEach(role => {
                const chip = document.createElement('span');
                chip.className = 'role-chip';
                chip.innerHTML = `${role} <button type="button" class="role-chip-remove" data-role="${role}">&times;</button>`;
                selectedRolesContainer.appendChild(chip);
            });
            // إضافة مستمعات الإزالة للأزرار
            document.querySelectorAll('.role-chip-remove').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    removeRole(this.dataset.role);
                });
            });
        }
        updatePreview();
    }

    // إضافة دور إلى المختارة (عند النقر على خيار)
    function addRole(roleName) {
        if (!selectedRoles.includes(roleName)) {
            selectedRoles.push(roleName);
        }
        // تحديث checkbox (للتأكيد)
        roleCheckboxes.forEach(cb => {
            if (cb.value === roleName) {
                cb.checked = true;
            }
        });
        renderSelectedChips();
        updateHiddenInputs();
    }

    // التعامل مع النقر على عنصر الخيار
    document.querySelectorAll('.role-option-item').forEach(item => {
        const checkbox = item.querySelector('.role-option-checkbox');
        item.addEventListener('click', function(e) {
            if (e.target.tagName === 'INPUT') return; // لتجنب التكرار إذا نقر على checkbox نفسه
            const roleName = this.dataset.roleName;
            if (checkbox.checked) {
                // إذا كان محدداً مسبقاً، نزيله
                removeRole(roleName);
                checkbox.checked = false;
            } else {
                // نضيفه
                addRole(roleName);
                checkbox.checked = true;
            }
        });
    });

    // الاستماع لتغيير الـ checkbox مباشرة
    roleCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const roleName = this.value;
            if (this.checked) {
                addRole(roleName);
            } else {
                removeRole(roleName);
            }
        });
    });

    // وظيفة البحث في الأدوار
    roleSearch.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const items = document.querySelectorAll('.role-option-item');
        let visibleCount = 0;
        items.forEach(item => {
            const roleName = item.dataset.roleName.toLowerCase();
            if (roleName.includes(query)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        if (visibleCount > 0) {
            roleOptionsList.classList.add('active');
        } else {
            roleOptionsList.classList.remove('active');
        }
    });

    // إخفاء القائمة عند النقر خارجها (اختياري)
    document.addEventListener('click', function(e) {
        if (!roleSearch.contains(e.target) && !roleOptionsList.contains(e.target)) {
            roleOptionsList.classList.remove('active');
        }
    });

    // إظهار القائمة عند التركيز على حقل البحث
    roleSearch.addEventListener('focus', function() {
        roleOptionsList.classList.add('active');
    });

    // معالجة الأدوار القديمة إذا وجدت (للتعديل)
    @if(old('roles'))
        @foreach(old('roles') as $oldRole)
            addRole('{{ $oldRole }}');
        @endforeach
    @endif

    // تحديث المعاينة أول مرة
    updatePreview();

    // تعطيل زر الحفظ عند الإرسال
    document.getElementById('createAdminForm')?.addEventListener('submit', function() {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> {{ __('admin.saving') }}';
    });

    // دالة إظهار/إخفاء كلمة المرور
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    @endif
</script>
@endsection
