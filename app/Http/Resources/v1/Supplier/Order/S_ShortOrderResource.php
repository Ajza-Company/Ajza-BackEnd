<?php

namespace App\Http\Resources\v1\Supplier\Order;

use App\Http\Resources\v1\Supplier\OrderProduct\S_ShortOrderProductResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class S_ShortOrderResource extends JsonResource
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
            'date' => Carbon::parse($this->created_at)->locale(app()->getLocale())->format('d M, Y h:i A'),
            'products' => $this->whenLoaded('orderProducts', S_ShortOrderProductResource::collection($this->orderProducts))
        ];
    }
}
