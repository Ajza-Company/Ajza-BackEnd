<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarTypeLocale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'car_type_id',
        'name',
        'locale_id'
    ];

    /**
     * Get Contact Numbers
     *
     * @return BelongsTo
     */
    public function Locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }
}
