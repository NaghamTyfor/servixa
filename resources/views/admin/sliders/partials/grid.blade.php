@php
    $paginator = $sliders->appends(request()->query());
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
@endphp

<div class="sliders-grid">
    @forelse($sliders as $slider)
    @php
        $image = $slider->getFirstMedia('image');
        $imageUrl = $image ? asset('storage/' . $image->getPathRelativeToRoot()) : null;
        $isActive = !$slider->starts_at || $slider->starts_at <= now() && (!$slider->ends_at || $slider->ends_at >= now());
        // الحصول على الترجمات
        $titleAr = $slider->getTranslation('title', 'ar', false) ?: '—';
        $titleEn = $slider->getTranslation('title', 'en', false) ?: '—';
    @endphp
    <div class="slider-card">
        @if($imageUrl)
            <div class="slider-image" style="background-image: url('{{ $imageUrl }}'); background-size: cover; background-position: center;">
                <span class="slider-badge {{ $isActive ? 'badge-active' : 'badge-inactive' }}">
                    {{ $isActive ? __('admin.active') : __('admin.inactive') }}
                </span>
            </div>
        @else
            <div class="slider-image-placeholder">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                    <path d="M8 12h8"/>
                </svg>
            </div>
        @endif

        <div class="slider-content">
            {{-- عرض ثنائي اللغة للعنوان --}}
            <div class="names-bilingual">
                <div class="name-col name-col-ar">
                    <span class="name-lang-tag">AR</span>
                    <p class="slider-name-text">{{ $titleAr }}</p>
                </div>
                <div class="name-col name-col-en">
                    <span class="name-lang-tag">EN</span>
                    <p class="slider-name-text">{{ $titleEn }}</p>
                </div>
            </div>

            <div class="slider-meta">
                @if($slider->starts_at || $slider->ends_at)
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span>
                        @if($slider->starts_at) {{ $slider->starts_at->format('Y-m-d') }} @else {{ __('admin.anytime') }} @endif
                        @if($slider->ends_at) → {{ $slider->ends_at->format('Y-m-d') }} @endif
                    </span>
                @endif
            </div>

            @if($slider->link)
                <a href="{{ $slider->link }}" target="_blank" class="slider-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    {{ __('admin.view_link') }}
                </a>
            @endif
        </div>

        <div class="card-actions">
            <a href="{{ route('admin.sliders.show', $slider) }}" class="action-icon-btn action-view" title="{{ __('admin.details') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </a>
            <a href="{{ route('admin.sliders.edit', $slider) }}" class="action-icon-btn action-edit" title="{{ __('admin.edit') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </a>
            <button class="action-icon-btn action-delete"
                    data-slider-id="{{ $slider->id }}"
                    data-slider-title="{{ $titleAr }} / {{ $titleEn }}"
                    data-delete-url="{{ route('admin.sliders.destroy', $slider) }}"
                    title="{{ __('admin.delete') }}"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </button>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="M8 12h8"/>
            </svg>
        </div>
        <h3 class="empty-title">{{ __('admin.no_data') }}</h3>
        <p class="empty-subtitle">{{ request('search') ? __('admin.no_search_results') : __('admin.start_adding_slider') }}</p>
    </div>
    @endforelse
</div>

@if($paginator->hasPages())
<div class="pagination-custom_solid">
    @if($paginator->onFirstPage())
        <span class="prev disabled">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="prev">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </a>
    @endif

    <ul class="pagination">
        @if($currentPage > 3)
            <li><a href="{{ $paginator->url(1) }}">1</a></li>
            @if($currentPage > 4) <li class="disabled"><span>...</span></li> @endif
        @endif
        @for($page = max(1, $currentPage - 2); $page <= min($lastPage, $currentPage + 2); $page++)
            @if($page == $currentPage)
                <li><a href="javascript:void(0);" class="active">{{ $page }}</a></li>
            @else
                <li><a href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
            @endif
        @endfor
        @if($currentPage < $lastPage - 2)
            @if($currentPage < $lastPage - 3) <li class="disabled"><span>...</span></li> @endif
            <li><a href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
        @endif
    </ul>

    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="next">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>
    @else
        <span class="next disabled">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </span>
    @endif
</div>
@endif

<script>
    if (typeof initTooltips !== 'undefined') initTooltips();
    else if (typeof bootstrap !== 'undefined') {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
    }
</script>
