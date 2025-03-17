<?php

use App\Enums\LocationHelperTypesEnum;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Position;

if (!function_exists('locationHelper')) {
    /**
     * Returns decoded Item
     */
    function locationHelper(string $ip): Position|bool|null
    {
        try {
            $location = Location::get($ip);

            if ($location) {
                return $location;
            } else {
                return null;
            }
        } catch (\Exception $ex) {
            return null;
        }

    }
}
