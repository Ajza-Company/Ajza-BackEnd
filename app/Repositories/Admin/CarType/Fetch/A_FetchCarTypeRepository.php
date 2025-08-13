<?php

namespace App\Repositories\Admin\CarType\Fetch;

use App\Models\CarType;
use App\Repositories\Frontend\F_FetchRepository;

class A_FetchCarTypeRepository extends F_FetchRepository implements A_FetchCarTypeInterface
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
     * Fetch car types with pagination and filters.
     *
     * @param bool $paginate
     * @return mixed
     */
    public function fetchCarTypes(bool $paginate = true): mixed
    {
        $query = $this->model
            ->with(['localized.locale'])
            ->filter(request());

        return $paginate ? $query->adaptivePaginate() : $query->get();
    }
}
