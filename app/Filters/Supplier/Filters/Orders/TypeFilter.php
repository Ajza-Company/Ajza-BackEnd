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
        if (in_array($value, ['current', 'previous'])) {
            if ($value === 'current') {
                return $builder->whereStatus(OrderStatusEnum::PENDING);
            }elseif ($value === 'previous') {
                return $builder->where('status', '!=', OrderStatusEnum::PENDING);
            }
        }
        return null;
    }
}
