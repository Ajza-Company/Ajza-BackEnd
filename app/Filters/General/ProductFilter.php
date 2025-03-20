<?php

namespace App\Filters\General;

use App\Filters\FilterClass;
use App\Filters\General\Filters\Product\CategoryFilter;
use App\Filters\General\Filters\Product\NameFilter;

class ProductFilter extends FilterClass
{
    protected array $filters = [
        'name' => NameFilter::class,
        'category' => CategoryFilter::class,
    ];
}
