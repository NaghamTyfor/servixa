<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'code',
        'expires_at',
        'is_used',
    ];
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'is_used'    => 'boolean',
        ];
    }
    public function scopeValid($query)
    {
        return $query->where('is_used', false)
            ->where('expires_at', '>', Carbon::now());
    }
    public function scopeForPhone($query, string $phone)
    {
        return $query->where('phone', $phone);
    }
    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->expires_at);
    }
}
