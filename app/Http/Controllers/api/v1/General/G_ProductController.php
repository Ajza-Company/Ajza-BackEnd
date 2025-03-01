<?php

namespace App\Http\Controllers\api\v1\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\General\Product\G_ProductResource;
use App\Repositories\Supplier\Store\Find\S_FindStoreInterface;
use App\Repositories\Frontend\Product\Fetch\F_FetchProductInterface;

class G_ProductController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_FetchProductInterface $fetchArea
     */
    public function __construct(private F_FetchProductInterface $fetchProduct,
                                private S_FindStoreInterface $findStore)
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(string $store_id, Request $request)
    {
        $store = $this->findStore->find(decodeString($store_id));
        
        $storeProductIds = $store->storeProducts()->pluck('product_id')->toArray();
        
        $allProducts = $this->fetchProduct->fetch();
        
        if ($request->category_id !== null) {
            $decodedCategoryId = decodeString($request->category_id);
            $allProducts = $allProducts->where('category_id', $decodedCategoryId);
        }
        
        return G_ProductResource::collection($allProducts, $storeProductIds);
    }
}
