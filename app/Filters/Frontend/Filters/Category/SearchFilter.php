<?php

namespace App\Filters\Frontend\Filters\Category;

use Illuminate\Database\Eloquent\Builder;

class SearchFilter
{
    /**
     * Filter Function
     *
     * @param Builder $builder
     * @param $value
     * @return Builder
     */
    public function filter(Builder $builder, $value): Builder
    {
        return $builder->whereHas('localized', function ($query) use ($value) {
            $query->where('name', 'LIKE', "%{$value}%");
        });
    }
}