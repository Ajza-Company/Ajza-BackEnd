<?php

namespace App\Filters\Frontend\Filters\Product;

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
        $id = decodeString($value);
        return $builder->whereHas('product', function ($q) use ($id) {
            $q->where('category_id', $id);
        });
    }
}
