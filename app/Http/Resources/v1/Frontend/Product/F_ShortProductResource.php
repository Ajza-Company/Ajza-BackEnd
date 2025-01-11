<?php

namespace App\Http\Resources\v1\Frontend\Product;

use App\Http\Resources\v1\Frontend\Store\F_ShortStoreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class F_ShortProductResource extends JsonResource
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
            'store_id' => encodeString($this->store_id),
            'name' => $this->product?->localized?->name,
            'price' => $this->price,
            'currency' => $this->store?->company?->country?->localized?->currency_code,
            'discount' => $this->whenLoaded('offer', function (){
                return trans('general.product_discount', ['discount' => $this->offer->discount ?? 0]);
            }),
            'image' => $this->product?->image,
            'is_favorite' => $this->when($this->relationLoaded('favorite'), function () {
                return $this->favorite !== null;
            }),
            'store' => $this->whenLoaded('store', new F_ShortStoreResource($this->store))
        ];
    }
}
