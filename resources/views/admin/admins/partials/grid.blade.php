@php
    $paginator = $admins->appends(request()->query());
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
@endphp

<div class="admins-grid" id="adminsGrid">
    @forelse($admins as $admin)
    <div class="admin-card" data-admin-id="{{ $admin->id }}" data-url="{{ route('admin.admins.show', $admin) }}">
        <div class="card-accent-bar"></div>
        <div class="admin-card-header">
            <div class="admin-icon-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="card-top-right">
                <input type="checkbox" class="admin-checkbox" value="{{ $admin->id }}" id="chk_{{ $admin->id }}">
            </div>
        </div>

        <div class="admin-card-info">
            <p class="admin-name">{{ $admin->name }}</p>
            <div class="admin-email">{{ $admin->email }}</div>
            {{-- عرض جميع الأدوار المتعددة --}}
            <div class="roles-list">
                @forelse($admin->roles as $role)
                    <span class="role-badge">{{ $role->name }}</span>
                @empty
                    <span class="role-badge">—</span>
                @endforelse
            </div>
        </div>

        <div class="admin-card-footer">
            <span class="text-muted" style="font-size:0.8rem;">{{ $admin->created_at->format('Y-m-d') }}</span>
            <div class="card-actions">
                <a href="{{ route('admin.admins.show', $admin) }}" class="action-icon-btn action-view" title="{{ __('admin.details') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </a>
                @if(!$admin->hasRole('super-admin'))
                <a href="{{ route('admin.admins.edit', $admin) }}" class="action-icon-btn action-edit" title="{{ __('admin.edit') }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </a>
                <button class="action-icon-btn action-delete"
                    data-admin-id="{{ $admin->id }}"
                    data-admin-name="{{ $admin->name }}"
                    data-delete-url="{{ route('admin.admins.destroy', $admin) }}"
                    title="{{ __('admin.delete') }}"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                </button>
                @else
                <span class="badge bg-secondary">{{ __('admin.super_admin') }}</span>
                @endif
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
        <h3 class="empty-title">{{ __('admin.no_data') }}</h3>
        <p class="empty-subtitle">{{ request('name') || request('email') ? __('admin.no_search_results') : __('admin.start_adding_admins') }}</p>
    </div>
    @endforelse
</div>

@if($paginator->hasPages())
<div class="admins-pagination d-flex justify-content-center">
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
