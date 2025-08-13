<?php

namespace App\Repositories\Admin\CarType\Find;

interface A_FindCarTypeInterface
{
    /**
     * Find car type by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed;
}

