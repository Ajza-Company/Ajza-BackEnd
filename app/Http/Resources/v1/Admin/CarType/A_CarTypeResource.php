<?php

namespace App\Http\Resources\v1\Admin\CarType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class A_CarTypeResource extends JsonResource
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
            'name' => $this->localized->name ?? null,
            'locale' => [
                'id' => $this->localized->locale_id ?? null,
                'code' => $this->localized->locale->locale ?? null,
                'name' => $this->localized->locale->name ?? null
            ],
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s')
        ];
    }
}

