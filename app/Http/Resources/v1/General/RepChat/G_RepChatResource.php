<?php

namespace App\Http\Resources\v1\General\RepChat;

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
            'id' => $this->id,
            'order_id' => $this->rep_order_id,
            'user1' => new UserResource($this->whenLoaded('user1')),
            'user2' => new UserResource($this->whenLoaded('user2')),
            'latest_message' => new G_RepChatMessageResource($this->whenLoaded('latestMessage')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
