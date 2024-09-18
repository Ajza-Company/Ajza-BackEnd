<?php

namespace App\Http\Resources\v1\Frontend\User;

use App\Enums\EncodingMethodsEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class F_UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => encodeString($this->id, EncodingMethodsEnum::CRYPT),
            'name' => $this->name,
            'full_mobile' => $this->full_mobile,
            'is_registered' => (bool)$this->is_registered
        ];
    }
}
