<?php

namespace App\Services\Frontend\Order;

use App\Enums\ErrorMessageEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_CancelOrderService
{
    /**
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function cancel(Order $order): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $order->update([
                'status' => OrderStatusEnum::CANCELLED
            ]);
            \DB::commit();
            return response()->json(successResponse(message: SuccessMessagesEnum::CREATED));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(
                message: ErrorMessageEnum::CREATE,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
