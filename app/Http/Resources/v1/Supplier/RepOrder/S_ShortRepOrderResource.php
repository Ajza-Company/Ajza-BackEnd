<?php

namespace App\Http\Resources\v1\Supplier\RepOrder;

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
        ];
    }
}
