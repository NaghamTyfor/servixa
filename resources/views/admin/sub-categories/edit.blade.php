{{-- resources/views/admin/sub-categories/edit.blade.php --}}
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/src/sweetalerts2/sweetalerts2.css')}}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
    <style>
        /* نفس CSS الموجود في create */
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
        @keyframes shimmer { 0%{background-position:-200% center} 100%{background-position:200% center} }
        @keyframes changePop { 0%{transform:scale(1)} 40%{transform:scale(1.35)} 100%{transform:scale(1)} }

        .edit-wrapper { animation:fadeIn 0.5s ease; }
        .page-header-modern { position:relative;background:linear-gradient(135deg,#2e1065 0%,#5b21b6 40%,#7c3aed 80%,#a78bfa 100%);border-radius:32px;padding:2rem 2.5rem;margin-bottom:2.5rem;overflow:hidden;box-shadow:0 20px 40px -15px rgba(124,58,237,0.3);animation:slideUp 0.6s cubic-bezier(0.22,1,0.36,1); }
        .header-bg-pattern { position:absolute;top:0;right:0;bottom:0;left:0;pointer-events:none;background-image:radial-gradient(circle at 30% 40%,rgba(255,255,255,0.08) 0%,transparent 30%),radial-gradient(circle at 80% 70%,rgba(255,255,255,0.05) 0%,transparent 40%),repeating-linear-gradient(45deg,rgba(255,255,255,0.02) 0px,rgba(255,255,255,0.02) 2px,transparent 2px,transparent 8px); }
        .header-content { position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem; }
        .header-title-area { display:flex;align-items:center;gap:1.2rem; }
        .header-icon { width:64px;height:64px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border-radius:18px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,0.25);box-shadow:0 8px 20px rgba(0,0,0,0.15); }
        .header-icon svg { width:32px;height:32px;stroke:white;stroke-width:1.8; }
        .header-text h1 { font-size:2.2rem;font-weight:800;color:white;margin:0;letter-spacing:-0.02em;line-height:1.2;text-shadow:0 2px 10px rgba(0,0,0,0.2); }
        .header-text p  { color:rgba(255,255,255,0.7);margin:0.3rem 0 0;font-size:0.95rem; }
        .modern-grid { display:grid;grid-template-columns:1fr 340px;gap:1.8rem; }
        @media(max-width:992px) { .modern-grid { grid-template-columns:1fr; } }
        .form-card { background:#fff;border-radius:28px;border:1px solid #ede9fe;box-shadow:0 20px 40px -12px rgba(124,58,237,0.12);overflow:hidden;animation:scaleIn 0.5s 0.1s both;height:fit-content; }
        body.dark .form-card { background:#1e1b2e;border-color:rgba(124,58,237,0.2); }
        .form-card-header { padding:1.5rem 2rem;background:linear-gradient(to right,#faf5ff,#ffffff);border-bottom:1px solid #ede9fe;display:flex;align-items:center;gap:1rem; }
        body.dark .form-card-header { background:rgba(255,255,255,0.03);border-bottom-color:rgba(124,58,237,0.15); }
        .form-card-header-icon { width:42px;height:42px;background:linear-gradient(135deg,var(--primary-purple),var(--purple-dark));border-radius:14px;display:flex;align-items:center;justify-content:center;color:white; }
        .form-card-header h3 { font-weight:700;font-size:1.2rem;color:#1e293b;margin:0; }
        body.dark .form-card-header h3 { color:#e2e8f0; }
        .form-card-body { padding:1.5rem 2rem; }
        .input-group-modern { margin-bottom:1.5rem; }
        .input-label { display:flex;align-items:center;gap:0.5rem;font-size:0.85rem;font-weight:600;color:var(--purple-dark);margin-bottom:0.5rem;text-transform:uppercase;letter-spacing:0.03em; }
        body.dark .input-label { color:#c4b5fd; }
        .input-label svg { width:16px;height:16px;stroke:var(--primary-purple); }
        .input-wrapper { position:relative;display:flex;align-items:center; }
        .flag-icon { position:absolute;left:1rem;font-size:1.2rem;pointer-events:none;z-index:2; }
        .form-control-modern { width:100%;padding:0.85rem 1rem 0.85rem 3rem;border:2px solid #e0d4fd;border-radius:16px;font-size:0.95rem;background:#fdfcff;transition:all var(--transition);outline:none;color:#1e293b; }
        body.dark .form-control-modern { background:#13111f;border-color:rgba(124,58,237,0.3);color:#e2e8f0; }
        .form-control-modern:focus { border-color:var(--primary-purple);box-shadow:0 0 0 4px var(--purple-glow);background:white; }
        .is-changed { border-color:#f59e0b!important;box-shadow:0 0 0 3px rgba(245,158,11,0.14)!important; }
        .change-indicator { width:8px;height:8px;border-radius:50%;background:#f59e0b;box-shadow:0 0 6px rgba(245,158,11,0.6);display:inline-block;margin-left:0.5rem;animation:changePop 0.3s ease; }
        .toggle-group { display:flex;align-items:center;justify-content:space-between;background:#fafafe;border:2px solid #e0d4fd;border-radius:16px;padding:0.85rem 1.2rem; }
        body.dark .toggle-group { background:#13111f;border-color:rgba(124,58,237,0.3); }
        .toggle-label { font-weight:600;color:#1e293b;font-size:0.95rem; }
        body.dark .toggle-label { color:#e2e8f0; }
        .toggle-sub { font-size:0.8rem;color:#94a3b8; }
        .toggle-switch { position:relative;width:52px;height:28px; }
        .toggle-switch input { opacity:0;width:0;height:0; }
        .toggle-slider { position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:#e2e8f0;border-radius:30px;transition:0.3s; }
        .toggle-slider:before { position:absolute;content:"";height:20px;width:20px;left:4px;bottom:4px;background:white;border-radius:50%;transition:0.3s;box-shadow:0 2px 6px rgba(0,0,0,0.15); }
        input:checked + .toggle-slider { background:var(--primary-purple); }
        input:checked + .toggle-slider:before { transform:translateX(24px); }
        .sort-wrapper { position:relative; }
        .sort-icon { position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#a78bfa;pointer-events:none;z-index:2; }
        .validation-hint { font-size:0.75rem;color:#94a3b8;margin-top:0.3rem;display:flex;align-items:center;gap:0.3rem; }
        .form-actions { display:flex;align-items:center;gap:1rem;margin-top:1rem;padding-top:0.75rem;border-top:1px dashed #ede9fe; }
        .btn-primary-modern { display:inline-flex;align-items:center;gap:0.7rem;padding:0.9rem 2.2rem;background:linear-gradient(135deg,var(--primary-purple),var(--purple-dark));border:none;border-radius:50px;color:white;font-weight:700;font-size:0.95rem;cursor:pointer;transition:all var(--transition);box-shadow:0 10px 20px -8px var(--primary-purple);position:relative;overflow:hidden; }
        .btn-primary-modern::after { content:'';position:absolute;inset:0;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.2),transparent);background-size:200% auto;animation:shimmer 3s linear infinite;pointer-events:none; }
        .btn-primary-modern:hover { transform:translateY(-2px);box-shadow:0 18px 30px -8px var(--primary-purple); }
        .btn-secondary-modern { display:inline-flex;align-items:center;gap:0.7rem;padding:0.9rem 2rem;background:transparent;border:2px solid #e2e8f0;border-radius:50px;color:#64748b;font-weight:600;font-size:0.95rem;cursor:pointer;transition:all var(--transition);text-decoration:none; }
        body.dark .btn-secondary-modern { border-color:#334155;color:#94a3b8; }
        .btn-secondary-modern:hover { border-color:var(--primary-purple);color:var(--primary-purple);transform:translateY(-2px); }
        .sidebar-modern { display:flex;flex-direction:column;gap:1.5rem; }
        .live-preview-card { background:#fff;border-radius:24px;border:1px solid #ede9fe;padding:1.8rem 1.5rem;box-shadow:0 20px 30px -12px rgba(124,58,237,0.1);animation:scaleIn 0.5s 0.2s both; }
        body.dark .live-preview-card { background:#1e1b2e;border-color:rgba(124,58,237,0.2); }
        .preview-header { display:flex;align-items:center;gap:0.8rem;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid #f0eaff; }
        .preview-header svg { width:22px;height:22px;stroke:var(--primary-purple); }
        .preview-header h4 { font-weight:700;font-size:1rem;color:#334155;margin:0; }
        body.dark .preview-header h4 { color:#cbd5e1; }
        .preview-type-icon { width:70px;height:70px;border-radius:20px;background:linear-gradient(135deg,#a78bfa,#7c3aed);margin:0 auto 1.2rem;display:flex;align-items:center;justify-content:center;color:white;font-size:2rem;font-weight:700;box-shadow:0 15px 25px -8px #7c3aed; }
        .preview-item { display:flex;align-items:center;gap:0.8rem;padding:0.8rem 0;border-bottom:1px dashed #f0eaff; }
        .preview-item:last-child { border-bottom:none; }
        .preview-item-icon { width:32px;height:32px;background:#ede9fe;border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--primary-purple); }
        body.dark .preview-item-icon { background:rgba(124,58,237,0.15); }
        .preview-item-content { flex:1; }
        .preview-item-label { font-size:0.7rem;color:#94a3b8;text-transform:uppercase;letter-spacing:0.05em; }
        .preview-item-value { font-weight:700;color:#1e293b;word-break:break-word; }
        body.dark .preview-item-value { color:#e2e8f0; }
        .info-card { background:linear-gradient(145deg,#ede9fe,#ffffff);border-radius:24px;padding:1.2rem;border:1px solid #ddd6fe;animation:scaleIn 0.5s 0.3s both; }
        body.dark .info-card { background:#1a1729;border-color:rgba(124,58,237,0.25); }
        .info-card-title { display:flex;align-items:center;gap:0.5rem;font-weight:700;color:var(--purple-dark);margin-bottom:0.8rem; }
        .info-list { list-style:none;padding:0;margin:0; }
        .info-list li { display:flex;align-items:center;gap:0.6rem;padding:0.4rem 0;font-size:0.85rem;color:#475569; }
        body.dark .info-list li { color:#a5b4cb; }
        .info-list li svg { width:14px;height:14px;stroke:var(--primary-purple); }
        .quick-back { display:inline-flex;align-items:center;gap:0.5rem;color:var(--primary-purple);font-weight:600;text-decoration:none;padding:0.5rem 0;transition:gap 0.2s; }
        .quick-back:hover { gap:0.8rem;color:var(--purple-dark); }
        .back-link { display:inline-flex;align-items:center;gap:0.4rem;color:var(--primary-purple);font-weight:600;text-decoration:none;margin-bottom:1rem;transition:gap 0.2s; }
        .back-link:hover { gap:0.7rem; }
    </style>
@endsection

@section('content')
<div class="edit-wrapper">
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
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.edit_sub_category') }}</h1>
                    <p>{{ $subCategory->getTranslation('name', app()->getLocale()) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modern-grid">
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <h3>{{ __('admin.sub_category_details') }}</h3>
            </div>
            <div class="form-card-body">
                <form action="{{ route('admin.categories.sub-categories.update', [$category, $subCategory]) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="input-group-modern">
                        <label class="input-label" for="name_ar">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            {{ __('admin.name_ar') }}
                            <span id="changeArIndicator" class="change-indicator" style="display:none;"></span>
                        </label>
                        <div class="input-wrapper">
                            <span class="flag-icon">🇸🇦</span>
                            <input type="text" name="name_ar" id="name_ar"
                                   class="form-control-modern @error('name_ar') is-invalid @enderror"
                                   value="{{ old('name_ar', $subCategory->getTranslation('name', 'ar')) }}"
                                   data-original="{{ $subCategory->getTranslation('name', 'ar') }}"
                                   placeholder="{{ __('admin.placeholder_ar') }}" required dir="rtl" autocomplete="off">
                        </div>
                        @error('name_ar')
                            <div class="validation-hint" style="color:#ef4444;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group-modern">
                        <label class="input-label" for="name_en">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            {{ __('admin.name_en') }}
                            <span id="changeEnIndicator" class="change-indicator" style="display:none;"></span>
                        </label>
                        <div class="input-wrapper">
                            <span class="flag-icon">🇬🇧</span>
                            <input type="text" name="name_en" id="name_en"
                                   class="form-control-modern @error('name_en') is-invalid @enderror"
                                   value="{{ old('name_en', $subCategory->getTranslation('name', 'en')) }}"
                                   data-original="{{ $subCategory->getTranslation('name', 'en') }}"
                                   placeholder="{{ __('admin.placeholder_en') }}" required dir="ltr" autocomplete="off">
                        </div>
                        @error('name_en')
                            <div class="validation-hint" style="color:#ef4444;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</div>
                        @enderror
                    </div>




                    <div class="form-actions">
                        <button type="submit" class="btn-primary-modern" id="updateBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            {{ __('admin.update') }}
                        </button>
                        <a href="{{ route('admin.categories.sub-categories.index', $category) }}" class="btn-secondary-modern">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            {{ __('admin.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="sidebar-modern">
            <div class="live-preview-card">
                <div class="preview-header"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg><h4>{{ __('admin.live_preview') }}</h4></div>
                <div class="preview-type-icon"><span id="previewIconLetter">{{ strtoupper(substr($subCategory->getTranslation('name','en'),0,1)) ?: '📁' }}</span></div>
                <div class="preview-item"><div class="preview-item-icon"><span style="font-size:1.2rem;">🇸🇦</span></div><div class="preview-item-content"><div class="preview-item-label">{{ __('admin.name_ar') }}</div><div class="preview-item-value" id="previewAr">{{ $subCategory->getTranslation('name','ar') }}</div></div></div>
                <div class="preview-item"><div class="preview-item-icon"><span style="font-size:1.2rem;">🇬🇧</span></div><div class="preview-item-content"><div class="preview-item-label">{{ __('admin.name_en') }}</div><div class="preview-item-value" id="previewEn">{{ $subCategory->getTranslation('name','en') }}</div></div></div>
            </div>
            <div class="info-card">
                <div class="info-card-title"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg><span>{{ __('admin.sub_category_info') }}</span></div>
                <ul class="info-list">
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
                        <strong>{{ __('admin.category') }}:</strong> {{ $category->getTranslation('name', app()->getLocale()) }}</li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <strong>{{ __('admin.created_at') }}:</strong> {{ $subCategory->created_at->format('Y-m-d') }}</li>
                    <li><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <strong>{{ __('admin.updated_at') }}:</strong> {{ $subCategory->updated_at->diffForHumans() }}</li>
                </ul>
                <div style="margin-top:1.5rem;">
                    <a href="{{ route('admin.categories.sub-categories.show', [$category, $subCategory]) }}" class="quick-back">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        {{ __('admin.view_details') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script>
const arInput = document.getElementById('name_ar');
const enInput = document.getElementById('name_en');
const previewAr = document.getElementById('previewAr');
const previewEn = document.getElementById('previewEn');
const previewIcon = document.getElementById('previewIconLetter');
const originalAr = arInput.dataset.original;
const originalEn = enInput.dataset.original;

function updatePreview() {
    const ar = arInput.value.trim(), en = enInput.value.trim();
    previewAr.textContent = ar || '—';
    previewEn.textContent = en || '—';
    previewIcon.textContent = en ? en.charAt(0).toUpperCase() : ar ? ar.charAt(0) : '📁';
    arInput.classList.toggle('is-changed', ar !== originalAr);
    enInput.classList.toggle('is-changed', en !== originalEn);
    document.getElementById('changeArIndicator').style.display = ar !== originalAr ? 'inline-block' : 'none';
    document.getElementById('changeEnIndicator').style.display = en !== originalEn ? 'inline-block' : 'none';
}
arInput.addEventListener('input', updatePreview);
enInput.addEventListener('input', updatePreview);
enInput.addEventListener('input', function() { if (this.value.length === 1) this.value = this.value.toUpperCase(); });

document.getElementById('editForm')?.addEventListener('submit', function() {
    const btn = document.getElementById('updateBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>{{ __('admin.updating') }}';
});

@if(session('success'))
document.addEventListener('DOMContentLoaded', function() {
    Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:3500, timerProgressBar:true,
        didOpen: t => { t.addEventListener('mouseenter', Swal.stopTimer); t.addEventListener('mouseleave', Swal.resumeTimer); }
    }).fire({ icon:'success', title:'{{ session('success') }}' });
});
@endif
@if($errors->any())
document.addEventListener('DOMContentLoaded', function() {
    let msgs = '<ul style="text-align:right;margin:0;padding-right:1rem;">';
    @foreach($errors->all() as $error) msgs += '<li>{{ $error }}</li>'; @endforeach
    msgs += '</ul>';
    Swal.mixin({ toast:true, position:'top-end', showConfirmButton:false, timer:6000, timerProgressBar:true }).fire({ icon:'error', title:'{{ __('admin.validation_error') }}', html:msgs });
});
@endif
</script>
@endsection
