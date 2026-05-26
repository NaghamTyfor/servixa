{{-- resources/views/admin/cities/show.blade.php --}}
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

        @keyframes rowIn {
            from { opacity: 0; transform: translateX(-10px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* الحاوية الرئيسية */
        .show-city-wrapper {
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

        .header-badge svg {
            width: 16px;
            height: 16px;
        }

        /* بطاقات الإحصائيات */
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

        /* تخطيط الشبكة */
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

        /* بطاقة القسم */
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

        .section-count {
            background: var(--purple-soft);
            color: var(--primary-purple);
            border-radius: 30px;
            padding: 0.2rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 700;
        }

        body.dark .section-count {
            background: rgba(124,58,237,0.15);
            color: #a78bfa;
        }

        /* الجدول المحسن */
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

        .modern-table tbody tr {
            animation: rowIn 0.4s ease both;
            transition: background 0.15s;
        }

        .modern-table tbody tr:hover {
            background: #faf8ff;
        }

        body.dark .modern-table tbody tr:hover {
            background: rgba(124,58,237,0.06);
        }

        .modern-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* العناصر داخل الجدول */
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .business-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .business-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* البادجات */
        .badge-status {
            display: inline-block;
            padding: 0.25rem 0.8rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
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

        /* الشريط الجانبي */
        .sidebar-modern {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* بطاقة المعلومات */
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

        /* بطاقة خريطة (مكان للخريطة) */
        .map-card {
            background: linear-gradient(145deg, #ede9fe, #ffffff);
            border-radius: 24px;
            padding: 1.5rem;
            border: 1px solid #ddd6fe;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        body.dark .map-card {
            background: #1a1729;
            border-color: rgba(124,58,237,0.25);
        }

        /* زر رجوع */
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

        /* حالة عدم وجود بيانات */
        .empty-state {
            padding: 3rem 1.5rem;
            text-align: center;
            color: #94a3b8;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        body.dark .empty-icon {
            background: rgba(255,255,255,0.05);
        }
    </style>
@endsection

@section('content')
<div class="show-city-wrapper">
    {{-- رابط رجوع --}}
    <a href="{{ route('admin.cities.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        {{ __('admin.back_to_list') }}
    </a>

    {{-- رأس الصفحة المتطور --}}
    <div class="page-header-modern">
        <div class="header-bg-pattern"></div>
        <div class="header-content">
            <div class="header-title-area">
                <div class="header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ $city->getTranslation('name', app()->getLocale()) }}</h1>
                    <p>{{ __('admin.city_details') }}</p>
                </div>
            </div>

        </div>

        {{-- أزرار الإجراءات --}}
        <div class="action-buttons">
            <a href="{{ route('admin.cities.edit', $city) }}" class="btn-action btn-action-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                {{ __('admin.edit_city') }}
            </a>
            <a href="{{ route('admin.cities.create') }}" class="btn-action btn-action-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                {{ __('admin.add_city') }}
            </a>
            <button type="button" class="btn-action btn-action-danger" id="deleteBtn"
                    data-city-name="{{ $city->getTranslation('name', app()->getLocale()) }}"
                    data-delete-url="{{ route('admin.cities.destroy', $city) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
                {{ __('admin.delete') }}
            </button>
        </div>

        {{-- إحصائيات سريعة --}}
        <div class="stats-grid">
            <div class="stat-card" style="animation-delay: 0.1s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.total_users') }}</div>
                    <div class="stat-value">{{ $city->users->count() }}</div>
                </div>
            </div>
            <div class="stat-card" style="animation-delay: 0.15s">
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-label">{{ __('admin.business_accounts') }}</div>
                    <div class="stat-value">{{ $city->businessAccounts->count() }}</div>
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
                    <div class="stat-value">{{ $city->created_at->format('Y-m-d') }}</div>
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
                    <div class="stat-label">{{ __('admin.updated_at') }}</div>
                    <div class="stat-value">{{ $city->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- شبكة المحتوى --}}
    <div class="modern-grid">
        {{-- القسم الرئيسي (الجداول) --}}
        <div>
            {{-- جدول المستخدمين --}}
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-left">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                        </div>
                        <h3 class="section-title">{{ __('admin.users_in_city') }}</h3>
                    </div>
                    <span class="section-count">{{ $city->users->count() }}</span>
                </div>

                @if($city->users->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                        </div>
                        <p>{{ __('admin.no_users_in_city') }}</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.user_name') }}</th>
                                    <th>{{ __('admin.user_phone') }}</th>
                                    <th>{{ __('admin.user_status') }}</th>
                                    <th>{{ __('admin.joined_at') }}</th>
                                </tr>
                            </thead>
                            <tbody id="usersBody">
                                @foreach($city->users as $user)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">{{ strtoupper(substr($user->first_name, 0, 1)) }}</div>
                                            <span class="fw-600">{{ $user->first_name }} {{ $user->last_name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge-status badge-active">{{ __('admin.user_active') }}</span>
                                        @else
                                            <span class="badge-status badge-inactive">{{ __('admin.user_inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- جدول الحسابات التجارية --}}
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-left">
                        <div class="section-icon" style="background:linear-gradient(135deg,#3b82f6,#6366f1)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <h3 class="section-title">{{ __('admin.business_accounts') }}</h3>
                    </div>
                    <span class="section-count" style="background:#dbeafe;color:#1e40af">{{ $city->businessAccounts->count() }}</span>
                </div>

                @if($city->businessAccounts->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <p>{{ __('admin.no_data') }}</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.business_name') }}</th>
                                    <th>{{ __('admin.activity_type') }}</th>
                                    <th>{{ __('admin.owner') }}</th>
                                    <th>{{ __('admin.business_status') }}</th>
                                    <th>{{ __('admin.submitted_at') }}</th>
                                </tr>
                            </thead>
                            <tbody id="bizBody">
                                @foreach($city->businessAccounts as $biz)
                                <tr>
                                    <td>
                                        <div class="business-info">
                                            <div class="business-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="fw-600">{{ $biz->getTranslation('business_name', app()->getLocale()) }}</div>
                                                @if($biz->license_number)
                                                    <div style="font-size:0.75rem;color:#94a3b8">{{ $biz->license_number }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($biz->activityType)
                                            <span style="background:#f5f3ff;color:#7c3aed;padding:0.2rem 0.6rem;border-radius:20px;font-size:0.8rem;font-weight:600">
                                                {{ $biz->activityType->getTranslation('name', app()->getLocale()) }}
                                            </span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($biz->user)
                                            <div class="d-flex align-items-center gap-1">
                                                <div class="user-avatar" style="width:28px;height:28px;font-size:0.7rem">
                                                    {{ strtoupper(substr($biz->user->first_name, 0, 1)) }}
                                                </div>
                                                <span>{{ $biz->user->first_name }} {{ $biz->user->last_name }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($biz->status)
                                            @case('approved')
                                                <span class="badge-status badge-approved">{{ __('admin.business_approved') }}</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge-status badge-rejected">{{ __('admin.business_rejected') }}</span>
                                                @break
                                            @default
                                                <span class="badge-status badge-pending">{{ __('admin.business_pending') }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $biz->submitted_at ? $biz->submitted_at->format('Y-m-d') : '—' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- الشريط الجانبي --}}
        <div class="sidebar-modern">
            {{-- بطاقة المعلومات --}}
            <div class="info-card">
                <div class="info-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>{{ __('admin.city_info') }}</span>
                </div>
                <ul class="info-list">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <strong>{{ __('admin.city_name_ar') }}:</strong> {{ $city->getTranslation('name', 'ar') }}
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <strong>{{ __('admin.city_name_en') }}:</strong> {{ $city->getTranslation('name', 'en') }}
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
<script src="{{asset('plugins/src/sweetalerts2/custom-sweetalert.js')}}"></script>
<script>
    // أنيميشن ظهور الصفوف
    function animateRows(selector) {
        document.querySelectorAll(selector).forEach((row, i) => {
            row.style.animationDelay = (i * 0.05) + 's';
        });
    }
    animateRows('#usersBody tr');
    animateRows('#bizBody tr');

    // حذف
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('deleteBtn');
        if (btn) {
            btn.addEventListener('click', function() {
                Swal.fire({
                    title: '{{ __('admin.confirm_delete') }}',
                    text: '{{ __('admin.delete_confirm_msg') }}: ' + this.dataset.cityName,
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
                    if (r.isConfirmed) {
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
            didOpen: t => { t.addEventListener('mouseenter', Swal.stopTimer); t.addEventListener('mouseleave', Swal.resumeTimer); }
        }).fire({ icon: 'success', title: '{{ session('success') }}' });
        @endif
    });
</script>
@endsection
