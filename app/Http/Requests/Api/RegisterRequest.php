<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'=> ['required', 'string', 'max:100'],
            'last_name'=> ['required', 'string', 'max:100'],
            'phone'=> [
                'required',
                'string',
                'unique:users,phone',
                'regex:/^(\+?\d{1,3})?[-.\s]?\(?\d{1,4}\)?[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/' 
            ],
            'password'=> ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation'=> ['required', 'string'],
            'city_id'=> ['required', 'integer', 'exists:cities,id'],
        ];
    }
}
