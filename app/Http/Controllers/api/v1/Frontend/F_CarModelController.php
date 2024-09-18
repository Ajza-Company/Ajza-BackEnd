<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Enums\EncodingMethodsEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Frontend\CarModel\F_CarModelResource;
use App\Models\CarModel;
use Illuminate\Http\Request;

class F_CarModelController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $car_brand)
    {
        $car_brand_id = decodeString($car_brand, EncodingMethodsEnum::HASHID);
        return F_CarModelResource::collection(CarModel::whereCarBrandId($car_brand_id)->whereHas('localized')->with(['localized'])->get());
    }
}
