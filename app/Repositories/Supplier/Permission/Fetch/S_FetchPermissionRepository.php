<?php

namespace App\Repositories\Supplier\Permission\Fetch;

use Spatie\Permission\Models\Permission;

class S_FetchPermissionRepository implements S_FetchPermissionInterface
{
    /**
     * class constructor.
     *
     * @return void
     */
    public function __construct(private Permission $model)
    {
        // ...
    }

    /**
     * @inheritDoc
     */
    public function fetch(): mixed
    {
        return $this->model->select(['id', 'name', 'group_name', 'friendly_name'])
            ->get()
            ->groupBy('group_name')
            ->map(function ($group) {
                return $group->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'friendly_name' => $item->friendly_name,
                    ];
                })->sortBy('name')->values();
            })
            ->sortKeys();
    }
}
