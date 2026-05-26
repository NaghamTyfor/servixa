<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Service extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    protected $table = 'services';

    protected $fillable = [
        'business_account_id',
        'category_id',
        'sub_category_id',
        'title',
        'description',
        'quantity',
        'reserved_quantity',
        'pending_quantity',
        'service_type',
        'price_syp',
        'price_usd',
        'lat',
        'lng',
        'status',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
    ];

    public array $translatable = ['title', 'description'];

    protected $casts = [
        'quantity'          => 'integer',
        'reserved_quantity' => 'integer',
        'pending_quantity'  => 'integer',
        'price_syp'         => 'decimal:2',
        'price_usd'         => 'decimal:2',
        'submitted_at'      => 'datetime',
        'reviewed_at'       => 'datetime',
    ];

    public function businessAccount(): BelongsTo
    {
        return $this->belongsTo(BusinessAccount::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    public function dynamicFieldValues(): HasMany
    {
        return $this->hasMany(ServiceDynamicFieldValue::class);
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function scopeApproved($query)  { return $query->where('status', 'approved'); }
    public function scopePending($query)   { return $query->where('status', 'pending'); }
    public function scopeRejected($query)  { return $query->where('status', 'rejected'); }
    public function scopeSuspended($query) { return $query->where('status', 'suspended'); }

    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isApproved(): bool  { return $this->status === 'approved'; }
    public function isRejected(): bool  { return $this->status === 'rejected'; }
    public function isSuspended(): bool { return $this->status === 'suspended'; }

    public function isUnlimited(): bool
    {
        return $this->quantity === null;
    }


    public function getAvailableQuantityAttribute(): ?int
    {
        if ($this->isUnlimited()) {
            return null;
        }
        return max(0, $this->quantity - ($this->reserved_quantity ?? 0));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')->singleFile();
        $this->addMediaCollection('images');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)->height(300)->sharpen(10)
            ->performOnCollections('main_image', 'images');

        $this->addMediaConversion('preview')
            ->width(800)->height(600)
            ->performOnCollections('main_image');
    }
}
