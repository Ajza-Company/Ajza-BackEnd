<?php

namespace App\Services\Admin\Account;

use App\Enums\ErrorMessageEnum;
use App\Enums\SuccessMessagesEnum;
use App\Models\AccountDeletionRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class A_ManageAccountDeletionService
{
    public function cancel(int $id): JsonResponse
    {
        try {
            $deletionRequest = AccountDeletionRequest::findOrFail($id);

            if ($deletionRequest->status !== 'pending') {
                return response()->json(errorResponse(
                    message: 'Only pending deletion requests can be cancelled.'
                ), Response::HTTP_BAD_REQUEST);
            }

            $deletionRequest->update([
                'status' => 'cancelled',
                'cancelled_at' => now()
            ]);

            return response()->json(successResponse(
                message: 'Account deletion request cancelled successfully.'
            ));

        } catch (\Exception $ex) {
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::UPDATE),
                error: $ex->getMessage()
            ), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function approve(int $id): JsonResponse
    {
        try {
            $deletionRequest = AccountDeletionRequest::findOrFail($id);

            if ($deletionRequest->status !== 'pending') {
                return response()->json(errorResponse(
                    message: 'Only pending deletion requests can be approved.'
                ), Response::HTTP_BAD_REQUEST);
            }

            $user = $deletionRequest->user;

            DB::beginTransaction();

            $deletionRequest->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);

            $user->delete();

            DB::commit();

            return response()->json(successResponse(
                message: 'Account deleted successfully.'
            ));

        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(errorResponse(
                message: trans(ErrorMessageEnum::DELETE),
                error: $ex->getMessage()
            ), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
