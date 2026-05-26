<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $admin = $this->route('admin');

    return [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:admins,email,' . $this->route('admin')->id,
        'password' => 'nullable|string|min:8|confirmed',
        'roles'    => 'sometimes|array',
        'roles.*'  => 'exists:roles,name',
    ];
    }
}
