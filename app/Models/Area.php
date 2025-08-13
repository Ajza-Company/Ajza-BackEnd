<?php

namespace App\Models;

use App\Traits\HasLocalized;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Area extends Model
{
    use HasFactory, HasLocalized;

    /**
     *
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Define the localized relationship
     *
     * @return HasOne
     */
    public function localized(): HasOne
    {
        // Use the trait method but ensure it works correctly
        return $this->localizedRelation(AreaLocale::class);
    }
}
