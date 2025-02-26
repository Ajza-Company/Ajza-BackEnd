<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Frontend\Wallet\F_ShortWalletResource;
use App\Http\Resources\v1\Frontend\Wallet\F_WalletResource;
use Illuminate\Http\Request;

class F_WalletController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return F_ShortWalletResource::collection(auth('api')->user()->wallet?->transactions()?->latest()->adaptivePaginate())->additional([
            'balance' => auth('api')->user()->wallet?->balance
        ]);
    }
}
