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
            'id' => encodeString($this->id),
            'name' => $this->name,
            'fullMobile' => $this->full_mobile,
            'isRegistered' => (bool)$this->is_registered
        ];
    }
}
