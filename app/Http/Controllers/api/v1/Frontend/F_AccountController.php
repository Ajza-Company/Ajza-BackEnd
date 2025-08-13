<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Frontend\RequestAccountDeletionRequest;
use App\Services\Frontend\Account\F_RequestAccountDeletionService;
use App\Services\Frontend\Account\F_GetAccountDeletionStatusService;
use Illuminate\Http\JsonResponse;

class F_AccountController extends Controller
{
    public function __construct(
        private F_RequestAccountDeletionService $requestDeletionService,
        private F_GetAccountDeletionStatusService $getStatusService
    ) {}

    public function requestDeletion(RequestAccountDeletionRequest $request): JsonResponse
    {
        $user = auth('api')->user();
        return $this->requestDeletionService->request($user, $request->reason);
    }

    public function getDeletionStatus(): JsonResponse
    {
        $user = auth('api')->user();
        return $this->getStatusService->getStatus($user);
    }
}
