@php
    $paginator = $admins->appends(request()->query());
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
@endphp

<div class="types-grid" id="adminsGrid">
    @forelse($admins as $admin)
        <div class="account-card" data-admin-id="{{ $admin->id }}">
            <div class="card-accent-bar"></div>
            <div class="account-card-header">
                <div class="account-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="card-top-right">
                    <span class="badge-status" style="background:#e9ecef;color:#6c757d;">{{ __('admin.deleted') }}</span>
                </div>
            </div>

            <div class="account-card-names">
                <div class="names-bilingual" style="grid-template-columns:1fr;">
                    <div class="name-col">
                        <span class="name-lang-tag">{{ __('admin.name') }}</span>
                        <p class="account-name-text">{{ $admin->name }}</p>
                    </div>
                    <div class="name-col">
                        <span class="name-lang-tag">{{ __('admin.email') }}</span>
                        <p class="account-name-text">{{ $admin->email }}</p>
                    </div>
                </div>
            </div>

            <div class="account-card-stats">

                <div class="stat-chip">
                    <span class="stat-chip-value">{{ $admin->roles->pluck('name')->implode(', ') ?: '—' }}</span>
                    <span class="stat-chip-label">{{ __('admin.roles') }}</span>
                </div>
                <div class="stat-chip">
                    <span class="stat-chip-value">{{ $admin->deleted_at?->format('Y-m-d H:i') ?? '—' }}</span>
                    <span class="stat-chip-label">{{ __('admin.deleted_at') }}</span>
                </div>

            </div>

            <div class="account-card-footer">
                <div class="card-actions">
                    <button type="button"
                            class="action-icon-btn action-restore"
                            onclick="event.preventDefault(); event.stopPropagation(); confirmRestore(this);"
                            data-restore-url="{{ route('admin.admins.restore', $admin->id) }}"
                            data-admin-name="{{ $admin->name }}"
                            title="{{ __('admin.restore') }}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                            <path d="M3 3v5h5"/>
                            <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/>
                            <path d="M21 21v-5h-5"/>
                        </svg>
                    </button>
                    <button type="button"
                            class="action-icon-btn action-force-delete"
                            onclick="event.preventDefault(); event.stopPropagation(); confirmForceDelete(this);"
                            data-force-delete-url="{{ route('admin.admins.force-destroy', $admin->id) }}"
                            data-admin-name="{{ $admin->name }}"
                            title="{{ __('admin.force_delete') }}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                            <line x1="10" y1="11" x2="10" y2="17"/>
                            <line x1="14" y1="11" x2="14" y2="17"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <h3 class="empty-title">{{ __('admin.no_deleted_admins') }}</h3>
            <p class="empty-subtitle">{{ __('admin.no_trashed_found') }}</p>
        </div>
    @endforelse
</div>

@if($paginator->hasPages())
<div class="types-pagination d-flex justify-content-center">
    <div class="pagination-custom_solid">
        @if($paginator->onFirstPage())
            <span class="prev disabled">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="prev">‹</a>
        @endif

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

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="next">›</a>
        @else
            <span class="next disabled">›</span>
        @endif
    </div>
</div>
@endif
