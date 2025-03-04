<?php

use App\Models\RepChat;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => 'auth:sanctum']);

/*Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/

Broadcast::channel('orders', function ($user) {
    return true;
});

Broadcast::channel('repair.chat.{chatId}', function ($user, $chatId) {
    try {
        $decodedChatId = decodeString($chatId);
        $chat = RepChat::findOrFail($decodedChatId);

        $authorized = $user->id === $chat->user1_id || $user->id === $chat->user2_id;

        \Log::info('Channel Auth:', [
            'user_id' => $user->id,
            'chat_id' => $chatId,
            'authorized' => $authorized
        ]);

        return $authorized;
    } catch (\Exception $e) {
        \Log::error('Channel Auth Error:', [
            'error' => $e->getMessage(),
            'chat_id' => $chatId
        ]);
        return false;
    }
});
