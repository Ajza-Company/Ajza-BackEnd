<?php

namespace App\Http\Resources\v1\Supplier\Team;

use App\Http\Resources\v1\Supplier\Permission\S_ShortPermissionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class S_TeamResource extends JsonResource
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
            'full_mobile' => $this->full_mobile,
            "is_active" => (bool)$this->is_active,
            'permissions' => $this->whenLoaded('permissions', $this->permissions()->pluck('name')->toArray()),
        ];
    }
}
