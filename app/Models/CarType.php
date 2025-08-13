<?php

namespace App\Models;

use App\Traits\HasLocalized;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarType extends Model
{
    use HasFactory, HasLocalized;

    /**
     * Get the localized data for the car type.
     *
     * @return HasOne
     */
    public function localized(): HasOne
    {
        return $this->localizedRelation(CarTypeLocale::class);
    }

    /**
     * Get the users that have this car type.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'car_type_id');
    }
}
