<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBusinessAccountRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'activity_type_id'   => ['sometimes', 'exists:activity_types,id'],
            'city_id'            => ['sometimes', 'exists:cities,id'],
            'business_name_ar'   => ['sometimes', 'string', 'max:255'],
            'business_name_en'   => ['sometimes', 'string', 'max:255'],
            'license_number'     => ['sometimes', 'nullable', 'string', 'max:100'],
            'lat'                => ['sometimes', 'nullable', 'numeric'],
            'lng'                => ['sometimes', 'nullable', 'numeric'],
            'activities'         => ['sometimes', 'nullable', 'string'],
            'details'            => ['sometimes', 'nullable', 'string'],

            'images'             => ['sometimes', 'array'],
            'images.*'           => ['file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'delete_image_ids'   => ['sometimes', 'array'],
            'delete_image_ids.*' => ['exists:media,id'],

            'documents'          => ['sometimes', 'array'],
            'documents.*'        => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'delete_document_ids'=> ['sometimes', 'array'],
            'delete_document_ids.*' => ['exists:media,id'],

            Rule::unique('business_accounts', 'activity_type_id')
                ->where('user_id', auth()->id()),
        ];
    }
}
