@php
    $paginator = $reports->appends(request()->query());
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
@endphp

<div class="reports-grid">
    @forelse($reports as $report)
        @php
            $user = $report->user;
            $service = $report->service;
            $serviceTitle = $service ? ($service->getTranslation('title', app()->getLocale(), false) ?: '#'.$service->id) : __('admin.deleted_service');
            $userName = $user ? ($user->first_name . ' ' . $user->last_name) : __('admin.deleted_user');
        @endphp
        <div class="report-card" data-report-id="{{ $report->id }}" data-url="{{ route('admin.reports.show', $report) }}">
            <div class="card-accent-bar"></div>
            <div class="report-card-header">
                <div class="report-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>

            </div>

            <div class="report-content">
                <div class="info-row-card">
                    <div class="info-label-card">{{ __('admin.user') }}</div>
                    <div class="info-value-card">
                        <span class="user-name-card">{{ $userName }}</span>
                    </div>
                </div>
                <div class="info-row-card">
                    <div class="info-label-card">{{ __('admin.service') }}</div>
                    <div class="info-value-card">
                        <span class="service-title-card">{{ $serviceTitle }}</span>
                    </div>
                </div>
                <div class="info-row-card">
                    <div class="info-label-card">{{ __('admin.reason') }}</div>
                    <div class="info-value-card">
                        <span class="reason-badge-card">{{ $report->reason }}</span>
                    </div>
                </div>
                <div class="report-date">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ $report->created_at->format('Y-m-d H:i') }}
                </div>
            </div>

            <div class="report-card-footer">
                <div class="card-actions">
                    <a href="{{ route('admin.reports.show', $report) }}" class="action-icon-btn action-view" title="{{ __('admin.view_details') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <h3 class="empty-title">{{ __('admin.no_data') }}</h3>
            <p class="empty-subtitle">{{ request('search') ? __('admin.no_search_results') : __('admin.no_reports_found') }}</p>
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
    if (typeof bootstrap !== 'undefined') {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
    }
</script>
