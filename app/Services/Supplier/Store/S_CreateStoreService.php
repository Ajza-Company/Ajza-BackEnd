<?php

namespace App\Services\Supplier\Store;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Repositories\Supplier\Store\Create\S_CreateStoreInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class S_CreateStoreService
{
    /**
     * Create a new instance.
     *
     * @param S_CreateStoreInterface $createStore
     */
    public function __construct(private S_CreateStoreInterface $createStore)
    {

    }

    /**
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function create(array $data): JsonResponse
    {
        try {

            $data['company_id'] = userCompany()->id;
            $this->createStore->create($data);

            return response()->json(successResponse(message: SuccessMessagesEnum::CREATED));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: ErrorMessageEnum::CREATE,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
