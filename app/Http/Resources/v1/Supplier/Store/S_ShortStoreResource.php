<?php

namespace App\Http\Resources\v1\Supplier\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class S_ShortStoreResource extends JsonResource
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
            'name' => $this->company?->localized?->name,
            'isActive' => (bool)$this->is_active,
            'address' => $this->area?->localized?->name . ', ' . $this->area?->state?->localized?->name
        ];
    }
}
