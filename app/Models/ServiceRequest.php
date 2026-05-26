<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'service_id',
        'requester_business_account_id',
        'provider_business_account_id',
        'needed_time',
        'details',
        'quantity',
        'status',
    ];

    protected $casts = [
        'needed_time' => 'datetime',
    ];


    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function requesterAccount(): BelongsTo
    {
        return $this->belongsTo(BusinessAccount::class, 'requester_business_account_id');
    }

    public function providerAccount(): BelongsTo
    {
        return $this->belongsTo(BusinessAccount::class, 'provider_business_account_id');
    }

    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class, 'request_id');
    }


    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }


    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}
