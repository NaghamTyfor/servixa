<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class StoreDynamicFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'type' => 'required|in:text,number,select,textarea,date',
            'is_required' => 'sometimes|boolean',
        ];

        if ($this->input('type') === 'select') {
            $rules['options_ar'] = 'required|array|min:1';
            $rules['options_en'] = 'required|array|min:1';
            $rules['options_ar.*'] = 'required|string';
            $rules['options_en.*'] = 'required|string';
        }

        return $rules;
    }

    public function getOptionsArray(): ?array
    {
        if ($this->input('type') !== 'select') {
            return null;
        }

        $optionsAr = $this->input('options_ar', []);
        $optionsEn = $this->input('options_en', []);

        $options = [];
        $count = count($optionsAr);

        for ($i = 0; $i < $count; $i++) {
            $options[] = [
                'label' => [
                    'ar' => $optionsAr[$i] ?? '',
                    'en' => $optionsEn[$i] ?? '',
                ],
            ];
        }

        return $options;
    }
}
