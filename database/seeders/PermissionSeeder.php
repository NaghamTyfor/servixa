<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
public static array $SYSTEM_PERMISSIONS = [
    'business_accounts.view',
    'business_accounts.approve',
    'business_accounts.reject',
    'business_accounts.delete',
    'business_accounts.suspend',
    'business_accounts.reactivate',

    'services.view',
    'services.create',
    'services.edit',
    'services.delete',
    'services.approve',
    'services.reject',
    'services.suspend',
    'services.reactivate',

    'categories.view',
    'categories.create',
    'categories.edit',
    'categories.delete',

    'sub_categories.view',
    'sub_categories.create',
    'sub_categories.edit',
    'sub_categories.delete',

    'dynamic_fields.view',
    'dynamic_fields.create',
    'dynamic_fields.edit',
    'dynamic_fields.delete',


    'cities.view',
    'cities.create',
    'cities.edit',
    'cities.delete',


    'activity_types.view',
    'activity_types.create',
    'activity_types.edit',
    'activity_types.delete',


    'admins.view',
    'admins.create',
    'admins.edit',
    'admins.delete',


    'roles.view',
    'roles.create',
    'roles.edit',
    'roles.delete',
    'roles.assign_permissions',


    'sliders.view',
    'sliders.create',
    'sliders.edit',
    'sliders.delete',

    'reports.view',
];

    public function run(): void
    {
        foreach (self::$SYSTEM_PERMISSIONS as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }

        $superAdmin = Role::firstOrCreate(
            ['name' => 'super-admin', 'guard_name' => 'admin']
        );

        $superAdmin->syncPermissions(
            Permission::where('guard_name', 'admin')->get()
        );

        $this->command->info('✅ Permissions & super-admin role seeded successfully.');
    }
}
