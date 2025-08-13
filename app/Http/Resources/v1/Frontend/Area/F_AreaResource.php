<?php

namespace App\Http\Resources\v1\Frontend\Area;

use App\Enums\EncodingMethodsEnum;
use App\Http\Resources\v1\Frontend\State\F_StateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class F_AreaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get the current locale from the app
        $currentLocale = app()->getLocale();
        
        // Get the localized name based on current locale
        $localizedName = null;
        if ($this->localized) {
            // Check if the localized data matches the current locale by locale_id
            // locale_id = 1 is English, locale_id = 2 is Arabic
            if ($currentLocale === 'en' && $this->localized->locale_id === 1) {
                $localizedName = $this->localized->name;
            } elseif ($currentLocale === 'ar' && $this->localized->locale_id === 2) {
                $localizedName = $this->localized->name;
            }
        }
        
        // If no localized name found for current locale, fall back to what exists
        if (!$localizedName && $this->localized) {
            $localizedName = $this->localized->name;
        }
        
        return [
            'id' => encodeString($this->id),
            'name' => $localizedName,
            'city' => $this->whenLoaded('state', function (){
                return F_StateResource::make($this->state);
            })
        ];
    }
}
