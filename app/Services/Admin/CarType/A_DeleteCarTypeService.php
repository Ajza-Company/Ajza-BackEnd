<?php

namespace App\Services\Admin\CarType;

use App\Enums\ErrorMessageEnum;
use App\Models\CarType;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class A_DeleteCarTypeService
{
    /**
     * Delete the specified car type.
     *
     * @param int $id
     * @return void
     * @throws Throwable
     */
    public function delete(int $id): void
    {
        DB::beginTransaction();
        
        try {
            $carType = CarType::findOrFail($id);
            
            // Check if car type is being used by users
            if ($carType->users()->exists()) {
                throw new \Exception(
                    'Cannot delete car type as it is being used by users',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
            
            // Delete the car type (this will cascade to locales)
            $carType->delete();
            
            DB::commit();
            
        } catch (Throwable $exception) {
            DB::rollBack();
            
            if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                throw new \Exception(
                    'Car type not found',
                    Response::HTTP_NOT_FOUND
                );
            }
            
            if ($exception->getCode() === Response::HTTP_UNPROCESSABLE_ENTITY) {
                throw $exception;
            }
            
            throw new \Exception(
                trans(ErrorMessageEnum::DELETE),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

