@php
    $paginator    = $accounts instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
                        ? $accounts->appends(request()->query())
                        : null;
    $currentPage  = $paginator ? $paginator->currentPage() : 1;
    $lastPage     = $paginator ? $paginator->lastPage()    : 1;
@endphp

<div class="types-grid" id="accountsGrid">
    @forelse($accounts ?? [] as $account)
        @php
            $businessNameAr = 'غير محدد';
            $businessNameEn = 'غير محدد';
            if (method_exists($account, 'getTranslation')) {
                $businessNameAr = $account->getTranslation('business_name', 'ar', false) ?: 'غير محدد';
                $businessNameEn = $account->getTranslation('business_name', 'en', false) ?: 'غير محدد';
            } elseif (isset($account->business_name)) {
                $names = is_string($account->business_name)
                    ? json_decode($account->business_name, true)
                    : $account->business_name;
                $businessNameAr = $names['ar'] ?? 'غير محدد';
                $businessNameEn = $names['en'] ?? 'غير محدد';
            }

            $ownerName = trim(($account->user->first_name ?? '') . ' ' . ($account->user->last_name ?? ''));
            $ownerName = $ownerName ?: '—';

            $activityTypeName = $account->activityType
                ? (method_exists($account->activityType, 'getTranslation')
                    ? ($account->activityType->getTranslation('name', app()->getLocale()) ?: '—')
                    : ($account->activityType->name ?? '—'))
                : '—';

            $cityName = $account->city
                ? (method_exists($account->city, 'getTranslation')
                    ? ($account->city->getTranslation('name', app()->getLocale()) ?: '—')
                    : ($account->city->name ?? '—'))
                : '—';

            $submittedAt = $account->submitted_at
                ? $account->submitted_at->format('Y-m-d')
                : '—';
        @endphp
        <div class="account-card"
             data-account-id="{{ $account->id }}"
             data-url="{{ route('admin.business-accounts.show', $account) }}">
            <div class="card-accent-bar"></div>
            <div class="account-card-header">
                <div class="account-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <div class="card-top-right">

                    @if($account->status === 'pending')
                        <span class="badge-status badge-pending">{{ __('admin.pending') }}</span>
                    @elseif($account->status === 'approved')
                        <span class="badge-status badge-approved">{{ __('admin.approved') }}</span>
                    @elseif($account->status === 'suspended')
                        <span class="badge-status" style="background:#fed7aa;color:#9b4d00;">{{ __('admin.suspended') }}</span>
                    @else
                        <span class="badge-status badge-rejected">{{ __('admin.rejected') }}</span>
                    @endif
                </div>
            </div>

            <div class="account-card-names">
                <div class="names-bilingual">
                    <div class="name-col name-col-ar">
                        <span class="name-lang-tag">AR</span>
                        <p class="account-name-text">{{ $businessNameAr }}</p>
                    </div>
                    <div class="name-col name-col-en">
                        <span class="name-lang-tag">EN</span>
                        <p class="account-name-text">{{ $businessNameEn }}</p>
                    </div>
                </div>
            </div>

            <div class="account-card-stats">
                <div class="stat-chip">
                    <span class="stat-chip-value">{{ $ownerName }}</span>
                    <span class="stat-chip-label">{{ __('admin.owner') }}</span>
                </div>
                <div class="stat-chip">
                    <span class="stat-chip-value">{{ $activityTypeName }}</span>
                    <span class="stat-chip-label">{{ __('admin.activity_type') }}</span>
                </div>
                <div class="stat-chip">
                    <span class="stat-chip-value">{{ $cityName }}</span>
                    <span class="stat-chip-label">{{ __('admin.city') }}</span>
                </div>
                <div class="stat-chip">
                    <span class="stat-chip-value">{{ $submittedAt }}</span>
                    <span class="stat-chip-label">{{ __('admin.submitted_at') }}</span>
                </div>
            </div>

            <div class="account-card-footer">
                <div class="card-actions">
                    {{-- زر التفاصيل فقط --}}
                    <a href="{{ route('admin.business-accounts.show', $account) }}"
                       class="action-icon-btn action-view"
                       title="{{ __('admin.details') }}"
                       data-bs-toggle="tooltip"
                       data-bs-placement="top">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </a>


                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
            </div>
            <h3 class="empty-title">{{ __('admin.no_data') }}</h3>
            <p class="empty-subtitle">
                {{ request('search') ? __('admin.no_search_results') : __('admin.start_adding_business_accounts') }}
            </p>
        </div>
    @endforelse
</div>

{{-- ✅ Pagination --}}
@if($paginator && $paginator->hasPages())
<div class="types-pagination d-flex justify-content-center">
    <div class="pagination-custom_solid">
        @if($paginator->onFirstPage())
            <span class="prev disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="prev" rel="prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
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
                    <a href="{{ $page == $currentPage ? 'javascript:void(0);' : $paginator->url($page) }}"
                       class="{{ $page == $currentPage ? 'active' : '' }}">
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        @else
            <span class="next disabled">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </span>
        @endif
    </div>
</div>
@endif
