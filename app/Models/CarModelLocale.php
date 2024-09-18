<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarModelLocale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'locale_id',
        'name',
        'car_model_id'
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
