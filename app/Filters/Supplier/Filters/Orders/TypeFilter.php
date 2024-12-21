<?php

namespace App\Filters\Supplier\Filters\Orders;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;

class TypeFilter
{
    /**
     * Filter Function
     *
     * @param Builder $builder
     * @param $value
     * @return Builder|null
     */
    public function filter(Builder $builder, $value): ?Builder
    {
        return in_array($value, ['current', 'previous'], true)
            ? $builder->whereStatus($value === 'current' ? OrderStatusEnum::PENDING : '!='.OrderStatusEnum::PENDING)
            : null;
    }
}
