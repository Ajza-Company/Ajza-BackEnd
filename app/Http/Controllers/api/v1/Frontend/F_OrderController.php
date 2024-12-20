<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Frontend\Order\F_CreateOrderRequest;
use App\Http\Resources\v1\Frontend\Order\F_OrderResource;
use App\Http\Resources\v1\Frontend\Order\F_ShortOrderResource;
use App\Repositories\Frontend\Order\Find\F_FindOrderInterface;
use App\Repositories\Frontend\Store\Find\F_FindStoreInterface;
use App\Services\Frontend\Order\F_CancelOrderService;
use App\Services\Frontend\Order\F_CreateOrderService;

class F_OrderController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_CreateOrderService $createOrder
     * @param F_FindStoreInterface $findStore
     * @param F_FindOrderInterface $findOrder
     * @param F_CancelOrderService $cancelOrder
     */
    public function __construct(
        private F_CreateOrderService $createOrder,
        private F_FindStoreInterface $findStore,
        private F_FindOrderInterface $findOrder,
        private F_CancelOrderService $cancelOrder)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = auth('api')->user()->orders()->with(['orderProducts' => ['storeProduct']])->adaptivePaginate();
        return F_ShortOrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(F_CreateOrderRequest $request, string $store_id)
    {
        $store = $this->findStore->find(decodeString($store_id));
        return $this->createOrder->create($request->validated(), auth('api')->user(), $store);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $order_id)
    {
        $order = $this->findOrder->find(decodeString($order_id));
        return F_OrderResource::make($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancel(string $order_id)
    {
        $order = $this->findOrder->find(decodeString($order_id));
        return $this->cancelOrder->cancel($order);
    }
}
