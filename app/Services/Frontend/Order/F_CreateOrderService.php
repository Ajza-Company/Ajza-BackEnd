<?php

namespace App\Services\Frontend\Order;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\Store;
use App\Models\User;
use App\Repositories\Frontend\Order\Create\F_CreateOrderInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_CreateOrderService
{
    /**
     * Create a new instance.
     *
     * @param F_CreateOrderInterface $createOrder
     */
    public function __construct(private F_CreateOrderInterface $createOrder)
    {

    }

    /**
     *
     * @param array $data
     * @param User $user
     * @param Store $store
     * @return JsonResponse
     */
    public function create(array $data, User $user, Store $store): JsonResponse
    {
        \DB::beginTransaction();
        try {


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
