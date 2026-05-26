<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthService
{
    public function login(string $email, string $password, bool $remember = false)
    {
        $admin = $this->findAdminByEmail($email);

        if (! $admin) {
            return [false, 'email', __('auth.email_not_found')];
        }

        if (! $this->validatePassword($admin, $password)) {
            return [false, 'password', __('auth.invalid_password')];
        }

        Auth::guard('admin')->login($admin, $remember);

        return [true, null, null];
    }


    public function findAdminByEmail(string $email)
    {
        return Admin::where('email', $email)->first();
    }

    public function validatePassword(Admin $admin, string $password): bool
    {
        return Hash::check($password, $admin->password);
    }


public function logout(?string $fcmToken = null): void
{
    if ($fcmToken && Auth::guard('admin')->check()) {
        $admin = Auth::guard('admin')->user();
        \App\Models\AdminDeviceToken::where('admin_id', $admin->id)
            ->where('token', $fcmToken)
            ->delete();
    }
    Auth::guard('admin')->logout();
}




}
