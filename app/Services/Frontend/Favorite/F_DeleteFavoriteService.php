<?php

namespace App\Services\Frontend\Favorite;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_DeleteFavoriteService
{
    /**
     *
     * @param User $user
     * @param string|null $product_id
     * @return JsonResponse
     */
    public function delete(User $user, ?string $product_id = null): JsonResponse
    {
        try {
            if ($product_id === null) {
                // Remove all favorites for the user
                $user->favorites()->delete();
            } else {
                // Remove specific favorite
                $decoded_product_id = decodeString($product_id);
                $user->favorites->where('product_id', $decoded_product_id)->delete();
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
