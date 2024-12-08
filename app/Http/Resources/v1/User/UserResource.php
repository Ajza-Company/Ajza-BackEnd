<?php

namespace App\Http\Resources\v1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'fullMobile' => $this->full_mobile,
            'gender' => $this->gender,
            'isRegistered' => (bool)$this->is_registered,
            'role' => $this->whenLoaded('roles', function () {
                return $this->roles->first()->name;
            })
        ];
    }
}
