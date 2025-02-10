<?php

namespace App\Services\Supplier\RepOrder;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\RepChat;
use App\Repositories\Supplier\RepOrder\Find\S_FindRepOrderInterface;
use Illuminate\Http\JsonResponse;

class S_AcceptRepOrderService
{
    /**
     * Create a new instance.
     *
     * @param S_FindRepOrderInterface $findRepOrder
     */
    public function __construct(private S_FindRepOrderInterface $findRepOrder)
    {

    }

    /**
     * Create a new offer.
     *
     * @param string $rep_order_id
     * @return JsonResponse
     */
    public function execute(string $rep_order_id): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $repOrder = $this->findRepOrder->find(decodeString($rep_order_id));

            RepChat::create([
                'rep_order_id' => $repOrder->id,
                'user1_id' => auth('api')->id(),
                'user2_id' => $repOrder->user_id
            ]);

            \DB::commit();
            return response()->json(successResponse(trans(SuccessMessagesEnum::CREATED)));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(trans(ErrorMessageEnum::CREATE), $ex->getMessage()), 500);
        }
    }
}
