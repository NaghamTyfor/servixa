<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::where('email', 'superadmin@gmail.com')->first();

        if ($admin) {
            $admin->assignRole('super-admin');
            $this->command->info('✅ Role "super-admin" assigned to existing admin: ' . $admin->email);
        } else {
            $admin = Admin::create([
                'name'     => 'Super Admin',
                'email'    => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
            ]);
            $admin->assignRole('super-admin');
            $this->command->info('✅ Super admin created and role assigned: superadmin@gmail.com / password');
        }
    }
}
