<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'service_id',
    ];

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }


    public function otherParticipant(int $userId): User
    {
        return $this->user_one_id === $userId
            ? $this->userTwo
            : $this->userOne;
    }


    public function channelName(): string
    {
        return "conversation.{$this->id}";
    }


    public static function findOrCreateBetween(int $userAId, int $userBId, int $serviceId): self
    {
        [$one, $two] = $userAId < $userBId
            ? [$userAId, $userBId]
            : [$userBId, $userAId];

        return self::firstOrCreate([
            'user_one_id' => $one,
            'user_two_id' => $two,
            'service_id'  => $serviceId,
        ]);
    }
}
