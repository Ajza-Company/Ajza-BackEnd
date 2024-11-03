<?php

namespace App\Services\Frontend\Auth;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Http\Resources\v1\Frontend\User\F_UserResource;
use App\Models\OtpCode;
use App\Models\User;
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
                return response()->json(errorResponse(message: 'Invalid number detected! Let’s try a different one.'),Response::HTTP_BAD_REQUEST);
            }

            $verificationCode = OtpCode::where(['full_mobile' => $data['full_mobile'], 'code' => $data['code']])->first();

            $now = Carbon::now();
            if (!$verificationCode) {
                return response()->json(errorResponse(message: 'Looks like your OTP didn’t pass the test. Give it another shot!'), Response::HTTP_BAD_REQUEST);
            }elseif($now->isAfter($verificationCode->expires_at)){
                return response()->json(errorResponse(message: 'Your OTP expired, but don’t worry, we’ve got plenty more where that came from!'), Response::HTTP_BAD_REQUEST);
            }

            $user = User::where($data)->first();

            $returnArr = [];
            $token = null;

            if ($user) {
                $returnArr = F_UserResource::make($user);
                $token = $user->createToken('auth_token')->plainTextToken;
            }

            $verificationCode->update([
                'expires_at' => Carbon::now(),
                'is_verified' => true
            ]);

            \DB::commit();
            return response()->json(successResponse(message: SuccessMessagesEnum::VERIFIED, data: $returnArr, token: $token));
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(
                message: ErrorMessageEnum::VERIFY,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
