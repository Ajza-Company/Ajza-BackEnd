<?php

namespace App\Filters\General\Filters;

use App\Enums\RepOrderStatusEnum;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Builder;

class SupportChatUserRoleFilter
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
        if (in_array($value, RoleEnum::asArray())) {
            return $builder->whereHas('user', function ($q) use ($value) {
                $q->whereHas('roles', fn ($q) => $q->where('name', $value));
            });
        }
        return null;
    }
}
