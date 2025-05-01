<?php

namespace App\Http\Resources\v1\Admin\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class A_ShortStoreResource extends JsonResource
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
            'name' => $this->localized?->name,
            'image' => $this->image,
            'address' => $this->address,
            'is_active' => (bool) $this->is_active,
            'is_approved' => (bool) $this->is_approved
        ];
    }
}
