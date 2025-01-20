<?php

namespace App\Http\Resources\v1\Supplier\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class S_OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->merge(S_ShortOrderResource::make($this)),
            'invoice_details' => $this->whenLoaded('orderProducts', function (){
                return [
                    'amount' => $this->orderProducts->sum('amount'),
                    'discount' => $this->orderProducts->sum('discount'),
                    'delivery_fees' => 10.00,
                    'total' => $this->orderProducts->sum('amount') + 10.00,
                ];
            })
        ];
    }
}
