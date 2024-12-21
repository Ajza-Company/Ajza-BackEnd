<?php

namespace App\Services\Supplier\Store;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class S_UpdateStoreService
{
    /**
     *
     * @param array $data
     * @param Store $store
     * @return JsonResponse
     */
    public function update(array $data, Store $store): JsonResponse
    {
        try {
            $store->update($data);

            return response()->json(successResponse(message: SuccessMessagesEnum::UPDATED));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: ErrorMessageEnum::UPDATE,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
