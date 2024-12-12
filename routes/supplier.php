<?php

use App\Http\Controllers\api\v1\Frontend\F_FavoriteController;
use App\Http\Controllers\api\v1\Supplier\S_CompanyController;
use App\Http\Controllers\api\v1\Supplier\S_OrderController;
use App\Http\Controllers\api\v1\Supplier\S_StatisticsController;
use App\Http\Controllers\api\v1\Supplier\S_TransactionController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'role:Store Owner,Store Employee'])->group(function () {
    Route::get('store-details', S_CompanyController::class);
    Route::prefix('{store_id}')->group(function () {
        Route::get('transactions', S_TransactionController::class);
        Route::get('statistics', S_StatisticsController::class);
        Route::get('orders', [S_OrderController::class, 'orders']);
        Route::get('orders/{order_id}', [S_OrderController::class, 'orders']);
    });
});
