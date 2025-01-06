<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => __('notifications.' . $this->type . '.title'),
            'description' => __('notifications.' . $this->type . '.description'),
            'icon' => $this->getIcon($this->type),
        ];
    }

    private function getIcon($type): string
    {
        return [
            'order_confirmed' => 'check-circle',
            'discount_code' => 'tag',
            'order_shipped' => 'truck',
            'app_update' => 'sync-alt',
        ][$type];
    }
}
