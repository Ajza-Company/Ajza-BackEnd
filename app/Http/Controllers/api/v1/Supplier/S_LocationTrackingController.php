<?php

namespace App\Http\Controllers\api\v1\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Supplier\RepOrder\S_TrackRepOrderRequest;
use App\Services\Supplier\RepOrder\S_TrackRepOrderService;
use Illuminate\Http\Request;
use Throwable;

class S_LocationTrackingController extends Controller
{
    /**
     * Create a new instance.
     *
     * @param S_TrackRepOrderService $trackRepOrder
     */
    public function __construct(private S_TrackRepOrderService $trackRepOrder)
    {

    }

    /**
     * Handle the incoming request.
     * @throws Throwable
     */
    public function __invoke(S_TrackRepOrderRequest $request, string $rep_order_id)
    {
        return $this->trackRepOrder->create($rep_order_id, $request->validated());
    }
}
