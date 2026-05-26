<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleService
{


    public function all(): Collection
    {
        return Role::where('guard_name', 'admin')
            ->where('name', '!=', 'super-admin')
            ->withCount('permissions')
            ->with('permissions')
            ->get();
    }

    public function create(string $name, array $permissionNames = []): Role
    {
        $role = Role::create(['name' => $name, 'guard_name' => 'admin']);

        if (!empty($permissionNames)) {
            $validPermissions = Permission::where('guard_name', 'admin')
                ->whereIn('name', $permissionNames)
                ->pluck('name')
                ->toArray();
            $role->syncPermissions($validPermissions);
        }

        return $role;
    }

    public function update(Role $role, string $name, array $permissionNames = []): Role
    {
        $role->update(['name' => $name]);

        if (!empty($permissionNames)) {
            $validPermissions = Permission::where('guard_name', 'admin')
                ->whereIn('name', $permissionNames)
                ->pluck('name')
                ->toArray();
            $role->syncPermissions($validPermissions);
        }

        return $role;
    }

    public function delete(Role $role): void
    {
        if ($role->name === 'super-admin') {
            throw new \RuntimeException(__('admin.cannot_delete_super_admin'));
        }
        $role->delete();
    }

    public function syncPermissions(Role $role, array $permissionNames): Role
    {
        if ($role->name === 'super-admin') {
            throw new \RuntimeException(__('admin.cannot_modify_super_admin'));
        }

        $validPermissions = Permission::where('guard_name', 'admin')
            ->whereIn('name', $permissionNames)
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($validPermissions);
        return $role->load('permissions');
    }



public function allPermissions(): Collection
{
    return Permission::where('guard_name', 'admin')
        ->orderBy('name')
        ->get()
        ->groupBy(fn($p) => explode('.', $p->name)[0])
        ->reject(function ($permissions, $module) {
            // استبعاد مجموعتي 'admins' و 'roles' من العرض فقط
            return in_array($module, ['admins', 'roles']);
        });
}


    public function searchAdmins(?string $name = null, ?string $email = null, int $perPage = 15): LengthAwarePaginator
    {
        return Admin::query()
            ->with('roles')
            ->where('id', '!=', auth('admin')->id())
            ->whereDoesntHave('roles', fn($q) => $q->where('name', 'super-admin')->where('guard_name', 'admin'))
            ->when($name, fn($q) => $q->where('name', 'like', "%{$name}%"))
            ->when($email, fn($q) => $q->where('email', 'like', "%{$email}%"))
            ->paginate($perPage)
            ->appends(['name' => $name, 'email' => $email]);
    }


    public function createAdmin(array $data): Admin
    {
        $data['password'] = Hash::make($data['password']);
        $admin = Admin::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        if (!empty($data['roles']) && is_array($data['roles'])) {
            $roles = Role::where('guard_name', 'admin')
                ->whereIn('name', $data['roles'])
                ->pluck('name')
                ->toArray();
            $admin->syncRoles($roles);
        }

        return $admin;
    }


    public function updateAdmin(Admin $admin, array $data): Admin
    {
        $updateData = [
            'name'  => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $admin->update($updateData);

        if (array_key_exists('roles', $data)) {
            $roles = is_array($data['roles']) ? $data['roles'] : [];
            $validRoles = Role::where('guard_name', 'admin')
                ->whereIn('name', $roles)
                ->pluck('name')
                ->toArray();
            $admin->syncRoles($validRoles);
        }

        return $admin;
    }


    public function syncAdminRoles(Admin $admin, array $roleNames): Admin
    {
        $validRoles = Role::where('guard_name', 'admin')
            ->whereIn('name', $roleNames)
            ->pluck('name')
            ->toArray();
        $admin->syncRoles($validRoles);
        return $admin;
    }

    public function deleteAdmin(Admin $admin): void
    {
        if ($admin->hasRole('super-admin')) {
            throw new \RuntimeException(__('admin.cannot_delete_super_admin'));
        }
        $admin->delete();
    }

    public function bulkDeleteAdmins(array $ids): void
    {
        $admins = Admin::whereIn('id', $ids)->get();

        foreach ($admins as $admin) {
            if ($admin->hasRole('super-admin')) {
                throw new \RuntimeException(__('admin.cannot_delete_super_admin'));
            }
            $admin->delete();
        }
    }

    public function getAdminById(int $id): ?Admin
    {
        return Admin::with('roles.permissions')->find($id);
    }

    public function paginateRoles(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return Role::where('guard_name', 'admin')
            ->where('name', '!=', 'super-admin')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->withCount('permissions')
            ->with('permissions')
            ->paginate($perPage)
            ->appends(['search' => $search]);
    }

    public function searchTrashedAdmins(?string $search = null, int $perPage = 15): LengthAwarePaginator
{
    return Admin::onlyTrashed()
        ->with('roles')
        ->when($search, fn(Builder $q) => $q->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        }))
        ->paginate($perPage)
        ->appends(['search' => $search]);
}


public function restoreAdmin(int $adminId): Admin
{
    $admin = Admin::withTrashed()->findOrFail($adminId);
    if (!$admin->trashed()) {
        throw new \RuntimeException(__('admin.admin_not_deleted'));
    }
    $admin->restore();
    return $admin;
}


public function forceDeleteAdmin(int $adminId): void
{
    $admin = Admin::withTrashed()->findOrFail($adminId);
    $admin->forceDelete();
}
}
