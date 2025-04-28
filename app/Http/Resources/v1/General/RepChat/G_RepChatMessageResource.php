<?php

namespace App\Http\Resources\v1\General\RepChat;

use App\Http\Resources\v1\User\ShortUserResource;
use App\Http\Resources\v1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class G_RepChatMessageResource extends JsonResource
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
            'sender' => ShortUserResource::make($this->whenLoaded('sender')),
            'sender_mobile' => $this->relationLoaded('sender') && ($this->relationLoaded('offer') && $this->offer?->status === 'accepted') ? $this->sender->full_mobile : null,
            'message' => $this->message,
            'message_type' => $this->message_type,
            'is_hidden' => (bool)$this->is_hidden,
            'is_invoice' => (bool)$this->is_invoice,
            'attachment' => $this->when($this->attachment, function() {
                return [
                    'url' => getFullUrl($this->attachment),
                    'filename' => basename($this->attachment)
                ];
            }),
            'offer' => new G_RepOfferResource($this->whenLoaded('offer')),
            'created_at' => $this->created_at,
        ];
    }
}
