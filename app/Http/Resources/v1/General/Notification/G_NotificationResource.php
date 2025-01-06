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
        return [
            'title' => $this->data['title'],
            'description' => $this->data['description'],
            'date' => Carbon::parse($this->created_at)->locale(app()->getLocale())->translatedFormat('d M, Y h:i A'),
        ];
    }
}
