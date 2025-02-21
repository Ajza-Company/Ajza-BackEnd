<?php

namespace App\Filters\Supplier;

use App\Filters\FilterClass;
use App\Filters\Supplier\Filters\Orders\TypeFilter;
use App\Filters\Supplier\Filters\RepOrders\StatusFilter;

class RepOrderFilter extends FilterClass
{
    protected array $filters = [
        'status' => StatusFilter::class
    ];
}
