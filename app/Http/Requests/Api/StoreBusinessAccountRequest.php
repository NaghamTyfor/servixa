<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBusinessAccountRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'activity_type_id'  => ['required', 'exists:activity_types,id'],
            'city_id'           => ['required', 'exists:cities,id'],
            'business_name_ar'  => ['required', 'string', 'max:255'],
            'business_name_en'  => ['required', 'string', 'max:255'],
            'license_number'    => ['nullable', 'string', 'max:100'],
            'lat'               => ['nullable', 'numeric'],
            'lng'               => ['nullable', 'numeric'],
            'activities'        => ['nullable', 'string'],
            'details'           => ['nullable', 'string'],
            'images'            => ['nullable', 'array'],
            'images.*'          => ['file', 'mimes:jpg,jpeg,png,webp'],
            'documents'         => ['nullable', 'array'],
            'documents.*'       => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            Rule::unique('business_accounts', 'activity_type_id')
                ->where('user_id', auth()->id()),
        ];
    }
}
