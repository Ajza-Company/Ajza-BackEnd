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
            $data['data']['user_id'] = $user->id;
            $order = $this->createRepOrder->create($data['data']);

            if (isset($data['image'])) {
                $path = uploadFile("rep-orders/repOrder-$order->id", $data['image']);

                // Update File
                $order->update(['image' => $path]);
            }

            return response()->json(successResponse(message: SuccessMessagesEnum::CREATED));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: ErrorMessageEnum::CREATE,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
