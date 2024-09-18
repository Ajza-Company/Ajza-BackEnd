<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'car_brand_id'
    ];

    /**
     *
     * @return HasMany
     */
    public function CarModelLocales(): HasMany
    {
        return $this->hasMany(CarModelLocale::class);
    }

    /**
     *
     * @return HasOne
     */
    public function localized(): HasOne
    {
        return $this->hasOne(CarModelLocale::class)->whereHas('Locale', function ($query) {
            $query->where('locale', app()->getLocale());
        });
    }
}
