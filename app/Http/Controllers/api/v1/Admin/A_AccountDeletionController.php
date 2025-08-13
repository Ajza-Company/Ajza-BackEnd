<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountDeletionRequest;
use App\Services\Admin\Account\A_ManageAccountDeletionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class A_AccountDeletionController extends Controller
{
    public function __construct(
        private A_ManageAccountDeletionService $manageDeletionService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $perPage = $request->get('per_page', 15);

        $query = AccountDeletionRequest::with(['user:id,name,email,full_mobile'])
            ->latest();

        if ($status && in_array($status, ['pending', 'cancelled', 'completed'])) {
            $query->where('status', $status);
        }

        $deletionRequests = $query->paginate($perPage);

        return response()->json(successResponse(
            message: 'Account deletion requests retrieved successfully.',
            data: $deletionRequests
        ));
    }

    public function show(string $id): JsonResponse
    {
        $deletionRequest = AccountDeletionRequest::with(['user:id,name,email,full_mobile,created_at'])
            ->findOrFail(decodeString($id));

        return response()->json(successResponse(
            message: 'Account deletion request details retrieved successfully.',
            data: $deletionRequest
        ));
    }

    public function cancel(string $id): JsonResponse
    {
        return $this->manageDeletionService->cancel(decodeString($id));
    }

    public function approve(string $id): JsonResponse
    {
        return $this->manageDeletionService->approve(decodeString($id));
    }
}
