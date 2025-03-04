<?php

namespace App\Services\Supplier\Order;

use App\Enums\ErrorMessageEnum;
use App\Enums\OrderStatusEnum;
use App\Events\v1\Supplier\S_AcceptRejectOrderEvent;
use App\Models\Order;
use App\Notifications\OrderNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class S_TakeActionService
{
    /**
     * @param array $data
     * @param Order $order
     * @return JsonResponse
     */
    public function execute(array $data, Order $order): JsonResponse
    {
        DB::beginTransaction();
        try {
           /* if ($order->status !== OrderStatusEnum::PENDING) {
                return response()->json(
                    errorResponse(
                        message: trans(ErrorMessageEnum::CREATE)
                    ),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }*/
            // Update order status
            $newStatus = $data['action'] === 'accept' ? OrderStatusEnum::ACCEPTED : OrderStatusEnum::REJECTED;
            $order->update([
                'status' => $newStatus
            ]);

            $order->refresh();
            broadcast(new S_AcceptRejectOrderEvent($order))->toOthers();

            // Notify customer about order status
            $notificationType = $newStatus === OrderStatusEnum::ACCEPTED ? 'order_accepted' : 'order_rejected';
            $order->user->notify(new OrderNotification(
                order: $order,
                type: $notificationType
            ));

            DB::commit();

            return response()->json(
                successResponse(message: "Order successfully {$newStatus}"),
                Response::HTTP_OK
            );
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json(
                errorResponse(
                    message: ErrorMessageEnum::CREATE,
                    error: $ex->getMessage()
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
