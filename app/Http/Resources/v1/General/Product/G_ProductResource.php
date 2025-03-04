<?php

namespace App\Http\Resources\v1\General\Product;

use App\Enums\EncodingMethodsEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class G_ProductResource extends JsonResource
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
            'image' => $this->image,
        ];
    }

}