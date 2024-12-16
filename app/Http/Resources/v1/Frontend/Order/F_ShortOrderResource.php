<?php

namespace App\Http\Resources\v1\Frontend\Order;

use App\Http\Resources\v1\Frontend\OrderProduct\F_ShortOrderProductResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class F_ShortOrderResource extends JsonResource
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
            'status' => $this->status,
            'date' => Carbon::parse($this->created_at)->locale(app()->getLocale())->translatedFormat('d M, Y h:i A'),
            'products' => $this->whenLoaded('orderProducts', F_ShortOrderProductResource::collection($this->orderProducts)),
        ];
    }
}
