<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DynamicFieldResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();
        $name = $this->getTranslation('name', $locale);

        $options = null;
        if ($this->hasOptions()) {
            $options = collect($this->options)->map(function ($opt) use ($locale) {
                return [
                    'value' => $opt['label']['en'] ?? '', 
                    'label' => $opt['label'][$locale] ?? ($opt['label']['ar'] ?? ''),
                ];
            })->values()->toArray();
        }

        return [
            'id'          => $this->id,
            'name'        => $name,
            'type'        => $this->type,
            'options'     => $options,
            'is_required' => (bool) $this->is_required,
            'dynamic_fieldable_type' => $this->dynamic_fieldable_type,
            'dynamic_fieldable_id'   => $this->dynamic_fieldable_id,
            'created_at'  => $this->created_at?->toISOString(),
            'updated_at'  => $this->updated_at?->toISOString(),
        ];
    }
}
