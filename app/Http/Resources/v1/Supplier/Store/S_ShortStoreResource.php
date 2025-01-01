<?php

namespace App\Http\Resources\v1\Supplier\Store;

use App\Http\Resources\v1\Frontend\Area\F_AreaResource;
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
            'area' => $this->whenLoaded('area', F_AreaResource::make($this->area)),
            'name' => $this->company?->localized?->name,
            'phone' => $this->phone_number,
            'address_url' => $this->address_url,
            'isActive' => (bool)$this->is_active,
            'address' => $this->area?->localized?->name . ', ' . $this->area?->state?->localized?->name
        ];
    }
}
