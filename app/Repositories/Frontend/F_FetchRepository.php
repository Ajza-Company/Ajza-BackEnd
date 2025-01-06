<?php

namespace App\Repositories\Frontend;

class F_FetchRepository
{
    /**
     * Create a new instance.
     *
     * @param $model
     */
    public function __construct(protected $model)
    {

    }

    /**
     *
     * @param array|null $data
     * @param bool $paginate
     * @param array|null $with
     * @param bool $isLocalized
     * @return mixed
     */
    public function fetch(array $data = null, bool $paginate = true, array $with = null, bool $isLocalized = true): mixed
    {
        $query = $this->model->query();

        if ($isLocalized) {
            $query->whereHas('localized')->with('localized');
        }

        if ($data) {
            $query->where($data);
        }

        if (\request()->query() && method_exists($this->model, 'scopeFilter')) {
            $query->filter(\request());
        }

        if ($with) {
            $query->with($with);
        }

        if ($paginate) {
            return $query->adaptivePaginate();
        }

        return $query->get();
    }
}
