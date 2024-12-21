<?php

namespace App\Http\Resources\v1\Supplier\StoreProduct;

use App\Http\Resources\v1\Supplier\Product\S_ShortProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class S_ShortStoreProductResource extends JsonResource
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
            $this->merge(S_ShortProductResource::make($this->product)),
            'price' => $this->price,
        ];
    }
}
