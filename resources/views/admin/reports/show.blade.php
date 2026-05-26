{{-- resources/views/admin/reports/show.blade.php --}}
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
        }

        .header-text p {
            color: rgba(255,255,255,0.7);
            margin: 0.3rem 0 0;
            font-size: 0.95rem;
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

        .modern-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.8rem;
            margin-top: 2rem;
        }

        @media (max-width: 992px) {
            .modern-grid { grid-template-columns: 1fr; }
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

        .info-row {
            display: flex;
            padding: 1rem 1.8rem;
            border-bottom: 1px solid #f5f3ff;
        }

        body.dark .info-row {
            border-bottom-color: rgba(124,58,237,0.1);
        }

        .info-label {
            width: 130px;
            font-weight: 600;
            color: var(--purple-dark);
            font-size: 0.85rem;
        }

        .info-value {
            flex: 1;
            color: #334155;
        }

        body.dark .info-value {
            color: #cbd5e1;
        }

        .service-card, .user-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #ede9fe;
            padding: 1.2rem;
            margin-top: 1rem;
        }

        body.dark .service-card, body.dark .user-card {
            background: #1e1b2e;
            border-color: rgba(124,58,237,0.2);
        }

        .sidebar-modern {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #ede9fe;
            padding: 1.5rem;
            box-shadow: 0 20px 30px -12px rgba(124,58,237,0.1);
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
<div class="show-report-wrapper">
    <a href="{{ route('admin.reports.index') }}" class="back-link">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.report_details') }}</h1>
                    <p>{{ __('admin.report_information') }}</p>
                </div>
            </div>
        </div>


    </div>

    <div class="modern-grid">
        <div>
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <h3 class="section-title">{{ __('admin.report_information') }}</h3>
                </div>

<div class="info-row">
    <div class="info-label">{{ __('admin.reason') }}</div>
    <div class="info-value">
        @if($report->reason)
            <span class="bg-purple-soft">{{ $report->reason }}</span>
        @else
            <span class="text-muted">—</span>
        @endif
    </div>
</div>
                <div class="info-row">
                    <div class="info-label">{{ __('admin.reported_at') }}</div>
                    <div class="info-value">{{ $report->created_at->format('Y-m-d H:i:s') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">{{ __('admin.last_updated') }}</div>
                    <div class="info-value">{{ $report->updated_at->diffForHumans() }}</div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon" style="background:linear-gradient(135deg,#3b82f6,#6366f1)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <h3 class="section-title">{{ __('admin.reporter_user') }}</h3>
                </div>
                @if($report->user)
                    <div class="user-card">
                        <div class="info-row">
                            <div class="info-label">{{ __('admin.name') }}</div>
                            <div class="info-value">{{ $report->user->first_name }} {{ $report->user->last_name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">{{ __('admin.phone') }}</div>
                            <div class="info-value">{{ $report->user->phone ?? '—' }}</div>
                        </div>

                    </div>
                @else
                    <div class="info-row"><div class="info-value text-muted">{{ __('admin.user_deleted') }}</div></div>
                @endif
            </div>

            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon" style="background:linear-gradient(135deg,#10b981,#059669)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H5.78a1.65 1.65 0 0 0-1.51 1 1.65 1.65 0 0 0 .33 1.82l.07.08A10 10 0 0 0 12 18a10 10 0 0 0 6.33-2.22l.07-.08z"/>
                        </svg>
                    </div>
                    <h3 class="section-title">{{ __('admin.reported_service') }}</h3>
                </div>
                @if($report->service)
                    <div class="service-card">
                        <div class="info-row">
                            <div class="info-label">{{ __('admin.service_title') }}</div>
                            <div class="info-value">{{ $report->service->getTranslation('title', app()->getLocale()) ?: '—' }}</div>
                        </div>

                        @if($report->service->businessAccount)
                            <div class="info-row">
                                <div class="info-label">{{ __('admin.business_name') }}</div>
                                <div class="info-value">{{ $report->service->businessAccount->getTranslation('business_name', app()->getLocale()) ?: '—' }}</div>
                            </div>
                        @endif
                        <div class="info-row">
                            <div class="info-label">{{ __('admin.service_status') }}</div>
                            <div class="info-value">
                                @php $status = $report->service->status ?? 'unknown'; @endphp
                                @if($status === 'approved')
                                    <span class="badge bg-success">{{ __('admin.approved') }}</span>
                                @elseif($status === 'pending')
                                    <span class="badge bg-warning">{{ __('admin.pending') }}</span>
                                @elseif($status === 'rejected')
                                    <span class="badge bg-danger">{{ __('admin.rejected') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('admin.unknown') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">{{ __('admin.actions') }}</div>
                            <div class="info-value">
                                <a href="{{ route('admin.services.show', $report->service) }}" class="btn btn-sm btn-outline-primary">{{ __('admin.view_service') }}</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="info-row"><div class="info-value text-muted">{{ __('admin.service_deleted') }}</div></div>
                @endif
            </div>
        </div>

        <div class="sidebar-modern">
            <div class="info-card">
                <div class="info-card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>{{ __('admin.metadata') }}</span>
                </div>
                <ul class="info-list">
                    <li><strong>{{ __('admin.created_at') }}:</strong> {{ $report->created_at->format('Y-m-d H:i:s') }}</li>
                    <li><strong>{{ __('admin.updated_at') }}:</strong> {{ $report->updated_at->format('Y-m-d H:i:s') }}</li>
                    <li><strong>{{ __('admin.time_ago') }}:</strong> {{ $report->created_at->diffForHumans() }}</li>
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
    document.getElementById('deleteBtn')?.addEventListener('click', function() {
        Swal.fire({
            title: '{{ __('admin.confirm_delete') }}',
            text: '{{ __('admin.delete_report_confirm') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#7c3aed',
            confirmButtonText: '{{ __('admin.delete') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            reverseButtons: true,
            background: document.body.classList.contains('dark') ? '#1e1b2e' : '#fff',
        }).then(r => {
            if (r.isConfirmed) {
                let form = document.getElementById('deleteForm');
                form.action = this.dataset.deleteUrl;
                form.submit();
            }
        });
    });

    @if(session('success'))
    Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
    }).fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif
</script>
@endsection
