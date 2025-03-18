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
        // Get location from request attributes (set earlier) or cache
        $location = $request->attributes->get('user_location') ?? getUserLocation($request);
        $latitude = $location?->latitude ?? 0;
        $longitude = $location?->longitude ?? 0;
        $distanceAndTime = distanceTimeBetweenTwoLocations($latitude, $longitude, $this->latitude, $this->longitude);
        $localizedDistanceTime = trans('general.distance_time_format', [
            'distance' => $distanceAndTime['distance'],     // Value for :distance
            'distanceUnit' => trans('general.km'),         // Value for :distanceUnit
            'time' => $distanceAndTime['time'],             // Value for :time
            'timeUnit' => trans('general.min'),             // Value for :timeUnit
        ]);
        $localizedDistance = trans('general.distance', [
            'distance' => round($distanceAndTime['distance'], 2),     // Value for :distance
            'distanceUnit' => trans('general.km')
        ]);
        return [
            'id' => encodeString($this->id),
            'name' => $this->company?->localized?->name,
            'rate' => 4.3,
            'image' => $this->image,
            'distanceAndTime' => '',
            // 'address' => $this->area?->localized?->name . ', ' . $this->area?->state?->localized?->name,
            'address' => $localizedDistance,
            'is_open' => true
        ];
    }
}
