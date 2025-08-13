<?php

namespace App\Repositories\Admin\CarType\Find;

use App\Models\CarType;
use App\Repositories\Frontend\F_FirstOrCreateRepository;

class A_FindCarTypeRepository extends F_FirstOrCreateRepository implements A_FindCarTypeInterface
{
    /**
     * Create a new instance.
     *
     * @param CarType $model
     */
    public function __construct(CarType $model)
    {
        parent::__construct($model);
    }

    /**
     * Find car type by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        return $this->model
            ->with(['localized.locale'])
            ->findOrFail($id);
    }
}

