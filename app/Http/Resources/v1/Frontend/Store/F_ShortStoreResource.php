<?php

namespace App\Http\Resources\v1\Frontend\Store;

use App\Enums\EncodingMethodsEnum;
use App\Http\Resources\v1\Frontend\Area\F_AreaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class F_ShortStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $distanceAndTime = distanceTimeBetweenTwoLocations(74.577869,80.080555, $this->latitude, $this->longitude);
        $localizedDistanceTime = trans('general.distance_time_format', [
            'distance' => $distanceAndTime['distance'],     // Value for :distance
            'distanceUnit' => trans('general.km'),         // Value for :distanceUnit
            'time' => $distanceAndTime['time'],             // Value for :time
            'timeUnit' => trans('general.min'),             // Value for :timeUnit
        ]);
        return [
            'id' => encodeString($this->id, EncodingMethodsEnum::HASHID),
            'name' => $this->localized?->name,
            'image' => $this->image,
            'distanceAndTime' => $localizedDistanceTime,
            'address' => $this->area?->localized?->name . ', ' . $this->area?->state?->localized?->name
        ];
    }
}
