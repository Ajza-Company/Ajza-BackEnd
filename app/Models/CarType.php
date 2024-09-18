<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarType extends Model
{
    use HasFactory;

    /**
     *
     * @return HasMany
     */
    public function CarTypeLocales(): HasMany
    {
        return $this->hasMany(CarTypeLocale::class);
    }

    /**
     *
     * @return HasOne
     */
    public function localized(): HasOne
    {
        return $this->hasOne(CarTypeLocale::class)->whereHas('Locale', function ($query) {
            $query->where('locale', app()->getLocale());
        });
    }
}
