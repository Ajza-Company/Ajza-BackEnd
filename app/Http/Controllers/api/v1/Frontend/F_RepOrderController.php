<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Frontend\RepOrder\F_CreateRepOrderRequest;
use App\Http\Resources\v1\Frontend\RepOrder\F_ShortRepOrderResource;
use App\Models\RepOrder;
use App\Services\Frontend\RepOrder\F_CreateRepOrderService;
use Illuminate\Http\Request;

class F_RepOrderController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param F_CreateRepOrderService $createRepOrder
     */
    public function __construct(private F_CreateRepOrderService $createRepOrder)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function createOrder(F_CreateRepOrderRequest $request)
    {
        return $this->createRepOrder->create(auth('api')->user(), $request->validated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function orders()
    {
        return F_ShortRepOrderResource::collection(
            auth('api')->user()->repOrders()->with(['repChats'])->adaptivePaginate()
        );
    }
}
