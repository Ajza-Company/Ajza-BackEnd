<?php

namespace App\Filters\General;

use App\Filters\FilterClass;
use App\Filters\General\Filters\StatusFilter;

class SupportChatsFilter extends FilterClass
{
    protected array $filters = [
        'status' => StatusFilter::class
    ];
}