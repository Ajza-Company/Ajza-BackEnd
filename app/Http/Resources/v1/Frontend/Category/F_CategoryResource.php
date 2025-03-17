<?php

namespace App\Http\Resources\v1\Frontend\Category;

use App\Http\Resources\v1\Admin\Variant\A_ShortVariantResource;
use App\Http\Resources\v1\Frontend\Store\F_ShortStoreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class F_CategoryResource extends JsonResource
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
            'stores' => F_ShortStoreResource::collection($this->whenLoaded('stores')),
            'variants' => A_ShortVariantResource::collection($this->whenLoaded('variants'))
        ];
    }
}
