<?php

namespace App\Repositories\Admin\VariantCategory\Find;

use App\Models\VariantCategory;

class A_FindVariantCategoryRepository implements A_FindVariantCategoryInterface
{
    /**
     * Create a new instance.
     *
     * @param VariantCategory $model
     */
    public function __construct(private VariantCategory $model)
    {
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): mixed
    {
        return $this->model->findOrFail($id);
    }
}
