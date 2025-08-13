<?php

namespace App\Repositories\Admin\CarType\Fetch;

interface A_FetchCarTypeInterface
{
    /**
     * Fetch car types with pagination and filters.
     *
     * @param bool $paginate
     * @return mixed
     */
    public function fetchCarTypes(bool $paginate = true): mixed;
}
