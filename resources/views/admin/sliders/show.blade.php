{{-- resources/views/admin/sliders/show.blade.php --}}
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
            --transition: 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

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
            background-image: radial-gradient(circle at 30% 40%, rgba(255,255,255,0.08) 0%, transparent 30%),
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
        .header-icon svg { width: 32px; height: 32px; stroke: white; stroke-width: 1.8; }
        .header-text h1 { font-size: 2.2rem; font-weight: 800; color: white; margin: 0; letter-spacing: -0.02em; }
        .header-text p { color: rgba(255,255,255,0.7); margin: 0.3rem 0 0; font-size: 0.95rem; }

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
        .btn-action-primary:hover { background: rgba(255,255,255,0.25); transform: translateY(-2px); color: white; }
        .btn-action-danger {
            background: rgba(244,63,94,0.15);
            border: 1px solid rgba(244,63,94,0.3);
            color: #fda4af;
        }
        .btn-action-danger:hover { background: #f43f5e; color: white; transform: translateY(-2px); }
.btn-action-toggle {
    background: rgba(34, 197, 94, 0.15);  /* أخضر فاتح */
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #22c55e;
}
.btn-action-toggle.toggle-off {
    background: rgba(239, 68, 68, 0.15);  /* أحمر فاتح */
    border-color: rgba(239, 68, 68, 0.3);
    color: #ef4444;
}
.btn-action-toggle:hover {
    transform: translateY(-2px);
}
.btn-action-toggle.toggle-off:hover {
    background: #ef4444;
    color: white;
}
.btn-action-toggle:hover:not(.toggle-off) {
    background: #22c55e;
    color: white;
}
        .btn-action-toggle:hover { transform: translateY(-2px); }

        .modern-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.8rem;
            margin-top: 2rem;
        }
        @media (max-width: 992px) { .modern-grid { grid-template-columns: 1fr; } }

        .section-card {
            background: #fff;
            border-radius: 28px;
            border: 1px solid #ede9fe;
            box-shadow: 0 20px 40px -12px rgba(124,58,237,0.12);
            overflow: hidden;
            animation: scaleIn 0.5s both;
            margin-bottom: 1.5rem;
        }
        body.dark .section-card { background: #1e1b2e; border-color: rgba(124,58,237,0.2); }
        .section-header {
            padding: 1.2rem 1.8rem;
            background: linear-gradient(to right, #faf5ff, #ffffff);
            border-bottom: 1px solid #ede9fe;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        body.dark .section-header { background: rgba(255,255,255,0.03); border-bottom-color: rgba(124,58,237,0.15); }
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
        .section-title { font-weight: 700; font-size: 1rem; color: #1e293b; margin: 0; }
        body.dark .section-title { color: #e2e8f0; }

        .info-row {
            display: flex;
            padding: 1rem 1.8rem;
            border-bottom: 1px solid #f5f3ff;
        }
        body.dark .info-row { border-bottom-color: rgba(124,58,237,0.1); }
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
        body.dark .info-value { color: #cbd5e1; }
        .slider-full-image {
            padding: 1.5rem;
            text-align: center;
        }
        .slider-full-image img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 20px;
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.2);
        }

        .sidebar-modern { display: flex; flex-direction: column; gap: 1.5rem; }
        .info-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #ede9fe;
            padding: 1.5rem;
            box-shadow: 0 20px 30px -12px rgba(124,58,237,0.1);
            animation: scaleIn 0.5s 0.1s both;
        }
        body.dark .info-card { background: #1e1b2e; border-color: rgba(124,58,237,0.2); }
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
        body.dark .info-list li { color: #a5b4cb; border-bottom-color: rgba(124,58,237,0.15); }
        .info-list li:last-child { border-bottom: none; }
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
        .badge-status {
            display: inline-block;
            padding: 0.25rem 0.8rem;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
    </style>
@endsection

@section('content')
<div class="show-slider-wrapper">
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
                    <h1>{{ $slider->getTranslation('title', app()->getLocale(), false) ?: __('admin.slider_details') }}</h1>
                    <p>{{ __('admin.slider_details') }}</p>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn-action btn-action-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                {{ __('admin.edit_slider') }}
            </a>

            {{-- زر التفعيل/التعطيل (Toggle) --}}
<button type="button" id="toggleActiveBtn"
    class="btn-action btn-action-toggle {{ $slider->is_active ? 'toggle-off' : '' }}"
                    data-slider-id="{{ $slider->id }}"
                    data-toggle-url="{{ route('admin.sliders.toggle-active', $slider) }}"
                    data-is-active="{{ $slider->is_active ? '1' : '0' }}"
                    data-starts-at="{{ $slider->starts_at }}"
                    data-ends-at="{{ $slider->ends_at }}">
                @if($slider->is_active)
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                    </svg>
                    {{ __('admin.deactivate') }}
                @else
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 8v4l3 3"/>
                    </svg>
                    {{ __('admin.activate') }}
                @endif
            </button>

            <button type="button" class="btn-action btn-action-danger" id="deleteBtn"
                    data-slider-title="{{ $slider->getTranslation('title', app()->getLocale(), false) ?: 'هذا السلايدر' }}"
                    data-delete-url="{{ route('admin.sliders.destroy', $slider) }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
                {{ __('admin.delete') }}
            </button>
        </div>
    </div>

    <div class="modern-grid">
        <div>
            <div class="section-card">
                <div class="section-header">
                    <div class="section-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                        </svg>
                    </div>
                    <h3 class="section-title">{{ __('admin.slider_information') }}</h3>
                </div>

                <div class="info-row">
                    <div class="info-label">{{ __('admin.title_ar') }}</div>
                    <div class="info-value">{{ $slider->getTranslation('title', 'ar') ?: '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">{{ __('admin.title_en') }}</div>
                    <div class="info-value">{{ $slider->getTranslation('title', 'en') ?: '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">{{ __('admin.link') }}</div>
                    <div class="info-value">
                        @if($slider->link)
                            <a href="{{ $slider->link }}" target="_blank" class="text-primary">{{ $slider->link }}</a>
                        @else
                            —
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">{{ __('admin.period') }}</div>
                    <div class="info-value">
                        @if($slider->starts_at || $slider->ends_at)
                            {{ $slider->starts_at?->format('Y-m-d H:i') ?: '...' }}
                            @if($slider->ends_at) → {{ $slider->ends_at->format('Y-m-d H:i') }} @endif
                        @else —
                        @endif
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">{{ __('admin.status') }}</div>
                    <div class="info-value">
                        @php
                            $isActiveLegacy = (!$slider->starts_at || $slider->starts_at <= now()) && (!$slider->ends_at || $slider->ends_at >= now());
                            $combinedActive = $slider->is_active && $isActiveLegacy;
                        @endphp
                        <span class="badge-status {{ $combinedActive ? 'badge-active' : 'badge-inactive' }}">
                            {{ $combinedActive ? __('admin.active') : __('admin.inactive') }}
                        </span>
                        @if(!$slider->is_active)
                            <span class="text-muted ms-2 small">({{ __('admin.manually_disabled') }})</span>
                        @elseif(!$isActiveLegacy)
                            <span class="text-muted ms-2 small">({{ __('admin.out_of_schedule') }})</span>
                        @endif
                    </div>
                </div>
                @if($slider->getFirstMedia('image'))
                <div class="slider-full-image">
                    <img src="{{ asset('storage/' . $slider->getFirstMedia('image')->getPathRelativeToRoot()) }}" alt="{{ $slider->getTranslation('title', app()->getLocale()) }}">
                </div>
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
                    <li><strong>{{ __('admin.created_at') }}:</strong> {{ $slider->created_at->format('Y-m-d H:i:s') }}</li>
                    <li><strong>{{ __('admin.updated_at') }}:</strong> {{ $slider->updated_at->format('Y-m-d H:i:s') }}</li>
                    <li><strong>{{ __('admin.last_update') }}:</strong> {{ $slider->updated_at->diffForHumans() }}</li>
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
    // Toggle Active via AJAX with SweetAlert error handling
    document.getElementById('toggleActiveBtn')?.addEventListener('click', function() {
        const btn = this;
        const isActiveNow = btn.dataset.isActive === '1';
        const startsAt = btn.dataset.startsAt;
        const endsAt = btn.dataset.endsAt;
        const toggleUrl = btn.dataset.toggleUrl;
        const sliderId = btn.dataset.sliderId;

        // إذا كنا نحاول التفعيل (أي حالياً غير فعال) نتحقق من صلاحية التواريخ
        if (!isActiveNow) {
            const now = new Date();
            let startValid = !startsAt || new Date(startsAt) <= now;
            let endValid = !endsAt || new Date(endsAt) >= now;
            if (!startValid || !endValid) {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('admin.cannot_activate') }}',
                    text: '{{ __('admin.cannot_activate_outside_schedule') }}',
                    confirmButtonColor: '#7c3aed'
                });
                return;
            }
        }

        const confirmMsg = isActiveNow ? '{{ __('admin.confirm_deactivate') }}' : '{{ __('admin.confirm_activate') }}';
        Swal.fire({
            title: confirmMsg,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#7c3aed',
            cancelButtonColor: '#64748b',
            confirmButtonText: '{{ __('admin.yes') }}',
            cancelButtonText: '{{ __('admin.cancel') }}'
        }).then(result => {
            if (!result.isConfirmed) return;

            // إظهار loading
            Swal.fire({
                title: '{{ __('admin.please_wait') }}',
                text: '{{ __('admin.updating_status') }}',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            fetch(toggleUrl, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: data.message || (isActiveNow ? '{{ __('admin.slider_deactivated') }}' : '{{ __('admin.slider_activated') }}'),
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || '{{ __('admin.something_wrong') }}');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: '{{ __('admin.error_occurred') }}',
                    text: error.message,
                    confirmButtonColor: '#7c3aed'
                });
            });
        });
    });

    // Delete button logic
    document.getElementById('deleteBtn')?.addEventListener('click', function() {
        let title = this.dataset.sliderTitle;
        Swal.fire({
            title: '{{ __('admin.confirm_delete') }}',
            text: '{{ __('admin.delete_confirm_msg') }}: ' + title,
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
    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3500 }).fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif
    @if(session('error') || $errors->any())
    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 5000 }).fire({ icon: 'error', title: '{{ session('error') ?? $errors->first() }}' });
    @endif
</script>
@endsection
