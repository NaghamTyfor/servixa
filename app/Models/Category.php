<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations, InteractsWithMedia ;

    protected $fillable = [
        'name',
    ];

    public array $translatable = ['name'];

    protected function casts(): array
    {
        return [
        ];
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }
    public function dynamicFields(): MorphMany
    {
        return $this->morphMany(DynamicField::class, 'dynamic_fieldable');
    }

    public function getAllDynamicFields()
    {
        return $this->dynamicFields;
    }
}
