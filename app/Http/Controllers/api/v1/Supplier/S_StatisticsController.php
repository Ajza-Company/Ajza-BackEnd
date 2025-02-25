<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Http\Controllers\Controller;
use App\Repositories\Supplier\Store\Find\S_FindStoreInterface;
use Illuminate\Http\Request;

class S_StatisticsController extends Controller
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
     * Handle the incoming request.
     */
    public function __invoke(string $store_id)
    {
        $store = $this->findStore->find(decodeString($store_id));
        $orders = $store->orders()->statisticsFilter(\request());
        dd($orders);
        $pendingOrdersCount = $orders?->wherePending()?->count();
        $allOrdersCount = $orders?->count();
        $ordersAmountToday = $orders?->whereToday()?->sum('amount');
        $ajzaAmount = $ordersAmountToday * 0.2;

        return response()->json([
            'pendingOrdersCount' => $pendingOrdersCount,
            'allOrdersCount' => $allOrdersCount,
            'ordersAmountToday' => $ordersAmountToday,
            'ajzaAmount' => $ajzaAmount
        ]);
    }
}
