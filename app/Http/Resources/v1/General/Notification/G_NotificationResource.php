<?php

namespace App\Http\Resources\v1\General\Notification;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class G_NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Handle admin notifications (SendDynamicNotification)
        if (isset($this->data['title']) && isset($this->data['description'])) {
            return [
                'title' => $this->data['title'],
                'description' => $this->data['description'],
                'icon' => $this->data['icon'] ?? 'bell',
                'date' => Carbon::parse($this->created_at)->locale(app()->getLocale())->translatedFormat('d M, Y h:i A'),
                'created_at' => $this->created_at,
                'read_at' => $this->read_at,
                'type' => $this->data['type'] ?? 'admin_notification'
            ];
        }

        // Handle regular notifications (OrderNotification, RepOrderNotification, etc.)
        return [
            'title' => $this->data['title'] ?? 'Notification',
            'description' => $this->data['description'] ?? 'No description available',
            'icon' => $this->data['icon'] ?? 'info-circle',
            'date' => Carbon::parse($this->created_at)->locale(app()->getLocale())->translatedFormat('d M, Y h:i A'),
            'created_at' => $this->created_at,
            'read_at' => $this->read_at,
            'type' => $this->data['type'] ?? 'general'
        ];
    }
}
