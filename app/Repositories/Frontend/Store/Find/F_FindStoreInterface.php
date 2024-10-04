<?php

namespace App\Repositories\Frontend\Store\Find;

interface F_FindStoreInterface
{
    /**
     * Create new resource
     *
     * @param int $id
     * @param array $with
     * @return mixed
     */
    public function find(int $id, array $with = []): mixed;
}
