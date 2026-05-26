{{-- resources/views/admin/roles/partials/grid.blade.php --}}
<div class="roles-grid">
    @forelse($roles as $role)
        <div class="role-card" data-url="{{ route('admin.roles.show', $role) }}">
            <div class="card-accent-bar"></div>
            <div class="role-card-header">
                <div class="role-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="card-top-right">
                    <input type="checkbox" class="role-checkbox role-select-cb" value="{{ $role->id }}" id="role_{{ $role->id }}">
                    <span class="card-id-badge">ID: {{ $role->id }}</span>
                </div>
            </div>
            <div class="role-card-content">
                <h3 class="role-name">{{ $role->name }}</h3>
                @if($role->permissions->isNotEmpty())
                    <div class="permission-grid">
                        @foreach($role->permissions->take(5) as $perm)
                            <span class="permission-badge" title="{{ $perm->name }}">{{ \Str::limit($perm->name, 20) }}</span>
                        @endforeach
                        @if($role->permissions->count() > 5)
                            <span class="permission-badge">+{{ $role->permissions->count() - 5 }}</span>
                        @endif
                    </div>
                @else
                    <span class="text-muted">{{ __('admin.no_permissions_assigned') }}</span>
                @endif
            </div>
            <div class="role-card-stats">
                <span>{{ $role->permissions->count() }} {{ __('admin.permissions') }}</span>
                <span>{{ __('admin.created') }} {{ $role->created_at->diffForHumans() }}</span>
            </div>
            <div class="role-card-footer">
                <span class="text-muted small">{{ $role->guard_name }}</span>
                <div class="card-actions">
                    <a href="{{ route('admin.roles.show', $role) }}" class="action-icon-btn action-view" data-bs-toggle="tooltip" title="{{ __('admin.view') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </a>
                    <a href="{{ route('admin.roles.edit', $role) }}" class="action-icon-btn action-edit" data-bs-toggle="tooltip" title="{{ __('admin.edit') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </a>
                    @if($role->name !== 'super-admin')
                        <button type="button" class="action-icon-btn action-delete" data-bs-toggle="tooltip" title="{{ __('admin.delete') }}"
                                data-role-name="{{ $role->name }}"
                                data-delete-url="{{ route('admin.roles.destroy', $role) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <h4 class="empty-title">{{ __('admin.no_roles') }}</h4>
            <p class="empty-subtitle">{{ __('admin.create_first_role') }}</p>
        </div>
    @endforelse
</div>

@if(method_exists($roles, 'links'))
    <div class="cities-pagination">
        {{ $roles->links() }}
    </div>
@endif
