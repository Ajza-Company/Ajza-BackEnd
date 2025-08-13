<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasLocalized
{
    /**
     * Define a localized relationship with dynamic model class
     *
     * @param string $relatedModel
     * @return HasOne
     */
    public function localizedRelation(string $relatedModel): HasOne
    {
        // Use a simple approach that should work with existing code
        return $this->hasOne($relatedModel);
    }
}
