{{-- resources/views/admin/sub-categories/show.blade.php --}}
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
        @keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeIn  { from{opacity:0} to{opacity:1} }
        @keyframes scaleIn { from{opacity:0;transform:scale(0.95)} to{opacity:1;transform:scale(1)} }
        @keyframes rowIn   { from{opacity:0;transform:translateX(-10px)} to{opacity:1;transform:translateX(0)} }

        .show-wrapper { animation:fadeIn 0.5s ease; }
        .page-header-modern {
            position:relative;background:linear-gradient(135deg,#2e1065 0%,#5b21b6 40%,#7c3aed 80%,#a78bfa 100%);
            border-radius:32px;padding:2rem 2.5rem;margin-bottom:2.5rem;overflow:hidden;
            box-shadow:0 20px 40px -15px rgba(124,58,237,0.3);animation:slideUp 0.6s cubic-bezier(0.22,1,0.36,1);
        }
        .header-bg-pattern {
            position:absolute;top:0;right:0;bottom:0;left:0;pointer-events:none;
            background-image:radial-gradient(circle at 30% 40%,rgba(255,255,255,0.08) 0%,transparent 30%),
            radial-gradient(circle at 80% 70%,rgba(255,255,255,0.05) 0%,transparent 40%),
            repeating-linear-gradient(45deg,rgba(255,255,255,0.02) 0px,rgba(255,255,255,0.02) 2px,transparent 2px,transparent 8px);
        }
        .header-content { position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem; }
        .header-title-area { display:flex;align-items:center;gap:1.2rem; }
        .header-icon { width:64px;height:64px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border-radius:18px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,0.25);box-shadow:0 8px 20px rgba(0,0,0,0.15); }
        .header-icon svg { width:32px;height:32px;stroke:white;stroke-width:1.8; }
        .header-text h1 { font-size:2.2rem;font-weight:800;color:white;margin:0;letter-spacing:-0.02em;line-height:1.2;text-shadow:0 2px 10px rgba(0,0,0,0.2); }
        .header-text p  { color:rgba(255,255,255,0.7);margin:0.3rem 0 0;font-size:0.95rem; }
        .stats-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-top:1.5rem; }
        .stat-card { background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.15);border-radius:20px;padding:1.2rem 1rem;display:flex;align-items:center;gap:1rem;transition:all 0.3s ease;animation:scaleIn 0.5s both; }
        .stat-icon { width:48px;height:48px;background:rgba(255,255,255,0.15);border-radius:16px;display:flex;align-items:center;justify-content:center;color:white; }
        .stat-icon svg { width:24px;height:24px; }
        .stat-content { flex:1; }
        .stat-label { font-size:0.75rem;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.05em; }
        .stat-value { font-size:1.8rem;font-weight:800;color:white;line-height:1.2; }
        .action-buttons { display:flex;gap:0.8rem;flex-wrap:wrap;margin-top:1.5rem; }
        .btn-action { display:inline-flex;align-items:center;gap:0.5rem;padding:0.7rem 1.5rem;border-radius:50px;font-weight:600;font-size:0.9rem;transition:all 0.2s;text-decoration:none;border:none;cursor:pointer; }
        .btn-action-primary { background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:white;backdrop-filter:blur(6px); }
        .btn-action-primary:hover { background:rgba(255,255,255,0.25);transform:translateY(-2px);color:white; }
        .btn-action-danger { background:rgba(244,63,94,0.15);border:1px solid rgba(244,63,94,0.3);color:#fda4af; }
        .btn-action-danger:hover { background:#f43f5e;color:white;transform:translateY(-2px); }
        .modern-grid { display:grid;grid-template-columns:1fr 320px;gap:1.8rem;margin-top:2rem; }
        @media(max-width:992px) { .modern-grid { grid-template-columns:1fr; } }
        .section-card { background:#fff;border-radius:28px;border:1px solid #ede9fe;box-shadow:0 20px 40px -12px rgba(124,58,237,0.12);overflow:hidden;animation:scaleIn 0.5s both; }
        body.dark .section-card { background:#1e1b2e;border-color:rgba(124,58,237,0.2); }
        .section-header { padding:1.2rem 1.8rem;background:linear-gradient(to right,#faf5ff,#ffffff);border-bottom:1px solid #ede9fe;display:flex;align-items:center;justify-content:space-between; }
        body.dark .section-header { background:rgba(255,255,255,0.03);border-bottom-color:rgba(124,58,237,0.15); }
        .section-header-left { display:flex;align-items:center;gap:0.8rem; }
        .section-icon { width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,var(--primary-purple),var(--purple-dark));display:flex;align-items:center;justify-content:center;color:white; }
        .section-title { font-weight:700;font-size:1rem;color:#1e293b;margin:0; }
        body.dark .section-title { color:#e2e8f0; }
        .section-count { background:var(--purple-soft);color:var(--primary-purple);border-radius:30px;padding:0.2rem 0.8rem;font-size:0.8rem;font-weight:700; }
        body.dark .section-count { background:rgba(124,58,237,0.15);color:#a78bfa; }
        .btn-add-section { display:inline-flex;align-items:center;gap:0.4rem;padding:0.5rem 1rem;border-radius:30px;background:var(--primary-purple);color:white;font-size:0.82rem;font-weight:600;text-decoration:none;transition:all 0.2s; }
        .btn-add-section:hover { background:var(--purple-dark);color:white;transform:translateY(-1px); }
        .modern-table { width:100%;border-collapse:collapse; }
        .modern-table th { padding:1rem 1.5rem;font-size:0.75rem;font-weight:700;color:var(--primary-purple);text-transform:uppercase;letter-spacing:0.05em;background:#f8f7ff;border-bottom:1px solid #e8e0fc;text-align:left; }
        body.dark .modern-table th { background:rgba(255,255,255,0.03);color:#a78bfa;border-bottom-color:rgba(124,58,237,0.15); }
        .modern-table td { padding:1rem 1.5rem;border-bottom:1px solid #f1f0f7;color:#334155;vertical-align:middle; }
        body.dark .modern-table td { color:#cbd5e1;border-bottom-color:rgba(124,58,237,0.1); }
        .modern-table tbody tr { transition:background 0.15s; }
        .modern-table tbody tr:hover { background:#faf8ff; }
        body.dark .modern-table tbody tr:hover { background:rgba(124,58,237,0.06); }
        .badge-field-type { display:inline-block;padding:0.2rem 0.7rem;border-radius:30px;font-size:0.72rem;font-weight:700;background:var(--purple-soft);color:var(--purple-dark); }
        body.dark .badge-field-type { background:rgba(124,58,237,0.15);color:var(--purple-light); }
        .badge-required { background:#fee2e2;color:#991b1b; }
        body.dark .badge-required { background:rgba(220,38,38,0.15);color:#f87171; }
        .badge-optional { background:#f0fdf4;color:#166534; }
        body.dark .badge-optional { background:rgba(22,163,74,0.15);color:#4ade80; }
        .tbl-actions { display:flex;gap:0.4rem; }
        .tbl-btn { width:34px;height:34px;border-radius:10px;border:none;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s;text-decoration:none; }
        .tbl-btn svg { width:16px;height:16px; }
        .tbl-btn-edit { background:#fefce8;color:#ca8a04; }
        .tbl-btn-edit:hover { background:#ca8a04;color:white; }
        .tbl-btn-delete { background:#fef2f2;color:#dc2626; }
        .tbl-btn-delete:hover { background:#dc2626;color:white; }
        .sidebar-modern { display:flex;flex-direction:column;gap:1.5rem; }
        .info-card { background:#fff;border-radius:24px;border:1px solid #ede9fe;padding:1.8rem 1.5rem;box-shadow:0 20px 30px -12px rgba(124,58,237,0.1);animation:scaleIn 0.5s 0.1s both; }
        body.dark .info-card { background:#1e1b2e;border-color:rgba(124,58,237,0.2); }
        .info-card-title { display:flex;align-items:center;gap:0.6rem;font-weight:700;color:var(--purple-dark);margin-bottom:1.2rem; }
        body.dark .info-card-title { color:#a78bfa; }
        .info-list { list-style:none;padding:0;margin:0; }
        .info-list li { display:flex;align-items:center;gap:0.8rem;padding:0.6rem 0;font-size:0.9rem;color:#475569;border-bottom:1px dashed #f0eaff; }
        body.dark .info-list li { color:#a5b4cb;border-bottom-color:rgba(124,58,237,0.15); }
        .info-list li:last-child { border-bottom:none; }
        .info-list li svg { width:18px;height:18px;stroke:var(--primary-purple);flex-shrink:0; }
        .status-badge { display:inline-flex;align-items:center;gap:0.3rem;padding:0.25rem 0.75rem;border-radius:30px;font-size:0.72rem;font-weight:700; }
        .status-active   { background:#dcfce7;color:#166534; }
        .status-inactive { background:#fee2e2;color:#991b1b; }
        body.dark .status-active   { background:rgba(22,163,74,0.15);color:#4ade80; }
        body.dark .status-inactive { background:rgba(220,38,38,0.15);color:#f87171; }
        .empty-state { padding:3rem 1.5rem;text-align:center;color:#94a3b8; }
        .empty-icon  { width:60px;height:60px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem; }
        .back-link { display:inline-flex;align-items:center;gap:0.4rem;color:var(--primary-purple);font-weight:600;text-decoration:none;margin-bottom:1rem;transition:gap 0.2s; }
        .back-link:hover { gap:0.7rem; }
    </style>
@endsection

@section('content')
<div class="show-wrapper">
    <a href="{{ route('admin.categories.sub-categories.index', $category) }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        {{ __('admin.back_to_list') }}
    </a>

    <div class="page-header-modern">
        <div class="header-bg-pattern"></div>
        <div class="header-content">
            <div class="header-title-area">
                <div class="header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/>
                        <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ $subCategory->getTranslation('name', app()->getLocale()) }}</h1>
                    <p>{{ __('admin.sub_category_details') }}</p>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            @can('sub_categories.edit')
            <a href="{{ route('admin.categories.sub-categories.edit', [$category, $subCategory]) }}" class="btn-action btn-action-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                {{ __('admin.edit') }}
            </a>
            @endcan
            <a href="{{ route('admin.categories.sub-categories.dynamic-fields.index', [$category, $subCategory]) }}" class="btn-action btn-action-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                {{ __('admin.dynamic_fields') }}
            </a>
            @can('sub_categories.delete')
            <button type="button" class="btn-action btn-action-danger" id="deleteBtn"
                    data-type-name="{{ $subCategory->getTranslation('name', app()->getLocale()) }}"
                    data-delete-url="{{ route('admin.categories.sub-categories.destroy', [$category, $subCategory]) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                {{ __('admin.delete') }}
            </button>
            @endcan
        </div>

        <div class="stats-grid">
            <div class="stat-card" style="animation-delay:0.1s">
                <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg></div>
                <div class="stat-content"><div class="stat-label">{{ __('admin.parent_category') }}</div><div class="stat-value" style="font-size:1.2rem;">{{ $category->getTranslation('name', app()->getLocale()) }}</div></div>
            </div>
            <div class="stat-card" style="animation-delay:0.15s">
                <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                <div class="stat-content"><div class="stat-label">{{ __('admin.dynamic_fields') }}</div><div class="stat-value">{{ $subCategory->dynamicFields->count() }}</div></div>
            </div>
            <div class="stat-card" style="animation-delay:0.2s">
                <div class="stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                <div class="stat-content"><div class="stat-label">{{ __('admin.created_at') }}</div><div class="stat-value" style="font-size:1rem;">{{ $subCategory->created_at->format('Y-m-d') }}</div></div>
            </div>
        </div>
    </div>

    <div class="modern-grid">
        <div class="section-card">
            <div class="section-header">
                <div class="section-header-left">
                    <div class="section-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                    <h3 class="section-title">{{ __('admin.dynamic_fields') }}</h3>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="section-count">{{ $subCategory->dynamicFields->count() }}</span>
                    @can('dynamic_fields.create')
                    <a href="{{ route('admin.categories.sub-categories.dynamic-fields.create', [$category, $subCategory]) }}" class="btn-add-section">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        {{ __('admin.add') }}
                    </a>
                    @endcan
                </div>
            </div>
            @if($subCategory->dynamicFields->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                    <p>{{ __('admin.no_dynamic_fields') }}</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                             <tr>
                                <th>{{ __('admin.name_ar') }}</th>
                                <th>{{ __('admin.name_en') }}</th>
                                <th>{{ __('admin.field_type') }}</th>
                                <th>{{ __('admin.required') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                             </tr>
                        </thead>
                        <tbody>
                            @foreach($subCategory->dynamicFields as $field)
                             <tr>
                                <td dir="rtl">{{ $field->getTranslation('name','ar') }}</td>
                                <td>{{ $field->getTranslation('name','en') }}</td>
                                <td><span class="badge-field-type">{{ $field->type }}</span></td>
                                <td><span class="badge-field-type {{ $field->is_required ? 'badge-required' : 'badge-optional' }}">{{ $field->is_required ? __('admin.required') : __('admin.optional') }}</span></td>
                                <td>
                                    <div class="tbl-actions">
                                        @can('dynamic_fields.edit')
                                        <a href="{{ route('admin.categories.sub-categories.dynamic-fields.edit', [$category, $subCategory, $field]) }}" class="tbl-btn tbl-btn-edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        @endcan
                                        @can('dynamic_fields.delete')
                                        <button class="tbl-btn tbl-btn-delete tbl-delete-btn"
                                            data-name="{{ $field->getTranslation('name', app()->getLocale()) }}"
                                            data-url="{{ route('admin.categories.sub-categories.dynamic-fields.destroy', [$category, $subCategory, $field]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                             </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="sidebar-modern">
            <div class="info-card">
                <div class="info-card-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <span>{{ __('admin.sub_category_info') }}</span>
                </div>
                <ul class="info-list">
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <strong>AR:</strong> <span dir="rtl">{{ $subCategory->getTranslation('name','ar') }}</span></li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <strong>EN:</strong> {{ $subCategory->getTranslation('name','en') }}</li>

                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <strong>{{ __('admin.created_at') }}:</strong> {{ $subCategory->created_at->format('Y-m-d') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">@csrf @method('DELETE')</form>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script>
const deleteForm = document.getElementById('deleteForm');
document.querySelectorAll('.tbl-delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        Swal.fire({
            title: '{{ __('admin.confirm_delete') }}',
            text: '{{ __('admin.delete_confirm_msg') }}: ' + this.dataset.name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#7c3aed',
            confirmButtonText: '{{ __('admin.delete') }}',
            cancelButtonText: '{{ __('admin.cancel') }}',
            reverseButtons: true,
            background: document.body.classList.contains('dark') ? '#1e1b2e' : '#fff',
            color: document.body.classList.contains('dark') ? '#e2e8f0' : '#1e293b',
        }).then(r => { if (r.isConfirmed) { deleteForm.action = this.dataset.url; deleteForm.submit(); } });
    });
});

document.getElementById('deleteBtn')?.addEventListener('click', function() {
    Swal.fire({
        title: '{{ __('admin.confirm_delete') }}',
        text: '{{ __('admin.delete_confirm_msg') }}: ' + this.dataset.typeName,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#7c3aed',
        confirmButtonText: '{{ __('admin.delete') }}',
        cancelButtonText: '{{ __('admin.cancel') }}',
        reverseButtons: true,
        background: document.body.classList.contains('dark') ? '#1e1b2e' : '#fff',
        color: document.body.classList.contains('dark') ? '#e2e8f0' : '#1e293b',
    }).then(r => { if (r.isConfirmed) { deleteForm.action = this.dataset.deleteUrl; deleteForm.submit(); } });
});

document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
    Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:3500, timerProgressBar:true,
        didOpen: t => { t.addEventListener('mouseenter', Swal.stopTimer); t.addEventListener('mouseleave', Swal.resumeTimer); }
    }).fire({ icon:'success', title:'{{ session('success') }}' });
    @endif
});
</script>
@endsection
