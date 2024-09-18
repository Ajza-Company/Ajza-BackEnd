<?php

namespace App\Services\Frontend\Auth;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Repositories\Frontend\OtpCode\Create\F_CreateOtpCodeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_SendOtpCodeService
{
    /**
     * Create a new instance.
     *
     * @param F_CreateOtpCodeInterface $createOtp
     */
    public function __construct(private F_CreateOtpCodeInterface $createOtp)
    {

    }

    /**
     * Send OTP Function
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function send(array $data): JsonResponse
    {
        try {
            if (!isValidPhone($data['full_mobile'])) {
                return response()->json(errorResponse(message: 'Invalid phone number'),Response::HTTP_BAD_REQUEST);
            }

            $data['code'] = rand(1000, 9999);
            $data['expires_at'] = now()->addMinutes(10);
            $this->createOtp->create($data);

            return response()->json(successResponse(message: SuccessMessagesEnum::SENT, data: ['code' => $data['code']]));
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: ErrorMessageEnum::SEND,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
