<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Supplier\Store\S_CreateStoreRequest;
use App\Http\Resources\v1\Supplier\Store\S_ShortStoreResource;
use App\Http\Resources\v1\Supplier\Store\S_StoreResource;
use App\Repositories\Supplier\Store\Find\S_FindStoreInterface;
use App\Services\Supplier\Store\S_CreateStoreService;
use Illuminate\Http\Request;

class S_StoreController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param S_CreateStoreService $createStore
     */
    public function __construct(private S_CreateStoreService $createStore, private S_FindStoreInterface $findStore)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return S_ShortStoreResource::collection(
            userCompany()->stores()->with(['company' => ['localized']])->adaptivePaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(S_CreateStoreRequest $request)
    {
        return $this->createStore->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $store_id)
    {
        $store = $this->findStore->find(decodeString($store_id));
        return S_StoreResource::make($store->load('company', 'company.localized'));
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
