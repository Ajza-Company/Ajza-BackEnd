<?php

namespace App\Filters\Supplier\Filters\Statistics;

use App\Enums\EncodingMethodsEnum;
use Illuminate\Database\Eloquent\Builder;

class DateFilter
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
        return $builder->whereDate('created_at', $value);
    }
}
