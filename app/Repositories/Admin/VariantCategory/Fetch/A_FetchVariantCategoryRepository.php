<?php

namespace App\Repositories\Admin\VariantCategory\Fetch;

use App\Models\VariantCategory;
use App\Repositories\Frontend\F_FetchRepository;

class A_FetchVariantCategoryRepository extends F_FetchRepository implements A_FetchVariantCategoryInterface
{
    /**
     * Create a new instance.
     *
     * @param VariantCategory $model
     */
    public function __construct(VariantCategory $model)
    {
        parent::__construct($model);
    }
}