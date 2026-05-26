<?php
// app/Models/AdminDeviceToken.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminDeviceToken extends Model
{
    protected $fillable = ['admin_id', 'token', 'device_type'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
