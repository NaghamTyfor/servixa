<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
class SubCategory extends Model
{
    use HasFactory, HasTranslations, InteractsWithMedia;
    protected $fillable = [
        'category_id',
        'name',
    ];
    public array $translatable = ['name'];
    protected function casts(): array
    {
        return [
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function dynamicFields(): MorphMany
    {
        return $this->morphMany(DynamicField::class, 'dynamic_fieldable');
    }

    public function getAllDynamicFields()
    {
        $fields = $this->dynamicFields;
        if ($this->category) {
            $fields = $fields->merge($this->category->dynamicFields);
        }
        return $fields;
    }
}
