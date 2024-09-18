<?php

namespace App\Services\Frontend\Auth;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\OtpCode;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_VerifyOtpCodeService
{
    /**
     * Verify OTP
     *
     * @param array $data
     *
     * @return JsonResponse
     */
    public function verify(array $data): JsonResponse
    {
        \DB::beginTransaction();
        try {
            if (!isValidPhone($data['full_mobile'])) {
                return response()->json(errorResponse(message: 'Invalid phone number'),Response::HTTP_BAD_REQUEST);
            }

            $verificationCode = OtpCode::where(['full_mobile' => $data['full_mobile'], 'code' => $data['code']])->first();

            $now = Carbon::now();
            if (!$verificationCode) {
                return response()->json(errorResponse(message: 'Your OTP is invalid'), Response::HTTP_BAD_REQUEST);
            }elseif($now->isAfter($verificationCode->expires_at)){
                return response()->json(errorResponse(message: 'Your OTP is expired'), Response::HTTP_BAD_REQUEST);
            }

            $verificationCode->update([
                'expires_at' => Carbon::now(),
                'is_verified' => true
            ]);

            \DB::commit();
            return response()->json(successResponse(message: SuccessMessagesEnum::VERIFIED));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(
                message: ErrorMessageEnum::VERIFY,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
