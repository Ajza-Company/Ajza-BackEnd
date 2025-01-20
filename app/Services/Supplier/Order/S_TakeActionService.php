<?php

namespace App\Services\Supplier\Order;

use App\Enums\ErrorMessageEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class S_TakeActionService
{
    /**
     *
     * @param array $data
     * @param Order $order
     * @return JsonResponse
     */
    public function execute(array $data, Order $order): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Check if order is in pending state
            /*if ($order->status == OrderStatusEnum::PENDING) {
                return response()->json(errorResponse(
                    message: "Cannot {$data['action']} order. Current status: {$order->status}"),
                    Response::HTTP_UNPROCESSABLE_ENTITY);
            }*/

            // Update order status
            $newStatus = $data['action'] === 'accept' ? OrderStatusEnum::ACCEPTED : OrderStatusEnum::REJECTED;
            $order->update([
                'status' => $newStatus
            ]);

            // Additional actions based on status
            if ($newStatus === 'accepted') {
                // Notify customer
                // $order->user->notify(new OrderStatusChanged($order));

                // You might want to handle inventory here
                // $this->updateInventory($order);
            } else {
                // Handle cancellation
                // You might want to handle refund here
                // $this->handleRefund($order);
            }

            DB::commit();

            return response()->json(successResponse(message: "Order successfully {$data['action']}ed"));
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json(errorResponse(
                message: ErrorMessageEnum::CREATE,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
