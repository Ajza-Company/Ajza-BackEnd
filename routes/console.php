<?php

use App\Models\RepChat;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Broadcast::channel('private-repair.chat.{chatId}', function ($user, $chatId) {
    $chat = RepChat::findOrFail($chatId);
    return $user->id === $chat->user1_id || $user->id === $chat->user2_id;
});
