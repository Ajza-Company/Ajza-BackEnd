<?php

namespace App\Services\Frontend\Auth;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Http\Resources\v1\User\UserResource;
use App\Models\OtpCode;
use App\Models\User;
use App\Services\Frontend\SmsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_VerifyOtpCodeService
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
     *
     * @param array $data
     * @return JsonResponse
     */
    public function verify(array $data): JsonResponse
    {
        \DB::beginTransaction();
        try {
            if (!isValidPhone($data['full_mobile'])) {
                return response()->json(errorResponse(message: 'Invalid number detected! Let’s try a different one.'),Response::HTTP_BAD_REQUEST);
            }

            $isValid = $this->smsService->verifyOTP($data['full_mobile'], $data['code']);

            if ($isValid) {
                $user = User::where('full_mobile', $data['full_mobile'])->first();

                $returnArr = [];
                $token = null;

                if ($user) {
                    $returnArr = UserResource::make($user);
                    $token = $user->createToken('auth_token')->plainTextToken;
                }

                \DB::commit();
                return response()->json(successResponse(message: SuccessMessagesEnum::VERIFIED, data: $returnArr, token: $token));
            }

            return response()->json(errorResponse(message: ErrorMessageEnum::VERIFY));

        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(errorResponse(
                message: ErrorMessageEnum::VERIFY,
                error: $ex->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
