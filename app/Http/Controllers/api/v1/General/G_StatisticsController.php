<?php

namespace App\Http\Controllers\api\v1\General;

use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;

class G_StatisticsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $statistics = [
            'stores_count' => Store::count(),
            'users_count' => User::count(),
            'orders_count' => Order::count(),
            'products_count' => Product::count(),
            'orders' => [
                'canceled' => Order::where('status', OrderStatusEnum::CANCELLED)->count(),
                'completed' => Order::where('status', OrderStatusEnum::COMPLETED)->count(),
                'rejected' => Order::where('status', OrderStatusEnum::REJECTED)->count(),
            ]
        ];

        return response()->json([
            'status' => true,
            'message' => 'Statistics retrieved successfully.',
            'data' => $statistics,
        ], 200);
    }
}