<?php

namespace App\Filters\Admin\Filters\User;

use Illuminate\Database\Eloquent\Builder;

class SupportChatUserRoleFilter
{
    /**
     * Filter support chats by user role
     *
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function filter(Builder $builder, string $value): Builder
    {
             
        return $builder->whereHas('user', function ($userQuery) use ($value) {
            $userQuery->whereHas('roles', function ($roleQuery) use ($value) {
                $roleQuery->where('name', 'LIKE', "%{$value}%");
            });
        });
    }
}