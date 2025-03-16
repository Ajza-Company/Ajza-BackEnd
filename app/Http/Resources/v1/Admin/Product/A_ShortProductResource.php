<?php

namespace App\Http\Resources\v1\Admin\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class A_ShortProductResource extends JsonResource
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
            'name' => $this->localized->name,
            'description' => $this->localized->description,
            'category' => $this->category,
            'part_number' => $this->part_number,
            'image' => $this->image,
            'price' => $this->price,
            'is_original' => (bool) $this->is_original,
            'is_active' => (bool) $this->is_active,
            'variants' => $this->variant ? $this->variant->map(function($variant) {
                return [
                    'id' => encodeString($variant->id),
                    'value' => $variant->value,
                    'category_name' => $variant->variantCategory?->localized?->name,
                    'custom_value' => $variant->custom_value
                ];
            }) : [],
        ];
    }
}
