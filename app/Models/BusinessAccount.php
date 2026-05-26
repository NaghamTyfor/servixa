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

class BusinessAccount extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;
protected $with = [];
    protected $fillable = [
        'user_id', 'activity_type_id', 'city_id', 'business_name',
        'license_number', 'lat', 'lng', 'activities', 'details',
        'status', 'submitted_at', 'reviewed_at', 'reviewed_by', 'is_active',
    ];

    public array $translatable = ['business_name'];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'reviewed_at'  => 'datetime',
            'is_active'    => 'boolean',
        ];
    }


public function user(): BelongsTo
{
    return $this->belongsTo(User::class)->withDefault();
}
    public function activityType(): BelongsTo { return $this->belongsTo(ActivityType::class); }
    public function city(): BelongsTo { return $this->belongsTo(City::class); }
    public function reviewer(): BelongsTo { return $this->belongsTo(Admin::class, 'reviewed_by'); }
    public function services(): HasMany { return $this->hasMany(Service::class); }
    public function sentRequests(): HasMany { return $this->hasMany(ServiceRequest::class, 'requester_business_account_id'); }
    public function receivedRequests(): HasMany { return $this->hasMany(ServiceRequest::class, 'provider_business_account_id'); }


    public function scopePending($query)   { return $query->where('status', 'pending'); }
    public function scopeApproved($query)  { return $query->where('status', 'approved'); }
    public function scopeRejected($query)  { return $query->where('status', 'rejected'); }
    public function scopeSuspended($query) { return $query->where('status', 'suspended'); }


    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isApproved(): bool  { return $this->status === 'approved'; }
    public function isRejected(): bool  { return $this->status === 'rejected'; }
    public function isSuspended(): bool { return $this->status === 'suspended'; }


    protected static function booted(): void
    {
        static::saving(function ($account) {
            $account->is_active = $account->status === 'approved';
        });
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
            ]);

        $this->addMediaCollection('documents')
            ->acceptsMimeTypes([
                'application/pdf',
                'image/jpeg',
                'image/png',
            ]);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('images')
            ->nonQueued(); 
    }

}
