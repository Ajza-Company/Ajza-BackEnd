<?php

use App\Http\Controllers\api\v1\Frontend\F_FavoriteController;
use App\Http\Controllers\api\v1\Supplier\S_AuthController;
use App\Http\Controllers\api\v1\Supplier\S_CompanyController;
use App\Http\Controllers\api\v1\Supplier\S_OfferController;
use App\Http\Controllers\api\v1\Supplier\S_OrderController;
use App\Http\Controllers\api\v1\Supplier\S_ProductController;
use App\Http\Controllers\api\v1\Supplier\S_StatisticsController;
use App\Http\Controllers\api\v1\Supplier\S_StoreController;
use App\Http\Controllers\api\v1\Supplier\S_TransactionController;
use App\Http\Middleware\SetLocale;
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


Route::middleware('guest:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [S_AuthController::class, 'login']);
    });
});

Route::middleware(['auth:sanctum', SetLocale::class])->group(function () {
    Route::get('store-details', S_CompanyController::class);
    Route::post('orders/{order_id}/take-action', [S_OrderController::class, 'takeAction']);
    Route::prefix('stores')->group(function () {
        Route::get('/', [S_StoreController::class, 'index']);
        Route::post('create', [S_StoreController::class, 'store']);
        Route::prefix('{store_id}')->group(function () {
            Route::post('update', [S_StoreController::class, 'update']);
            Route::get('transactions', S_TransactionController::class);
            Route::get('statistics', S_StatisticsController::class);
            Route::get('orders', [S_OrderController::class, 'orders']);
            Route::get('products', [S_ProductController::class, 'index']);
            Route::get('offers', [S_OfferController::class, 'index']);
            Route::post('offers', [S_OfferController::class, 'store']);
        });
        Route::get('offers/:offer_id', [S_OfferController::class, 'index']);
    });
});
