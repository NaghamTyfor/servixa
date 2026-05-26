<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminId = Auth::guard('admin')->id();

        return [
            'name' => ['required', 'string', 'max:255'],
            'current_password' => ['required', 'string', 'current_password:admin'],
            'password' => ['nullable', 'string', Password::defaults(), 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('profile.name_required'),
            'current_password.required' => __('profile.current_password_required'),
            'current_password.current_password' => __('profile.current_password_incorrect'),
            'password.confirmed' => __('profile.password_confirmation_mismatch'),
        ];
    }
}
