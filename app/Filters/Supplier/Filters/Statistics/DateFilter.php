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
        // Split the comma-separated date string into start_date and end_date
        $dates = explode(',', $value);

        if (count($dates) === 2) {
            [$startDate, $endDate] = $dates;

            // Apply the date range filter
            return $builder->whereBetween('created_at', [
                $startDate,
                $endDate
            ]);
        }

        // Fallback to single date filtering
        return $builder->whereDate('created_at', $value);
    }
}
