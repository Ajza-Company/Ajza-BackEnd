<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Supplier\Product\S_ShortProductResource;
use App\Http\Resources\v1\Supplier\StoreProduct\S_ShortStoreProductResource;
use App\Repositories\Supplier\Store\Find\S_FindStoreInterface;
use Illuminate\Http\Request;

class S_ProductController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param S_FindStoreInterface $findStore
     */
    public function __construct(private S_FindStoreInterface $findStore)
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
