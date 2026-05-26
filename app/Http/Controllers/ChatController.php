<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ChatController extends Controller
{

    public function showDemo($userId1,$userId2,$serviceId): View
    {
        $userId1 = (int) $userId1;
    $userId2 = (int) $userId2;
    $serviceId = (int) $serviceId;
        Auth::guard('web')->loginUsingId($userId1);
    Log::info('Current user ID in showDemo: ' . Auth::guard('web')->id());

        $currentUser = User::findOrFail($userId1);
        $otherUser   = User::findOrFail($userId2);

        $conversation = Conversation::findOrCreateBetween($userId1, $userId2, $serviceId);

$updatedCount = $conversation->messages()
    ->whereNull('read_at')
    ->where('sender_id', '!=', $currentUser->id)
    ->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('sender')->get();

        return view('chat', [
            'conversation' => $conversation,
            'messages'     => $messages,
            'serviceId'    => $serviceId,
            'currentUser'  => $currentUser,
            'otherUser'    => $otherUser,
            'catName'      => 'chat',
            'title'        => __('chat.conversation_with', ['name' => $otherUser->full_name]),
            'breadcrumbs'  => [__('chat.dashboard'), __('chat.messages'), $otherUser->full_name],
            'scrollspy'    => 0,
            'simplePage'   => 0,
        ]);
    }

    public function sendFromWeb(Request $request, int $conversationId): JsonResponse
    {
        $request->validate(['body' => 'required|string|max:5000']);

        $currentUserId = Auth::guard('web')->id();

        if (! $currentUserId) {
            return response()->json(['message' => 'غير مصرح'], 401);
        }

        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->user_one_id !== $currentUserId
            && $conversation->user_two_id !== $currentUserId) {
            return response()->json(['message' => 'ليس لديك صلاحية'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $currentUserId,
            'body'            => $request->body,
        ]);

        $message->load('sender');

        broadcast(new MessageSent($message, $conversation));

        return response()->json([
            'message' => [
                'id'          => $message->id,
                'body'        => $message->body,
                'sender_id'   => $message->sender_id,
                'sender_name' => $message->sender->full_name,
                'read_at'     => $message->read_at,
                'created_at'  => $message->created_at->toDateTimeString(),
            ],
        ], 201);
    }

    public function storeConversation(Request $request): JsonResponse
    {
        $request->validate([
            'other_user_id' => 'required|exists:users,id',
            'service_id'    => 'required|exists:services,id',
        ]);

        $currentUserId = Auth::guard('api')->id();

        if ($currentUserId === (int) $request->other_user_id) {
            return response()->json(['message' => 'لا يمكنك بدء محادثة مع نفسك'], 422);
        }

        $conversation = Conversation::findOrCreateBetween(
            $currentUserId,
            (int) $request->other_user_id,
            (int) $request->service_id
        );

        return response()->json([
            'conversation_id' => $conversation->id,
            'channel'         => "private-conversation.{$conversation->id}",
        ], 201);
    }


    public function sendMessage(Request $request, int $conversationId): JsonResponse
    {
        $request->validate(['body' => 'required|string|max:5000']);

        $currentUserId = Auth::guard('api')->id();
        $conversation  = Conversation::findOrFail($conversationId);

        if ($conversation->user_one_id !== $currentUserId
            && $conversation->user_two_id !== $currentUserId) {
            return response()->json(['message' => 'غير مصرح'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $currentUserId,
            'body'            => $request->body,
        ]);

        broadcast(new MessageSent($message->load('sender'), $conversation));

        return response()->json([
            'message' => [
                'id'          => $message->id,
                'body'        => $message->body,
                'sender_id'   => $message->sender_id,
                'sender_name' => $message->sender->full_name,
                'read_at'     => $message->read_at,
                'created_at'  => $message->created_at->toDateTimeString(),
            ],
        ], 201);
    }


    public function getMessages(int $conversationId): JsonResponse
    {
        $currentUserId = Auth::guard('api')->id();
        $conversation  = Conversation::findOrFail($conversationId);

        if ($conversation->user_one_id !== $currentUserId
            && $conversation->user_two_id !== $currentUserId) {
            return response()->json(['message' => 'غير مصرح'], 403);
        }

        $conversation->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', $currentUserId)
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('sender')->get()
            ->map(fn($msg) => [
                'id'          => $msg->id,
                'body'        => $msg->body,
                'sender_id'   => $msg->sender_id,
                'sender_name' => $msg->sender->full_name,
                'read_at'     => $msg->read_at,
                'created_at'  => $msg->created_at->toDateTimeString(),
            ]);

        return response()->json(['messages' => $messages]);
    }
}
