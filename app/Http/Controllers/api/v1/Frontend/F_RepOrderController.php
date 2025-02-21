<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Enums\ErrorMessageEnum;
use App\Enums\RepOrderStatusEnum;
use App\Enums\SuccessMessagesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Frontend\RepOrder\F_CreateRepOrderRequest;
use App\Http\Resources\v1\Frontend\RepOrder\F_ShortRepOrderResource;
use App\Models\RepOrder;
use App\Services\Frontend\RepOrder\F_CreateRepOrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    /**
     * Store a newly created resource in storage.
     */
    public function checkIfAccepted(string $order_id)
    {
        try {
            $order = RepOrder::findOrFail(decodeString($order_id));

            return response()->json([
                'accepted' => $order->status == RepOrderStatusEnum::ACCEPTED
            ]);
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::CONNECT),
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function cancelOrder(string $order_id)
    {
        try {
            $order = RepOrder::findOrFail(decodeString($order_id));
            $order->update([
                'status' => RepOrderStatusEnum::CANCELLED
            ]);
            return response()->json(successResponse(message: trans(SuccessMessagesEnum::UPDATED)));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::UPDATE),
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     */
    public function orderDelivered(string $order_id)
    {
        try {
            $order = RepOrder::findOrFail(decodeString($order_id));
            $order->update([
                'status' => RepOrderStatusEnum::ENDED
            ]);
            return response()->json(successResponse(message: trans(SuccessMessagesEnum::UPDATED)));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::UPDATE),
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
