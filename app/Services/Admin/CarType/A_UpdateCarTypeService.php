<?php

namespace App\Services\Admin\CarType;

use App\Enums\ErrorMessageEnum;
use App\Models\CarType;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class A_UpdateCarTypeService
{
    /**
     * Update the specified car type.
     *
     * @param int $id
     * @param array $data
     * @return CarType
     * @throws Throwable
     */
    public function update(int $id, array $data): CarType
    {
        DB::beginTransaction();
        
        try {
            $carType = CarType::findOrFail($id);
            
            // Update or create the localized name
            $carType->locales()->updateOrCreate(
                ['locale_id' => $data['locale_id']],
                ['name' => $data['name']]
            );
            
            DB::commit();
            
            return $carType->load('localized.locale');
            
        } catch (Throwable $exception) {
            DB::rollBack();
            
            if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                throw new \Exception(
                    'Car type not found',
                    Response::HTTP_NOT_FOUND
                );
            }
            
            throw new \Exception(
                trans(ErrorMessageEnum::UPDATE),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

