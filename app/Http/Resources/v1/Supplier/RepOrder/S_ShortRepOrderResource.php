<?php

namespace App\Http\Resources\v1\Supplier\RepOrder;

use App\Http\Resources\v1\General\RepChat\G_RepChatResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class S_ShortRepOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => encodeString($this->id),
            'title' => $this->title,
            'description' => $this->description,
            'image' => getFullUrl($this->image),
            'status' => $this->status,
            'chat' => $this->whenLoaded('repChat', new G_RepChatResource($this->repChat)),
        ];
    }
}
