<?php

namespace App\Http\Requests\Api;

use App\Models\DynamicField;
use App\Models\SubCategory;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $dynamicFields = $this->input('dynamic_fields');
        if (is_string($dynamicFields) && !empty($dynamicFields)) {
            $decoded = json_decode($dynamicFields, true);
            $this->merge([
                'dynamic_fields' => is_array($decoded) ? $decoded : [],
            ]);
        }

        if ($this->filled('sub_category_id')) {
            $subCategory = SubCategory::find($this->input('sub_category_id'));
            if ($subCategory) {
                $this->merge([
                    'category_id' => $subCategory->category_id,
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'business_account_id'                  => ['required', 'exists:business_accounts,id'],
            'category_id'                          => [
                $this->filled('sub_category_id') ? 'sometimes' : 'required',
                'exists:categories,id'
            ],
            'sub_category_id'                      => ['nullable', 'exists:sub_categories,id'],
            'title_ar'                             => ['required', 'string', 'max:255'],
            'title_en'                             => ['required', 'string', 'max:255'],
            'description_ar'                       => ['required', 'string'],
            'description_en'                       => ['required', 'string'],
            'quantity'                             => ['nullable', 'integer', 'min:1'],
            'service_type'                         => ['required', 'in:sale,rent'],
            'price_syp'                            => ['nullable', 'numeric', 'min:0'],
            'price_usd'                            => ['nullable', 'numeric', 'min:0'],
            'lat'                                  => ['nullable', 'numeric'],
            'lng'                                  => ['nullable', 'numeric'],
            'main_image'                           => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'images'                               => ['nullable', 'array'],
            'images.*'                             => ['file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'dynamic_fields'                       => ['nullable', 'array'],
            'dynamic_fields.*.dynamic_field_id'   => ['required_with:dynamic_fields', 'exists:dynamic_fields,id'],
            'dynamic_fields.*.value'               => ['required_with:dynamic_fields', 'nullable', 'string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->input('price_syp') && !$this->input('price_usd')) {
                $validator->errors()->add('price_syp', __('validation.required_without', [
                    'attribute' => 'price_syp', 'values' => 'price_usd',
                ]));
                $validator->errors()->add('price_usd', __('validation.required_without', [
                    'attribute' => 'price_usd', 'values' => 'price_syp',
                ]));
            }

            $categoryId = $this->input('category_id');
            $subCategoryId = $this->input('sub_category_id');

            if ($categoryId && !$subCategoryId) {
                $hasSubCategories = SubCategory::where('category_id', $categoryId)->exists();
                if ($hasSubCategories) {
                    $validator->errors()->add(
                        'sub_category_id',
                        __('validation.sub_category_required_when_parent_has_children')
                    );
                }
            }

            if ($subCategoryId && $categoryId) {
                $subCategory = SubCategory::find($subCategoryId);
                if ($subCategory && (int) $subCategory->category_id !== (int) $categoryId) {
                    $validator->errors()->add(
                        'sub_category_id',
                        __('validation.sub_category_not_belongs_to_category')
                    );
                }
            }

            foreach ($this->input('dynamic_fields', []) as $index => $fieldData) {
                $dynamicField = DynamicField::find($fieldData['dynamic_field_id'] ?? null);
                if (!$dynamicField) {
                    $validator->errors()->add(
                        "dynamic_fields.{$index}.dynamic_field_id",
                        __('validation.exists', ['attribute' => "dynamic_fields.{$index}.dynamic_field_id"])
                    );
                    continue;
                }

                $belongsToCategory = ($dynamicField->dynamic_fieldable_type === 'App\\Models\\Category' && $dynamicField->dynamic_fieldable_id == $categoryId);
                $belongsToSubCategory = ($subCategoryId && $dynamicField->dynamic_fieldable_type === 'App\\Models\\SubCategory' && $dynamicField->dynamic_fieldable_id == $subCategoryId);

                if (!$belongsToCategory && !$belongsToSubCategory) {
                    $validator->errors()->add(
                        "dynamic_fields.{$index}.dynamic_field_id",
                        __('validation.dynamic_field_not_belong')
                    );
                }

                $value = $fieldData['value'] ?? null;
                if ($dynamicField->type === 'select' && $dynamicField->hasOptions()) {
                    if (!$dynamicField->isValidOptionValue($value)) {
                        $validator->errors()->add(
                            "dynamic_fields.{$index}.value",
                            __('dynamic_field.invalid_value') . ': ' . $dynamicField->getTranslation('name', app()->getLocale())
                        );
                    }
                }

                if ($dynamicField->type === 'number' && !is_numeric($value) && !empty($value)) {
                    $validator->errors()->add(
                        "dynamic_fields.{$index}.value",
                        __('validation.numeric', ['attribute' => $dynamicField->getTranslation('name', app()->getLocale())])
                    );
                }
            }
        });
    }
}
