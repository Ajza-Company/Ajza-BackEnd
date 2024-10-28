<?php

namespace App\Services\Frontend\Auth;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Http\Resources\v1\Frontend\User\F_UserResource;
use App\Models\User;
use App\Repositories\Frontend\OtpCode\Create\F_CreateOtpCodeInterface;
use Carbon\Carbon;
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
                return response()->json(errorResponse(message: 'Invalid number detected! Let’s try a different one.'),Response::HTTP_BAD_REQUEST);
            }

            $user = User::where($data)->first();

            $returnArr = [
                'code' => $data['code'],
                'expiresAt' => Carbon::parse($data['expires_at'])->longRelativeToNowDiffForHumans()
            ];

            if ($user) {
                $returnArr['data'] = F_UserResource::make($user);
            }

            $data['code'] = rand(1000, 9999);
            $data['expires_at'] = now()->addMinutes(10);
            $this->createOtp->create($data);

            return response()->json(
                successResponse(
                    message: SuccessMessagesEnum::SENT,
                    data: $returnArr
                )
            );
        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: ErrorMessageEnum::SEND,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
