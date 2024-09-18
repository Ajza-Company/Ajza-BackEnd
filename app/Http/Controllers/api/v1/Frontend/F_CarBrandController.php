<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Frontend\CarBrand\F_CarBrandResource;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class F_CarBrandController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return F_CarBrandResource::collection(CarBrand::whereHas('localized')->with(['localized'])->paginate());
    }
}
