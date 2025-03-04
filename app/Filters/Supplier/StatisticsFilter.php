<?php

namespace App\Filters\Supplier;

use App\Filters\FilterClass;
use App\Filters\Supplier\Filters\Statistics\DateFilter;

class StatisticsFilter extends FilterClass
{
    protected array $filters = [
        'date' => DateFilter::class
    ];
}
