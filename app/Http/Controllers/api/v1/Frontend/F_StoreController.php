<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Enums\EncodingMethodsEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Frontend\Store\F_ShortStoreResource;
use App\Http\Resources\v1\Frontend\Store\F_StoreResource;
use App\Repositories\Frontend\Store\Fetch\F_FetchStoreInterface;
use App\Repositories\Frontend\Store\Find\F_FindStoreInterface;
use Illuminate\Http\Request;

class F_StoreController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_FetchStoreInterface $fetchStore
     * @param F_FindStoreInterface $findStore
     */
    public function __construct(private F_FetchStoreInterface $fetchStore, private F_FindStoreInterface $findStore)
    {

    }

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return F_ShortStoreResource::collection(
            $this->fetchStore->fetch(
                with: ['area', 'area.localized', 'area.state', 'area.state.localized'],
                paginate: true
            )
        );
    }

    /**
     * Handle the incoming request.
     */
    public function show(string $store_id)
    {
        $store_id = decodeString($store_id);
        return F_StoreResource::make($this->findStore->find($store_id, with: ['categories']));
    }
}
