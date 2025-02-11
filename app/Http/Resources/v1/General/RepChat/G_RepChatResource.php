<?php

namespace App\Http\Resources\v1\General\RepChat;

use App\Http\Resources\v1\User\ShortUserResource;
use App\Http\Resources\v1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class G_RepChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => encodeString($this->id),
            'rep_order_id' => encodeString($this->rep_order_id),
            'user1' => ShortUserResource::make($this->whenLoaded('user1')),
            'user2' => ShortUserResource::make($this->whenLoaded('user2')),
            'latest_message' => G_RepChatMessageResource::make($this->whenLoaded('latestMessage')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
