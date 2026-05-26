<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class DynamicField extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'dynamic_fields';
    protected $fillable = [
        'name',
        'type',
        'options',
        'is_required',
        'dynamic_fieldable_type',
        'dynamic_fieldable_id',
    ];
    public array $translatable = ['name'];
    protected function casts(): array
    {
        return [
            'options' => 'array',
            'is_required' => 'boolean',
        ];
    }
    public function dynamic_fieldable(): MorphTo
    {
        return $this->morphTo();
    }
    public function hasOptions(): bool
    {
        return $this->type === 'select' && !empty($this->options);
    }
public function getTranslatedOptions(?string $locale = null): array
{
    if (!$this->hasOptions()) {
        return [];
    }

    $locale = $locale ?: app()->getLocale();
    $options = $this->options;

    return collect($options)->map(function ($opt) use ($locale) {
        $label = $opt['label'][$locale] ?? ($opt['label']['en'] ?? '');
        $value = $opt['label']['en'] ?? '';  
        return [
            'value' => $value,
            'label' => $label,
        ];
    })->values()->toArray();
}
public function isValidOptionValue($value): bool
{
    if (!$this->hasOptions()) {
        return true;
    }

    $allowedValues = collect($this->options)
        ->map(fn($opt) => $opt['label']['en'] ?? '')
        ->filter()
        ->toArray();

    return in_array($value, $allowedValues);
}
}
