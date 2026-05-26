{{-- resources/views/admin/sliders/edit.blade.php --}}
@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/src/sweetalerts2/sweetalerts2.css')}}">
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
    <style>
        /* Same styles as create.blade.php plus change indicator */
        :root {
            --primary-purple: #7c3aed;
            --purple-light: #a78bfa;
            --purple-dark: #5b21b6;
            --purple-soft: #ede9fe;
            --purple-glow: rgba(124,58,237,0.22);
            --transition: 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        @keyframes changePop { 0% { transform: scale(1); } 40% { transform: scale(1.35); } 100% { transform: scale(1); } }

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
            background-image: radial-gradient(circle at 30% 40%, rgba(255,255,255,0.08) 0%, transparent 30%), radial-gradient(circle at 80% 70%, rgba(255,255,255,0.05) 0%, transparent 40%), repeating-linear-gradient(45deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 2px, transparent 2px, transparent 8px);
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
        .modern-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.8rem;
        }
        @media (max-width: 992px) { .modern-grid { grid-template-columns: 1fr; } }
        .form-card {
            background: #fff;
            border-radius: 28px;
            border: 1px solid #ede9fe;
            box-shadow: 0 20px 40px -12px rgba(124,58,237,0.12);
            overflow: hidden;
            animation: scaleIn 0.5s 0.1s both;
        }
        body.dark .form-card { background: #1e1b2e; border-color: rgba(124,58,237,0.2); }
        .form-card-header {
            padding: 1.5rem 2rem;
            background: linear-gradient(to right, #faf5ff, #ffffff);
            border-bottom: 1px solid #ede9fe;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        body.dark .form-card-header { background: rgba(255,255,255,0.03); border-bottom-color: rgba(124,58,237,0.15); }
        .form-card-header-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary-purple), var(--purple-dark));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .form-card-header h3 { font-weight: 700; font-size: 1.2rem; color: #1e293b; margin: 0; }
        body.dark .form-card-header h3 { color: #e2e8f0; }
        .form-card-body { padding: 1.5rem; }
        .input-group-modern { margin-bottom: 1.5rem; }
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
        .form-control-modern {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 2px solid #e0d4fd;
            border-radius: 16px;
            font-size: 0.95rem;
            background: #fdfcff;
            transition: all var(--transition);
            outline: none;
        }
        body.dark .form-control-modern { background: #13111f; border-color: rgba(124,58,237,0.3); color: #e2e8f0; }
        .form-control-modern:focus { border-color: var(--primary-purple); box-shadow: 0 0 0 4px var(--purple-glow); }
        .change-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #f59e0b;
            box-shadow: 0 0 6px rgba(245,158,11,0.6);
            display: inline-block;
            margin-left: 0.5rem;
            animation: changePop 0.3s ease;
        }
        .is-changed { border-color: #f59e0b !important; box-shadow: 0 0 0 3px rgba(245,158,11,0.14) !important; }
        .form-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 1px dashed #ede9fe;
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
            cursor: pointer;
            transition: all var(--transition);
            box-shadow: 0 10px 20px -8px var(--primary-purple);
        }
        .btn-primary-modern:hover { transform: translateY(-2px); box-shadow: 0 18px 30px -8px var(--primary-purple); }
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
            text-decoration: none;
            transition: all var(--transition);
        }
        .btn-secondary-modern:hover { border-color: var(--primary-purple); color: var(--primary-purple); transform: translateY(-2px); }
        .sidebar-modern { display: flex; flex-direction: column; gap: 1.5rem; }
        .live-preview-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #ede9fe;
            padding: 1.5rem;
            box-shadow: 0 20px 30px -12px rgba(124,58,237,0.1);
            animation: scaleIn 0.5s 0.2s both;
        }
        body.dark .live-preview-card { background: #1e1b2e; border-color: rgba(124,58,237,0.2); }
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
        .preview-image {
            width: 100%;
            height: 140px;
            background: linear-gradient(135deg, #a78bfa, #7c3aed);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 1rem;
            background-size: cover;
            background-position: center;
        }
        .preview-item {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            padding: 0.6rem 0;
            border-bottom: 1px dashed #f0eaff;
        }
        .preview-item:last-child { border-bottom: none; }
        .preview-item-label {
            font-size: 0.7rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            min-width: 60px;
        }
        .preview-item-value {
            font-weight: 600;
            color: #1e293b;
            word-break: break-word;
            flex: 1;
        }
        body.dark .preview-item-value { color: #e2e8f0; }
        .info-card {
            background: linear-gradient(145deg, #ede9fe, #ffffff);
            border-radius: 24px;
            padding: 1.2rem;
            border: 1px solid #ddd6fe;
        }
        body.dark .info-card { background: #1a1729; border-color: rgba(124,58,237,0.25); }
        .info-card-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: var(--purple-dark);
            margin-bottom: 0.8rem;
        }
        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .info-list li {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.4rem 0;
            font-size: 0.85rem;
            color: #475569;
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
        .back-link:hover { gap: 0.7rem; }
        .current-image {
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .current-image-thumb {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background-size: cover;
            background-position: center;
            border: 1px solid #e0d4fd;
        }
    </style>
@endsection

@section('content')
<div class="edit-slider-wrapper">
    <a href="{{ route('admin.sliders.index') }}" class="back-link">
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
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="M8 12h8"/>
                    </svg>
                </div>
                <div class="header-text">
                    <h1>{{ __('admin.edit_slider') }}</h1>
                    <p>{{ $slider->getTranslation('title', app()->getLocale(), false) ?: __('admin.editing') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modern-grid">
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <h3>{{ __('admin.slider_details') }}</h3>
            </div>
            <div class="form-card-body">
                <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" id="editSliderForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="input-group-modern">
                        <label class="input-label" for="title_ar">
                            {{ __('admin.title_ar') }}
                            <span id="changeArIndicator" class="change-indicator" style="display: none;"></span>
                        </label>
                        <input type="text" name="title_ar" id="title_ar" class="form-control-modern @error('title_ar') is-invalid @enderror" value="{{ old('title_ar', $slider->getTranslation('title', 'ar')) }}" data-original="{{ $slider->getTranslation('title', 'ar') }}" dir="rtl">
                        @error('title_ar') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="input-group-modern">
                        <label class="input-label" for="title_en">
                            {{ __('admin.title_en') }}
                            <span id="changeEnIndicator" class="change-indicator" style="display: none;"></span>
                        </label>
                        <input type="text" name="title_en" id="title_en" class="form-control-modern @error('title_en') is-invalid @enderror" value="{{ old('title_en', $slider->getTranslation('title', 'en')) }}" data-original="{{ $slider->getTranslation('title', 'en') }}" dir="ltr">
                        @error('title_en') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="input-group-modern">
                        <label class="input-label" for="link">{{ __('admin.link') }}</label>
                        <input type="url" name="link" id="link" class="form-control-modern @error('link') is-invalid @enderror" value="{{ old('link', $slider->link) }}" placeholder="https://example.com">
                        @error('link') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="input-label" for="starts_at">{{ __('admin.starts_at') }}</label>
                                <input type="datetime-local" name="starts_at" id="starts_at" class="form-control-modern" value="{{ old('starts_at', $slider->starts_at?->format('Y-m-d\TH:i')) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="input-label" for="ends_at">{{ __('admin.ends_at') }}</label>
                                <input type="datetime-local" name="ends_at" id="ends_at" class="form-control-modern" value="{{ old('ends_at', $slider->ends_at?->format('Y-m-d\TH:i')) }}">
                            </div>
                        </div>
                    </div>

                    <div class="input-group-modern">
                        <label class="input-label" for="image">{{ __('admin.image') }} ({{ __('admin.leave_empty_to_keep') }})</label>
                        <input type="file" name="image" id="image" class="form-control-modern" accept="image/*">
                        @if($slider->getFirstMedia('image'))
                            <div class="current-image">
                                <div class="current-image-thumb" style="background-image: url('{{ asset('storage/' . $slider->getFirstMedia('image')->getPathRelativeToRoot()) }}'); background-size: cover;"></div>
                                <span class="text-muted small">{{ __('admin.current_image') }}</span>
                            </div>
                        @endif
                        @error('image') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary-modern">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                <polyline points="17 21 17 13 7 13 7 21"/>
                            </svg>
                            {{ __('admin.update') }}
                        </button>
                        <a href="{{ route('admin.sliders.index') }}" class="btn-secondary-modern">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            {{ __('admin.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="sidebar-modern">
            <div class="live-preview-card">
                <div class="preview-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <h4>{{ __('admin.live_preview') }}</h4>
                </div>
                <div class="preview-image" id="previewImage">
                    @if($slider->getFirstMedia('image'))
                        <div style="width:100%;height:100%;background-size:cover;background-position:center;background-image:url('{{ asset('storage/' . $slider->getFirstMedia('image')->getPathRelativeToRoot()) }}');"></div>
                    @else
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="M8 12h8"/>
                        </svg>
                    @endif
                </div>
                <div class="preview-item">
                    <div class="preview-item-label">{{ __('admin.title_ar') }}</div>
                    <div class="preview-item-value" id="previewTitleAr">{{ $slider->getTranslation('title', 'ar') ?: '—' }}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-item-label">{{ __('admin.title_en') }}</div>
                    <div class="preview-item-value" id="previewTitleEn">{{ $slider->getTranslation('title', 'en') ?: '—' }}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-item-label">{{ __('admin.link') }}</div>
                    <div class="preview-item-value" id="previewLink">{{ $slider->link ?: '—' }}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-item-label">{{ __('admin.period') }}</div>
                    <div class="preview-item-value" id="previewPeriod">
                        @if($slider->starts_at || $slider->ends_at)
                            {{ $slider->starts_at?->format('Y-m-d') ?: '...' }} {{ $slider->ends_at ? '→ ' . $slider->ends_at->format('Y-m-d') : '' }}
                        @else —
                        @endif
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="info-card-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>{{ __('admin.slider_info') }}</span>
                </div>
                <ul class="info-list">
                    <li><strong>{{ __('admin.created_at') }}:</strong> {{ $slider->created_at->format('Y-m-d H:i') }}</li>
                    <li><strong>{{ __('admin.updated_at') }}:</strong> {{ $slider->updated_at->diffForHumans() }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset('plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
<script>
    const arInput = document.getElementById('title_ar');
    const enInput = document.getElementById('title_en');
    const linkInput = document.getElementById('link');
    const startsAt = document.getElementById('starts_at');
    const endsAt = document.getElementById('ends_at');
    const imageInput = document.getElementById('image');
    const previewTitleAr = document.getElementById('previewTitleAr');
    const previewTitleEn = document.getElementById('previewTitleEn');
    const previewLink = document.getElementById('previewLink');
    const previewPeriod = document.getElementById('previewPeriod');
    const previewImageDiv = document.getElementById('previewImage');
    const changeArIndicator = document.getElementById('changeArIndicator');
    const changeEnIndicator = document.getElementById('changeEnIndicator');
    const originalAr = arInput?.dataset.original || '';
    const originalEn = enInput?.dataset.original || '';

    function updatePreview() {
        if (previewTitleAr) previewTitleAr.textContent = arInput.value.trim() || '—';
        if (previewTitleEn) previewTitleEn.textContent = enInput.value.trim() || '—';
        if (previewLink) previewLink.textContent = linkInput.value.trim() || '—';
        let start = startsAt.value ? new Date(startsAt.value).toLocaleDateString() : null;
        let end = endsAt.value ? new Date(endsAt.value).toLocaleDateString() : null;
        if (previewPeriod) {
            if (start || end) previewPeriod.textContent = (start || '...') + (end ? ' → ' + end : '');
            else previewPeriod.textContent = '—';
        }
        if (arInput && changeArIndicator) {
            let arChanged = arInput.value.trim() !== originalAr;
            arInput.classList.toggle('is-changed', arChanged);
            changeArIndicator.style.display = arChanged ? 'inline-block' : 'none';
        }
        if (enInput && changeEnIndicator) {
            let enChanged = enInput.value.trim() !== originalEn;
            enInput.classList.toggle('is-changed', enChanged);
            changeEnIndicator.style.display = enChanged ? 'inline-block' : 'none';
        }
    }

    function updateImagePreview() {
        if (imageInput.files && imageInput.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                previewImageDiv.innerHTML = `<div style="width:100%;height:100%;background-size:cover;background-position:center;background-image:url('${e.target.result}');"></div>`;
            };
            reader.readAsDataURL(imageInput.files[0]);
        }
    }

    arInput?.addEventListener('input', updatePreview);
    enInput?.addEventListener('input', updatePreview);
    linkInput?.addEventListener('input', updatePreview);
    startsAt?.addEventListener('change', updatePreview);
    endsAt?.addEventListener('change', updatePreview);
    imageInput?.addEventListener('change', updateImagePreview);
    updatePreview();

    document.getElementById('editSliderForm')?.addEventListener('submit', function() {
        let btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __('admin.updating') }}';
    });

    @if(session('success'))
    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3500 }).fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif
</script>
@endsection
