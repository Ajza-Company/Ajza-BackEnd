<?php

namespace App\Services\Frontend\Auth;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Http\Resources\v1\User\UserResource;
use App\Models\User;
use App\Repositories\Frontend\OtpCode\Create\F_CreateOtpCodeInterface;
use App\Services\Frontend\SmsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_SendOtpCodeService
{
    /**
     * Create a new instance.
     *
     * @param SmsService $smsService
     */
    public function __construct(private SmsService $smsService)
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
        \DB::beginTransaction();
        try {
            if (!isValidPhone($data['full_mobile'])) {
                return response()->json(
                    errorResponse(
                        message: trans('validation.invalid_number')),
                    status: Response::HTTP_BAD_REQUEST);
            }

            $isSent = $this->smsService->generateAndSendOTP($data['full_mobile']);

            if (!$isSent) {
                return response()->json(
                    errorResponse(
                        message: trans(ErrorMessageEnum::SEND)),
                    status: Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $user = User::where($data)->first();

            $returnArr = [];

            if ($user) {
                $returnArr['data'] = UserResource::make($user);
            }

            \DB::commit();
            return response()->json(successResponse(message: trans(trans(SuccessMessagesEnum::SENT)), data: $returnArr));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::SEND),
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
