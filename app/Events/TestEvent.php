<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message = 'Hello from Reverb!')
    {
        $this->message = $message;
        Log::info('TestEvent constructed', ['message' => $message]);
    }

    public function broadcastOn(): array
    {
        Log::info('Broadcasting on test-channel');
        return [new Channel('test-channel')];
    }

    public function broadcastWith(): array
    {
        $data = [
            'message' => $this->message,
            'time' => now()->toISOString()
        ];
        Log::info('Broadcasting data', $data);
        return $data;
    }
}
