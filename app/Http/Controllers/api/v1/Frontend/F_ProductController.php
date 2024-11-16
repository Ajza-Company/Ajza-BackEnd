<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Frontend\Product\F_ProductResource;
use App\Http\Resources\v1\Frontend\Product\F_ShortProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class F_ProductController extends Controller
{
    public function __construct()
    {
    }

    /**
     * @param string $store_id
     * @return AnonymousResourceCollection
     */
    public function __invoke(string $store_id)
    {
        $decoded_store_id = decodeString($store_id);

        $products = Product::whereHas('storeProduct', function ($q) use ($decoded_store_id) {
            $q->where('store_id', $decoded_store_id);
        })->whereHas('localized')->with(['localized', 'offer', 'favorites' => function ($q) use ($decoded_store_id) {
            $q->where('user_id', auth('api')->id())->where('store_id', $decoded_store_id);
        }])->filter(\request())->adaptivePaginate();

        return F_ShortProductResource::collection($products);
    }

    /**
     * @param string $store_id
     * @param string $product_id
     * @return F_ProductResource
     */
    public function show(string $store_id, string $product_id)
    {
        $decoded_store_id = decodeString($store_id);
        $decoded_product_id = decodeString($product_id);
        $product = Product::whereHas('storeProduct', function ($q) use ($decoded_store_id) {
            $q->where('store_id', $decoded_store_id);
        })->findOrFail($decoded_product_id);
        return F_ProductResource::make($product);
    }
}
