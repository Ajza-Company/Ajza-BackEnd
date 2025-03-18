<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Enums\SuccessMessagesEnum;
use App\Http\Controllers\Controller;
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

    /**
     * Create a new instance.
     *
     * @param A_CreateProductService $createAccount
     */
    public function __construct(
        private A_CreateProductService $createProduct,
        private A_FetchProductInterface $fetchProduct,
        private A_UpdateProductService $updateProduct,
        private A_DeleteProductService $deleteProduct,
        private A_FindProductInterface $findProduct
        )
    {

    }

    public function index()
    {
        return A_ShortProductResource::collection(
            $this->fetchProduct->fetch(with:[
                'variant', 
                'variant.variantCategory', 
                'variant.variantCategory.localized', 
                'localized', 
                'category.localized'
            ])
        );
    }
    
    public function store(S_CreateProductRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user('api');
        $category = $user->store->category->id;
        dd($category);
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
