<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use App\Models\VariantCategory;
use App\Enums\SuccessMessagesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\Variant\F_UpdateVariantRequest;
use App\Http\Requests\v1\Admin\Variant\F_CreateVariantRequest;
use App\Repositories\Admin\VariantCategory\Find\A_FindVariantCategoryInterface;
use App\Services\Admin\VariantCategory\A_UpdateVariantCategoryService;
use App\Services\Admin\VariantCategory\A_DeleteVariantCategoryService;
use App\Http\Resources\v1\Admin\Variant\A_ShortVariantResource;
use App\Services\Admin\VariantCategory\A_CreateVariantCategoryService;
use App\Repositories\Admin\VariantCategory\Fetch\A_FetchVariantCategoryInterface;

class A_VariantCategoryController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param A_CreateVariantCategoryService $createAccount
     */
    public function __construct(
        private A_CreateVariantCategoryService $createVariantCategory,
        private A_FetchVariantCategoryInterface $fetchVariantCategory,
        private A_UpdateVariantCategoryService $updateVariantCategory,
        private A_DeleteVariantCategoryService $deleteVariantCategory,
        private A_FindVariantCategoryInterface $findVariantCategory
        )
    {

    }

    public function index(string $category_id)
    {
        return A_ShortVariantResource::collection(
            $this->fetchVariantCategory->fetch()
        );
    }

    public function store(F_CreateVariantRequest $request)
    {
        return $this->createVariantCategory->create($request->validated());
    }

    public function show(string $id)
    {
        $variant =  $this->findVariantCategory->find(decodeString($id));

        return A_ShortVariantResource::make($variant);
    }

    public function update(F_UpdateVariantRequest $request, string $id)
    {
        $variant =  $this->findVariantCategory->find(decodeString($id));

        return $this->updateVariantCategory->update($request->validated(),$variant);
    }

    public function destroy(string $id)
    {
        $variant =  $this->findVariantCategory->find(decodeString($id));

        return $this->deleteVariantCategory->delete($variant);
    }

}
