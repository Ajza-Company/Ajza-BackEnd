<?php

namespace App\Http\Resources\v1\Admin\Slider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class A_ShortSliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        dd($this->getFirstMediaUrl('sliders'));
        return [
            'id' => encodeString($this->id),
            'image' => $this->getFirstMediaUrl('sliders'),
        ];
    }
}
