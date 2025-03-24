<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Repositories\Supplier\Store\Find\S_FindStoreInterface;

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
        return response()->json($this->getStatistics($store));
    }

    /**
     * Get store statistics.
     *
     * @param mixed $store
     * @return array
     */
    private function getStatistics(Store $store): array
    {
        return [
            'allOrdersCount' => $this->getAllOrdersCount($store),
            'pendingOrdersCount' => $this->getPendingOrdersCount($store),
            'ordersAmountToday' => $this->getOrdersAmountToday($store),
            'ajzaAmount' => $this->getAjzaAmount($store),
        ];
    }

    /**
     * Get all orders count.
     *
     * @param mixed $store
     * @return int
     */
    private function getAllOrdersCount($store): int
    {
        return $store->orders()->statisticsFilter(request())->count();
    }

    /**
     * Get pending orders count.
     *
     * @param mixed $store
     * @return int
     */
    private function getPendingOrdersCount(Store $store): int
    {
        return $store->orders()->wherePending()->count();
    }

    /**
     * Get orders amount today.
     *
     * @param mixed $store
     * @return float
     */
    private function getOrdersAmountToday(Store $store): float
    {
        return (float) $store->orders()->statisticsFilter(request())->sum('amount');
    }

    /**
     * Get ajza amount.
     *
     * @param mixed $store
     * @return float
     */
    private function getAjzaAmount(Store $store): float
    {
        return $store->orders()->statisticsFilter(request())->get()->sum(function ($order) {
            return $order->amount * ($order->ajza_percentage / 100);
        });
    }
}
