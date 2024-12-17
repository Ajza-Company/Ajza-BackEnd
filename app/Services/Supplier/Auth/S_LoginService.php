<?php

namespace App\Services\Supplier\Auth;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Http\Resources\v1\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class S_LoginService
{
    /**
     * @param array $data
     * @return JsonResponse
     */
    public function login(array $data): JsonResponse
    {
        try {
            $data['is_registered'] = true;
            $data['is_active'] = true;

            if (auth()->attempt($data)) {
                $user = auth()->user();
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json(successResponse(message: SuccessMessagesEnum::LOGGEDIN, data: UserResource::make($user), token: $token));
            }

            return response()->json(errorResponse(message: 'The mobile and/or password used for authentication are invalid'), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            return response()->json(errorResponse(message: ErrorMessageEnum::LOGIN, error: $exception->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
