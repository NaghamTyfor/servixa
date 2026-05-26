<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $city = $this->route('city');
        return [
            'name_ar' => [
                'required',
                'string',
                'max:100',
                Rule::unique('cities', 'name->ar')->ignore($city->id ?? $city)
            ],
            'name_en' => [
                'required',
                'string',
                'max:100',
                Rule::unique('cities', 'name->en')->ignore($city->id ?? $city)
            ],
        ];
    }

}
