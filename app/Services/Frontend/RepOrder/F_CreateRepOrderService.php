<?php

namespace App\Services\Frontend\RepOrder;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\User;
use App\Repositories\Frontend\RepOrder\Create\F_CreateRepOrderInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_CreateRepOrderService
{
    /**
     * Create a new instance.
     *
     * @param F_CreateRepOrderInterface $createRepOrder
     */
    public function __construct(private F_CreateRepOrderInterface $createRepOrder)
    {

    }

    /**
     *
     * @param User $user
     * @param array $data
     *
     * @return JsonResponse
     */
    public function create(User $user, array $data): JsonResponse
    {
        try {
            $order = $this->createRepOrder->create([
                'user_id' => $user->id,
                ...$data['data']
            ]);

            if (isset($data['image'])) {
                $path = uploadFile("rep-orders/repOrder-$order->id", $data['image']);

                // Update File
                $order->update(['image' => $path]);
            }

            return response()->json(successResponse(message: trans(SuccessMessagesEnum::CREATED), data: [
                'id' => encodeString($order->id)
            ]));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::CREATE),
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
