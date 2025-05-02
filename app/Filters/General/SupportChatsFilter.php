<?php

namespace App\Filters\General;

use App\Filters\FilterClass;
use App\Filters\General\Filters\SupportChatStatusFilter;

class SupportChatsFilter extends FilterClass
{
    protected array $filters = [
        'status' => SupportChatStatusFilter::class
    ];
}
