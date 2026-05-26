<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'activity_type_id' => 'required|exists:activity_types,id',
            'city_id'          => 'required|exists:cities,id',
            'business_name_ar' => 'required|string|max:255',
            'business_name_en' => 'required|string|max:255',
            'license_number'   => 'nullable|string|max:255',
            'lat'              => 'nullable|numeric',
            'lng'              => 'nullable|numeric',
            'activities'       => 'nullable|string',
            'details'          => 'nullable|string',
            'images.*'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'documents.*'      => 'nullable|mimes:pdf,doc,docx|max:5120',
        ];
    }
}
