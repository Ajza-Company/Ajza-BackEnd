<?php

namespace App\Http\Resources\v1\Frontend\AjzaOffer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class F_AjzaOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->merge(F_ShortAjzaOfferResource::make($this)),
            'description' => $this->localized?->description
        ];
    }
}
