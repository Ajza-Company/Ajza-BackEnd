<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Models\Product;
use App\Enums\RoleEnum;
use App\Enums\SuccessMessagesEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\Supplier\Product\S_CreateProductService;
use App\Http\Requests\v1\Supplier\Product\StoreProductRequest;
use App\Repositories\Supplier\Store\Find\S_FindStoreInterface;
use App\Http\Resources\v1\Supplier\Product\S_ShortProductResource;
use App\Http\Resources\v1\Supplier\StoreProduct\S_ShortStoreProductResource;
use App\Http\Requests\v1\Supplier\Product\S_UpdateProductRequest;
use App\Http\Requests\v1\Supplier\Product\S_CreateProductRequest;
use App\Repositories\Admin\Product\Find\A_FindProductInterface;
use App\Services\Admin\Product\A_UpdateProductService;
use App\Services\Admin\Product\A_DeleteProductService;
use App\Http\Resources\v1\Admin\Product\A_ShortProductResource;
use App\Services\Admin\Product\A_CreateProductService;
use App\Repositories\Admin\Product\Fetch\A_FetchProductInterface;

class S_ProductController extends Controller
{

    public function __construct(private S_FindStoreInterface $findStore,
                                private A_CreateProductService $createProduct,
                                private A_FetchProductInterface $fetchProduct,
                                private A_UpdateProductService $updateProduct,
                                private A_DeleteProductService $deleteProduct,
                                private A_FindProductInterface $findProduct)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $store_id)
    {
        $store = $this->findStore->find(decodeString($store_id));
        return S_ShortStoreProductResource::collection(
            $store
                ->storeProducts()
                ->whereHas('product.localized')
                ->with(['product' => ['localized']])
                ->filter(\request())
                ->adaptivePaginate());
    }

    public function store(S_CreateProductRequest $request,string $store_id)
    {
        $data = $request->validated();
        $store = $this->findStore->find(decodeString($store_id));
        $category = $store->category->category_id;
        $data['category_id']=$category;
        $data['is_original']=false;
        $data['is_active']=false;

        return $this->createProduct->create($data);
    }

    public function show(string $id)
    {
        $product =  $this->findProduct->find(decodeString($id));

        return A_ShortProductResource::make($product);
    }

    public function update(S_UpdateProductRequest $request, string $id)
    {
        $product =  $this->findProduct->find(decodeString($id));

        return $this->updateProduct->update($request->validated(),$product);
    }

    public function destroy(string $id)
    {
        $product =  $this->findProduct->find(decodeString($id));

        return $this->deleteProduct->delete($product);
    }
}
