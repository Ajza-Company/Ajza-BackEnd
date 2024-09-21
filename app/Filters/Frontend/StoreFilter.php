<?php

namespace App\Filters\Frontend;

use App\Filters\FilterClass;
use App\Filters\Frontend\Filters\Store\NameFilter;
use App\Filters\Frontend\Filters\Store\StateFilter;

class StoreFilter extends FilterClass
{
    protected array $filters = [
        'name' => NameFilter::class,
        'city' => StateFilter::class
    ];
}
