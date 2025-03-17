<?php

use App\Enums\LocationHelperTypesEnum;
use Stevebauman\Location\Facades\Location;

if (!function_exists('locationHelper')) {
    /**
     * Returns decoded Item
     */
    function locationHelper(string $ip): ?string
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
