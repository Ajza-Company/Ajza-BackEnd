<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CarBrand extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image'
    ];

    /**
     *
     * @return HasMany
     */
    public function CarBrandLocales(): HasMany
    {
        return $this->hasMany(CarBrandLocale::class);
    }

    /**
     *
     * @return HasOne
     */
    public function localized(): HasOne
    {
        return $this->hasOne(CarBrandLocale::class)->whereHas('Locale', function ($query) {
            $query->where('locale', app()->getLocale());
        });
    }
}
