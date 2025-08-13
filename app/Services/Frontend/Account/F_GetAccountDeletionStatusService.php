<?php

namespace App\Services\Frontend\Account;

use App\Models\AccountDeletionRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class F_GetAccountDeletionStatusService
{
    public function getStatus(User $user): JsonResponse
    {
        try {
            $deletionRequest = AccountDeletionRequest::where('user_id', $user->id)
                ->latest()
                ->first();

            if (!$deletionRequest) {
                return response()->json(successResponse(
                    message: 'No deletion request found.',
                    data: ['has_request' => false]
                ));
            }

            $data = [
                'has_request' => true,
                'status' => $deletionRequest->status,
                'requested_at' => $deletionRequest->requested_at,
                'scheduled_deletion_at' => $deletionRequest->scheduled_deletion_at,
                'reason' => $deletionRequest->reason,
                'days_remaining' => $deletionRequest->status === 'pending' 
                    ? max(0, now()->diffInDays($deletionRequest->scheduled_deletion_at, false))
                    : null
            ];

            return response()->json(successResponse(
                message: 'Deletion request status retrieved successfully.',
                data: $data
            ));

        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: 'Failed to retrieve deletion status.',
                error: $ex->getMessage()
            ), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
