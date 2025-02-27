<?php

use App\Models\RepChat;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => 'auth:sanctum']);

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('repair.chat.{chatId}', function ($user, $chatId) {
    Log::info('channel: ' . $user->id . ' ' . $chatId);
    $chat = RepChat::findOrFail($chatId);
    return $user->id === $chat->user1_id || $user->id === $chat->user2_id;
});
