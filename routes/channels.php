<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('conversation.{id}', function ($user, $id) {
    $conversation = Conversation::find($id);
    if (!$conversation) {
        return false;
    }

    $isParticipant = (int) $conversation->user_one_id === (int) $user->id ||
                    (int) $conversation->user_two_id === (int) $user->id;

    if ($isParticipant) {
        return [
            'id' => $user->id,
            'name' => $user->full_name
        ];
    }

    return false;
});
