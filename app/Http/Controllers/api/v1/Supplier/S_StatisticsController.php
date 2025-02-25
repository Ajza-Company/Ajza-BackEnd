<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Http\Controllers\Controller;
use App\Repositories\Supplier\Store\Find\S_FindStoreInterface;
use Carbon\Carbon;
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
        return response()->json($this->calculateStatistics($store));
    }

    /**
     * Calculate store statistics.
     *
     * @param mixed $store
     * @return array
     */
    private function calculateStatistics($store): array
    {
        $orders = $store->orders()->statisticsFilter(request());

        // Base counts
        $allOrdersCount = $orders->count() ?? 0;
        $pendingOrdersCount = $orders->wherePending()->count() ?? 0;

        // Calculate today's orders directly instead of using the scope
        $today = Carbon::today();
        $todayOrders = $orders->whereDate('created_at', $today);
        $ordersAmountToday = $todayOrders->sum('amount') ?? 0;

        // Make sure it's a number before calculation
        $ordersAmountToday = (float)$ordersAmountToday;
        $ajzaAmount = $ordersAmountToday * 0.2;

        return [
            'allOrdersCount' => $allOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'ordersAmountToday' => $ordersAmountToday,
            'ajzaAmount' => $ajzaAmount,
            // For debugging - can be removed in production
            'today' => $today->toDateString(),
            'todayOrdersCount' => $todayOrders->count()
        ];
    }
}
