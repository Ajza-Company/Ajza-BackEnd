<?php

namespace App\Http\Resources\v1\Frontend\Product;

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
            'name' => $this->localized?->name,
            'price' => $this->price,
            'currency' => '',
            'discount' => $this->whenLoaded('offer', function (){
                return trans('general.product_discount', ['discount' => $this->offer->discount ?? 0]);
            }),
            'image' => $this->image,
        ];
    }
}
