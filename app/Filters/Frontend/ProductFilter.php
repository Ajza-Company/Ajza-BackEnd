<?php

namespace App\Filters\Frontend;

use App\Filters\FilterClass;
use App\Filters\Frontend\Filters\Product\CategoryFilter;
use App\Filters\Frontend\Filters\Product\OffersFilter;
use App\Filters\Frontend\Filters\Store\NameFilter;
use App\Filters\Frontend\Filters\Store\CityFilter;

class ProductFilter extends FilterClass
{
    protected array $filters = [
        'category' => CategoryFilter::class,
        'has-discount' => OffersFilter::class,
    ];
}
