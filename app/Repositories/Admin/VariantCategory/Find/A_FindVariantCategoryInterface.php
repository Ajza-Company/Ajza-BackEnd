<?php

namespace App\Repositories\Admin\VariantCategory\Find;

interface A_FindVariantCategoryInterface
{
    /**
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed;
}
