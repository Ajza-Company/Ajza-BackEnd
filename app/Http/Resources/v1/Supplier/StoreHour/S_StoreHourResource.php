<?php

namespace App\Http\Resources\v1\Supplier\StoreHour;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class S_StoreHourResource extends JsonResource
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
            'day' => $this->day,
            'open_time' => $this->open_time,
            'close_time' => $this->close_time
        ];
    }
}
