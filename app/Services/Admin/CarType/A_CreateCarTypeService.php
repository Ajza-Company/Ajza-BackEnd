<?php

namespace App\Services\Admin\CarType;

use App\Enums\ErrorMessageEnum;
use App\Models\CarType;
use App\Models\CarTypeLocale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

class A_CreateCarTypeService
{
    /**
     * Create a new car type with localization.
     *
     * @param array $data
     * @return CarType
     * @throws Throwable
     */
    public function create(array $data): CarType
    {
        DB::beginTransaction();
        
        try {
            // Create the car type
            $carType = CarType::create();
            
            // Create the localized name
            $carType->locales()->create([
                'locale_id' => $data['locale_id'],
                'name' => $data['name']
            ]);
            
            DB::commit();
            
            return $carType->load('localized.locale');
            
        } catch (Throwable $exception) {
            DB::rollBack();
            
            throw new \Exception(
                trans(ErrorMessageEnum::CREATE),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

