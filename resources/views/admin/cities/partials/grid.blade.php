@php
    $paginator = $cities->appends(request()->query());
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
@endphp

<div class="cities-grid" id="citiesGrid">
    @forelse($cities as $city)
    <div class="city-card" data-city-id="{{ $city->id }}" data-url="{{ route('admin.cities.show', $city) }}">
        <div class="card-accent-bar"></div>
        <div class="city-card-header">
            <div class="city-icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
            </div>
            <div class="card-top-right">
                <input type="checkbox" class="city-checkbox city-select-cb" value="{{ $city->id }}" id="chk_{{ $city->id }}">
            </div>
        </div>

        <div class="city-card-names">
            <div class="names-bilingual">
                <div class="name-col name-col-ar">
                    <span class="name-lang-tag">AR</span>
                    <p class="city-name-text">{{ $city->getTranslation('name', 'ar', false) ?? 'غير محدد' }}</p>
                </div>
                <div class="name-col name-col-en">
                    <span class="name-lang-tag">EN</span>
                    <p class="city-name-text">{{ $city->getTranslation('name', 'en', false) ?? 'غير محدد' }}</p>
                </div>
            </div>
        </div>

        <div class="city-card-stats">
            <div class="stat-chip">
                <span class="stat-chip-value">{{ $city->users_count ?? $city->users()->count() }}</span>
                <span class="stat-chip-label">{{ __('admin.total_users') }}</span>
            </div>
            <div class="stat-chip">
                <span class="stat-chip-value">{{ $city->business_accounts_count ?? $city->businessAccounts()->count() }}</span>
                <span class="stat-chip-label">{{ __('admin.business_accounts') }}</span>
            </div>
        </div>

        <div class="city-card-footer">
            <div class="card-actions">
                <a href="{{ route('admin.cities.show', $city) }}" class="action-icon-btn action-view" title="{{ __('admin.details') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </a>
                <a href="{{ route('admin.cities.edit', $city) }}" class="action-icon-btn action-edit" title="{{ __('admin.edit') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </a>
                <button class="action-icon-btn action-delete"
                    data-city-id="{{ $city->id }}"
                    data-city-name="{{ $city->getTranslation('name', app()->getLocale(), false) ?? 'غير محدد' }}"
                    data-delete-url="{{ route('admin.cities.destroy', $city) }}"
                    title="{{ __('admin.delete') }}"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="empty-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
        </div>
        <h3 class="empty-title">{{ __('admin.no_data') }}</h3>
        <p class="empty-subtitle">{{ request('search') ? __('admin.no_search_results') : __('admin.start_adding') }}</p>
    </div>
    @endforelse
</div>

@if($paginator->hasPages())
<div class="cities-pagination d-flex justify-content-center">
    <div class="pagination-custom_solid">
        {{-- Previous Button --}}
        @if($paginator->onFirstPage())
            <span class="prev disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="prev" rel="prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </a>
        @endif

        {{-- Page Numbers --}}
        <ul class="pagination">
            @if($currentPage > 3)
                <li><a href="{{ $paginator->url(1) }}">1</a></li>
                @if($currentPage > 4)
                    <li class="disabled"><span>...</span></li>
                @endif
            @endif

            @for($page = max(1, $currentPage - 2); $page <= min($lastPage, $currentPage + 2); $page++)
                @if($page == $currentPage)
                    <li><a href="javascript:void(0);" class="active">{{ $page }}</a></li>
                @else
                    <li><a href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            @if($currentPage < $lastPage - 2)
                @if($currentPage < $lastPage - 3)
                    <li class="disabled"><span>...</span></li>
                @endif
                <li><a href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
            @endif
        </ul>

        {{-- Next Button --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="next" rel="next">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        @else
            <span class="next disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </span>
        @endif
    </div>
</div>
@endif
