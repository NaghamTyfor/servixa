<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreRoleRequest;
use App\Http\Requests\Web\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $service
    ) {}


public function index(Request $request): View
{
    $search = $request->get('search');
    $roles = $this->service->paginateRoles($search);
    $permissions = $this->service->allPermissions();
    $totalRoles = \Spatie\Permission\Models\Role::where('guard_name', 'admin')->count();

    return view('admin.roles.index', [
        'roles'       => $roles,
        'permissions' => $permissions,
        'totalRoles'  => $totalRoles,
        'catName'     => 'roles',
        'title'       => 'SERVIXA - Roles & Permissions',
        'breadcrumbs' => [__('admin.roles')],
        'scrollspy'   => 0,
        'simplePage'  => 0,
    ]);
}

    public function create(): View
    {
        $permissions = $this->service->allPermissions();

        return view('admin.roles.create', [
            'permissions' => $permissions,
            'catName'     => 'roles',
            'title'       => 'SERVIXA - Create Role',
            'breadcrumbs' => [__('admin.roles'), __('admin.create')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }


    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $this->service->create(
            $request->validated()['name'],
            $request->validated()['permissions'] ?? []
        );

        return redirect()->route('admin.roles.index')
            ->with('success', __('admin.role_created'));
    }


    public function show(Role $role): View
    {
        if ($role->name === 'super-admin') {
            abort(403, __('admin.cannot_view_super_admin'));
        }

        $role->load('permissions');
        $permissions = $this->service->allPermissions();

        return view('admin.roles.show', [
            'role'        => $role,
            'permissions' => $permissions,
            'catName'     => 'roles',
            'title'       => 'SERVIXA - Role Details',
            'breadcrumbs' => [__('admin.roles'), __('admin.details')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }


    public function edit(Role $role): View
    {
        if ($role->name === 'super-admin') {
            abort(403, __('admin.cannot_modify_super_admin'));
        }

        $role->load('permissions');
        $permissions = $this->service->allPermissions();

        return view('admin.roles.edit', [
            'role'        => $role,
            'permissions' => $permissions,
            'catName'     => 'roles',
            'title'       => 'SERVIXA - Edit Role',
            'breadcrumbs' => [__('admin.roles'), __('admin.edit')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }


    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        if ($role->name === 'super-admin') {
            return back()->withErrors(['name' => __('admin.cannot_modify_super_admin')]);
        }

        $this->service->update(
            $role,
            $request->validated()['name'],
            $request->validated()['permissions'] ?? []
        );

        return redirect()->route('admin.roles.index')
            ->with('success', __('admin.role_updated'));
    }


    public function destroy(Role $role): RedirectResponse
    {
        try {
            $this->service->delete($role);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['role' => $e->getMessage()]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', __('admin.role_deleted'));
    }


    public function syncPermissions(Request $request, Role $role): RedirectResponse
    {
        try {
            $this->service->syncPermissions($role, $request->input('permissions', []));
        } catch (\RuntimeException $e) {
            return back()->withErrors(['permissions' => $e->getMessage()]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', __('admin.permissions_updated'));
    }

    public function bulkDestroy(Request $request): RedirectResponse
{
    $ids = json_decode($request->input('ids'), true);

    if (!empty($ids)) {
        try {
            $roles = Role::whereIn('id', $ids)->where('name', '!=', 'super-admin')->get();
            foreach ($roles as $role) {
                $role->delete();
            }
        } catch (\Exception $e) {
            return back()->withErrors(['roles' => __('admin.error_deleting_roles')]);
        }
    }

    return redirect()
        ->route('admin.roles.index')
        ->with('success', __('admin.roles_deleted', ['count' => count($ids)]));
}
}
