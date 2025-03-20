<?php

namespace App\Filters\General\Filters\Product;

use App\Enums\EncodingMethodsEnum;
use Illuminate\Database\Eloquent\Builder;

class CategoryFilter
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
        return $builder->where('category_id', decodeString($value));
    }
}
