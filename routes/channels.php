<?php

use App\Models\RepChat;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('repair.chat.{chatId}', function ($user, $chatId) {
    return auth()->check();
    /*$chat = RepChat::findOrFail($chatId);
    return $user->id === $chat->user1_id || $user->id === $chat->user2_id;*/
});
