<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateActivityTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $activityType = $this->route('activity_type');

        return [
            'name_ar' => [
                'required',
                'string',
                'max:100',
                Rule::unique('activity_types', 'name->ar')->ignore($activityType->id ?? $activityType)
            ],
            'name_en' => [
                'required',
                'string',
                'max:100',
                Rule::unique('activity_types', 'name->en')->ignore($activityType->id ?? $activityType)
            ],
        ];
    }
}
