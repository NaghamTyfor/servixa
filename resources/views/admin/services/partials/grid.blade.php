@php
    $paginator = $services;
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
@endphp

<div class="services-grid">
    @forelse($services as $service)
        @php
            $titleAr = $service->getTranslation('title', 'ar', false) ?: '—';
            $titleEn = $service->getTranslation('title', 'en', false) ?: '—';
            $descriptionAr = Str::limit($service->getTranslation('description', 'ar', false) ?: '', 80);
            $businessName = $service->businessAccount->getTranslation('business_name', app()->getLocale(), false) ?: '—';
            $categoryName = $service->category?->getTranslation('name', app()->getLocale()) ?: '—';
            $priceSyp = $service->price_syp ? number_format($service->price_syp, 2) . ' SYP' : '—';
            $priceUsd = $service->price_usd ? number_format($service->price_usd, 2) . ' USD' : '—';
            $serviceType = $service->service_type === 'sale' ? __('admin.sale') : __('admin.rent');
            $quantity = $service->quantity;
        @endphp
        <div class="service-card"
             data-service-id="{{ $service->id }}"
             data-url="{{ route('admin.services.show', $service) }}">
            <div class="card-accent-bar"></div>
            <div class="service-card-header">
                <div class="service-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/>
                        <line x1="9" y1="2" x2="9" y2="22"/>
                        <line x1="15" y1="2" x2="15" y2="22"/>
                        <line x1="2" y1="9" x2="22" y2="9"/>
                        <line x1="2" y1="15" x2="22" y2="15"/>
                    </svg>
                </div>
                <div class="card-top-right">
                    @if($service->status === 'pending')
                        <span class="badge-status badge-pending">{{ __('admin.pending') }}</span>
                    @elseif($service->status === 'approved')
                        <span class="badge-status badge-approved">{{ __('admin.approved') }}</span>
                    @elseif($service->status === 'suspended')
                        <span class="badge-status badge-suspended">{{ __('admin.suspended') }}</span>
                    @else
                        <span class="badge-status badge-rejected">{{ __('admin.rejected') }}</span>
                    @endif
                </div>
            </div>

            <div class="service-title">
                <strong>{{ $titleAr }}</strong>
                @if($titleAr !== $titleEn)
                    <span class="text-muted">({{ $titleEn }})</span>
                @endif
            </div>
            <div class="service-description">
                {{ $descriptionAr }}
            </div>



            <div class="service-card-footer">
                <a href="{{ route('admin.services.show', $service) }}"
                   class="action-icon-btn"
                   title="{{ __('admin.details') }}"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </a>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/>
                    <line x1="9" y1="2" x2="9" y2="22"/>
                    <line x1="15" y1="2" x2="15" y2="22"/>
                    <line x1="2" y1="9" x2="22" y2="9"/>
                    <line x1="2" y1="15" x2="22" y2="15"/>
                </svg>
            </div>
            <h3 class="empty-title">{{ __('admin.no_data') }}</h3>
            <p class="empty-subtitle">
                {{ request('search') ? __('admin.no_search_results') : __('admin.start_adding_services') }}
            </p>
        </div>
    @endforelse
</div>

{{-- ✅ روابط التصفح الحقيقية (مثل حسابات الأعمال) --}}
@if($paginator && $paginator->hasPages())
<div class="pagination-custom_solid">
    @if($paginator->onFirstPage())
        <span class="prev disabled">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="prev" rel="prev">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </a>
    @endif

    <ul class="pagination">
        @if($currentPage > 3)
            <li><a href="{{ $paginator->url(1) }}">1</a></li>
            @if($currentPage > 4)
                <li class="disabled"><span>...</span></li>
            @endif
        @endif

        @for($page = max(1, $currentPage - 2); $page <= min($lastPage, $currentPage + 2); $page++)
            <li>
                <a href="{{ $page == $currentPage ? 'javascript:void(0);' : $paginator->url($page) }}" class="{{ $page == $currentPage ? 'active' : '' }}">
                    {{ $page }}
                </a>
            </li>
        @endfor

        @if($currentPage < $lastPage - 2)
            @if($currentPage < $lastPage - 3)
                <li class="disabled"><span>...</span></li>
            @endif
            <li><a href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
        @endif
    </ul>

    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="next" rel="next">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>
    @else
        <span class="next disabled">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </span>
    @endif
</div>
@endif
