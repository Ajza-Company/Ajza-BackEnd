<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Frontend\Product\F_ProductResource;
use App\Http\Resources\v1\Frontend\Product\F_ShortProductResource;
use App\Models\Product;
use App\Models\StoreProduct;
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

        $products = StoreProduct::query()
            ->where('store_id', $decoded_store_id)
            ->whereHas('product.localized')
            ->with(['product' => function ($q) {
                    $q->whereHas('localized')->with(['localized']);
                }, 'favorite' => function ($q) {
                    $q->where('user_id', auth('api')->id());
                }, 'offer', 'store.company.country.localized'])
            ->filter(\request())
            ->adaptivePaginate();

     /*   $products = Product::whereHas('storeProduct', function ($q) use ($decoded_store_id) {
            $q->where('store_id', $decoded_store_id);
        })->whereHas('localized')->with(['localized', 'offer' => function ($q) use ($decoded_store_id) {
            $q->where('store_id', $decoded_store_id);
        }, 'favorite' => function ($q) use ($decoded_store_id) {
            $q->where('user_id', auth('api')->id())->where('store_id', $decoded_store_id);
        }])->filter(\request())->adaptivePaginate();*/

        return F_ShortProductResource::collection($products);
    }

    /**
     * @param string $product_id
     * @return F_ProductResource
     */
    public function show(string $product_id)
    {
        $decoded_store_product_id = decodeString($product_id);

        $product = StoreProduct::whereHas('product.localized')->with(['product' => function ($q) {
            $q->whereHas('localized')->with(['localized']);
        }, 'favorite' => function ($q) {
            $q->where('user_id', auth('api')->id());
        }, 'offer'])->findOrFail($decoded_store_product_id);

        return F_ProductResource::make($product);
    }
}
