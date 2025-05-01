<?php

namespace App\Http\Resources\v1\Admin\Company;

use App\Http\Resources\v1\Admin\Store\A_ShortStoreResource;
use App\Http\Resources\v1\User\ShortUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class A_ShortCompanyResource extends JsonResource
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
            'name' => $this->localized->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_approved'=> (bool) $this->is_approved,
            'is_active' => (bool) $this->is_active,
            'logo' => getFullUrl($this->logo),
            'stores_count' => $this->whenCounted('stores'),
            'team_count' => $this->whenCounted('usersPivot'),
            'owner' => $this->whenLoaded('user', ShortUserResource::make($this->user)),
            'stores' => $this->whenLoaded('stores', A_ShortStoreResource::collection($this->stores))
        ];
    }
}
