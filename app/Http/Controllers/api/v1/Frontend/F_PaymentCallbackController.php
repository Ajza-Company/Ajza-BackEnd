<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class F_PaymentCallbackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        \Log::info('payment callback: '.json_encode($request->all()));
    }
}
