<?php

namespace App\Http\Controllers\api\v1\Admin;

use App\Enums\SuccessMessagesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\CarType\A_CreateCarTypeRequest;
use App\Http\Requests\v1\Admin\CarType\A_UpdateCarTypeRequest;
use App\Http\Resources\v1\Admin\CarType\A_CarTypeResource;
use App\Services\Admin\CarType\A_CreateCarTypeService;
use App\Services\Admin\CarType\A_DeleteCarTypeService;
use App\Services\Admin\CarType\A_UpdateCarTypeService;
use App\Repositories\Admin\CarType\Fetch\A_FetchCarTypeInterface;
use App\Repositories\Admin\CarType\Find\A_FindCarTypeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class A_CarTypeController extends Controller
{
    /**
     * Create a new instance.
     */
    public function __construct(
        private A_CreateCarTypeService $createCarType,
        private A_UpdateCarTypeService $updateCarType,
        private A_DeleteCarTypeService $deleteCarType,
        private A_FetchCarTypeInterface $fetchCarType,
        private A_FindCarTypeInterface $findCarType
    ) {}

    /**
     * Display a listing of car types.
     */
    public function index(): AnonymousResourceCollection
    {
        $carTypes = $this->fetchCarType->fetchCarTypes();
        return A_CarTypeResource::collection($carTypes);
    }

    /**
     * Store a newly created car type.
     */
    public function store(A_CreateCarTypeRequest $request): JsonResponse
    {
        $carType = $this->createCarType->create($request->validated());
        
        return response()->json(
            successResponse(
                message: trans(SuccessMessagesEnum::CREATED),
                data: A_CarTypeResource::make($carType)
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified car type.
     */
    public function show(string $id): JsonResponse
    {
        $carType = $this->findCarType->find(decodeString($id));
        
        return response()->json(
            successResponse(
                data: A_CarTypeResource::make($carType)
            )
        );
    }

    /**
     * Update the specified car type.
     */
    public function update(A_UpdateCarTypeRequest $request, string $id): JsonResponse
    {
        $carType = $this->updateCarType->update(
            decodeString($id),
            $request->validated()
        );
        
        return response()->json(
            successResponse(
                message: trans(SuccessMessagesEnum::UPDATED),
                data: A_CarTypeResource::make($carType)
            )
        );
    }

    /**
     * Remove the specified car type.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->deleteCarType->delete(decodeString($id));
        
        return response()->json(
            successResponse(
                message: trans(SuccessMessagesEnum::DELETED)
            )
        );
    }
}
