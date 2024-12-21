<?php

use App\Http\Controllers\api\v1\Frontend\F_AddressController;
use App\Http\Controllers\api\v1\Frontend\F_AuthController;
use App\Http\Controllers\api\v1\Frontend\F_CarBrandController;
use App\Http\Controllers\api\v1\Frontend\F_CarModelController;
use App\Http\Controllers\api\v1\Frontend\F_CarTypeController;
use App\Http\Controllers\api\v1\Frontend\F_CategoryController;
use App\Http\Controllers\api\v1\Frontend\F_FavoriteController;
use App\Http\Controllers\api\v1\Frontend\F_LocaleController;
use App\Http\Controllers\api\v1\Frontend\F_OrderController;
use App\Http\Controllers\api\v1\Frontend\F_ProductController;
use App\Http\Controllers\api\v1\Frontend\F_StoreController;
use App\Http\Controllers\api\v1\Frontend\F_StoreReviewController;
use App\Http\Controllers\api\v1\Frontend\F_WalletController;
use App\Http\Controllers\api\v1\General\G_AreaController;
use App\Http\Controllers\api\v1\General\G_StateController;
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
    Route::middleware(SetLocale::class)->group(function () {
        Route::prefix('cities')->group(function () {
            Route::get('/', G_StateController::class);
            Route::get('{city_id}/areas', G_AreaController::class);
        });
    });
});
