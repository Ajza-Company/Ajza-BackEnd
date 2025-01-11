<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class F_HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth('api')->user();
        $notReviewedOrders = $user
            ->orders()
            ->where('status', OrderStatusEnum::COMPLETED)
            ->whereDoesntHave('review')
            ->count();

        $notReadNotifications = $user
            ->notifications()
            ->where('read_at', null)
            ->count();

        return response()->json([
            'data' => [
                'notReviewedOrders' => $notReviewedOrders,
                'notReadNotifications' => $notReadNotifications
            ]
        ]);
    }
}
