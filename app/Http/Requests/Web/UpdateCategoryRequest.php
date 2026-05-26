<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name_ar'    => ['sometimes', 'string', 'max:255'],
            'name_en'    => ['sometimes', 'string', 'max:255'],
        ];
    }
}
