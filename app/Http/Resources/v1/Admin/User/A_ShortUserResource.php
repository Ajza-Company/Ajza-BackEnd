<?php

namespace App\Http\Resources\v1\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class A_ShortUserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'full_mobile' => $this->full_mobile,
            'avatar'=>$this->avatar,
            'orders_count' => $this->whenCounted('orders'),
        ];
    }
}
