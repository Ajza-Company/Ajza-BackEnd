<?php

namespace App\Services\Frontend\Auth;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Http\Resources\v1\Frontend\User\F_UserResource;
use App\Repositories\Frontend\User\Create\F_CreateUserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_CreateAccountService
{
    /**
     * Create a new instance.
     *
     * @param F_CreateUserInterface $createAccount
     */
    public function __construct(private F_CreateUserInterface $createAccount)
    {

    }

    /**
     * Send OTP Function
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function create(array $data): JsonResponse
    {
        try {
            if (!isValidPhone($data['full_mobile'])) {
                return response()->json(errorResponse(message: 'Invalid phone number'),Response::HTTP_BAD_REQUEST);
            }

            $user = $this->createAccount->create($data);
            //TODO:: Send Welcome Email
            return response()->json(successResponse(message: SuccessMessagesEnum::CREATED, data: F_UserResource::make($user)));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: ErrorMessageEnum::CREATE,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
