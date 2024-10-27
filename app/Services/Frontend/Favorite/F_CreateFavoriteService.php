<?php

namespace App\Services\Frontend\Favorite;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\User;
use App\Repositories\Frontend\ProductFavorite\Create\F_CreateProductFavoriteInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_CreateFavoriteService
{
    /**
     * Create a new instance.
     *
     * @param F_CreateProductFavoriteInterface $createProductFavorite
     */
    public function __construct(private F_CreateProductFavoriteInterface $createProductFavorite)
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
            $data['user_id'] = $user->id;
            $this->createProductFavorite->create($data, $data);

            return response()->json(successResponse(message: SuccessMessagesEnum::CREATED));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: ErrorMessageEnum::CREATE,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
