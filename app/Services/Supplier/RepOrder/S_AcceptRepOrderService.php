<?php

namespace App\Services\Supplier\RepOrder;

use App\Enums\ErrorMessageEnum;
use App\Enums\RepOrderStatusEnum;
use App\Enums\SuccessMessagesEnum;
use App\Http\Resources\v1\Supplier\RepOrder\S_ShortRepOrderResource;
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

            if ($repOrder->status != 'pending') {
                return response()->json(errorResponse(trans(trans(ErrorMessageEnum::FOUND))));
            }

            RepChat::create([
                'rep_order_id' => $repOrder->id,
                'user1_id' => auth('api')->id(),
                'user2_id' => $repOrder->user_id
            ]);

            $repOrder->update(['status' => RepOrderStatusEnum::ACCEPTED]);
            $repOrder->refresh();

            \DB::commit();
            return response()->json(successResponse(trans(SuccessMessagesEnum::CREATED), data: S_ShortRepOrderResource::make($repOrder->load('repChat'))));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(trans(ErrorMessageEnum::CREATE), $ex->getMessage()), 500);
        }
    }
}
