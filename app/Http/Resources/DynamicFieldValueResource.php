<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DynamicFieldValueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        $fieldName = $this->dynamicField->getTranslation('name', $locale);

        return [
            'field' => [
                'id'   => $this->dynamicField->id,
                'name' => $fieldName,
                'type' => $this->dynamicField->type,
            ],
            'value' => $this->value,
        ];
    }
}
