<?php

namespace App\Models;

use App\Traits\HasLocalized;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    use HasFactory, HasLocalized;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'iso2',
        'emoji',
        'latitude',
        'longitude',
        'numeric_code',
        'phone_code'
    ];

    /**
     *
     * @return HasOne
     */
    public function localized(): HasOne
    {
        return $this->localizedRelation(CountryLocale::class);
    }
}
