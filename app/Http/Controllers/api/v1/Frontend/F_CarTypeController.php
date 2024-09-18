<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Frontend\CarType\F_CarTypeResource;
use App\Models\CarType;
use App\Models\User;
use Illuminate\Http\Request;

class F_CarTypeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return F_CarTypeResource::collection(CarType::whereHas('localized')->with(['localized'])->paginate());
    }
}
