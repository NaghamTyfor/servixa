<?php

namespace App\Services;

use App\Models\DynamicField;
use Illuminate\Database\Eloquent\Model;

class DynamicFieldService
{
    public function create(Model $owner, array $data): DynamicField
    {
        $createData = [
            'name' => [
                'ar' => $data['name_ar'],
                'en' => $data['name_en'],
            ],
            'type' => $data['type'],
            'is_required' => $data['is_required'] ?? false,
        ];

        if (isset($data['options'])) {
            $createData['options'] = $data['options'];
        }

        return $owner->dynamicFields()->create($createData);
    }

    public function update(DynamicField $field, array $data): DynamicField
    {
        $updateData = [];

        if (isset($data['name_ar']) || isset($data['name_en'])) {
            $updateData['name'] = [
                'ar' => $data['name_ar'] ?? $field->getTranslation('name', 'ar'),
                'en' => $data['name_en'] ?? $field->getTranslation('name', 'en'),
            ];
        }

        if (isset($data['type'])) {
            $updateData['type'] = $data['type'];
        }

        if (isset($data['is_required'])) {
            $updateData['is_required'] = $data['is_required'];
        }

        if (isset($data['options'])) {
            $updateData['options'] = $data['options'];
        }

        $field->update($updateData);
        return $field->fresh();
    }

    public function delete(DynamicField $field): void
    {
        $field->delete();
    }
}
