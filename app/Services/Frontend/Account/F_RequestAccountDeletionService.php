<?php

namespace App\Services\Frontend\Account;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\AccountDeletionRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_RequestAccountDeletionService
{
    public function request(User $user, ?string $reason = null): JsonResponse
    {
        try {
            $existingRequest = AccountDeletionRequest::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'cancelled'])
                ->first();

            if ($existingRequest) {
                if ($existingRequest->status === 'pending') {
                    return response()->json(errorResponse(
                        message: 'You already have a pending deletion request.'
                    ), Response::HTTP_BAD_REQUEST);
                }

                if ($existingRequest->status === 'cancelled') {
                    $existingRequest->update([
                        'status' => 'pending',
                        'requested_at' => now(),
                        'scheduled_deletion_at' => now()->addDays(15),
                        'reason' => $reason,
                        'cancelled_at' => null
                    ]);

                    return response()->json(successResponse(
                        message: 'Account deletion request reactivated successfully.'
                    ));
                }
            }

            AccountDeletionRequest::create([
                'user_id' => $user->id,
                'requested_at' => now(),
                'scheduled_deletion_at' => now()->addDays(15),
                'status' => 'pending',
                'reason' => $reason
            ]);

            return response()->json(successResponse(
                message: 'Account deletion request submitted successfully. Your account will be deleted in 15 days.'
            ));

        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::CREATE),
                error: $ex->getMessage()
            ), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
