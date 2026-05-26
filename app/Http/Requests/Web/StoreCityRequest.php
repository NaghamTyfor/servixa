<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_ar' => [
                'required',
                'string',
                'max:100',
                Rule::unique('cities', 'name->ar')
            ],
            'name_en' => [
                'required',
                'string',
                'max:100',
                Rule::unique('cities', 'name->en')
            ],
        ];
    }


}
