<?php

use App\Http\Controllers\api\v1\Frontend\F_AddressController;
use App\Http\Controllers\api\v1\Frontend\F_AreaController;
use App\Http\Controllers\api\v1\Frontend\F_AuthController;
use App\Http\Controllers\api\v1\Frontend\F_CarBrandController;
use App\Http\Controllers\api\v1\Frontend\F_CarModelController;
use App\Http\Controllers\api\v1\Frontend\F_CarTypeController;
use App\Http\Controllers\api\v1\Frontend\F_CategoryController;
use App\Http\Controllers\api\v1\Frontend\F_FavoriteController;
use App\Http\Controllers\api\v1\Frontend\F_LocaleController;
use App\Http\Controllers\api\v1\Frontend\F_ProductController;
use App\Http\Controllers\api\v1\Frontend\F_StateController;
use App\Http\Controllers\api\v1\Frontend\F_StoreController;
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

Route::group([], function () {
    Route::get('locales', F_LocaleController::class);
    Route::prefix('auth')->group(function () {
        Route::post('send-otp', [F_AuthController::class, 'sendOtp']);
        Route::post('verify-otp', [F_AuthController::class, 'verifyOtp']);
        Route::post('create-account', [F_AuthController::class, 'createAccount']);
        Route::post('setup-account', [F_AuthController::class, 'setupAccount']);
    });

    Route::middleware(SetLocale::class)->group(function () {
        Route::prefix('car-brands')->group(function () {
            Route::get('/', F_CarBrandController::class);
            Route::get('{car_brand}/car-models', F_CarModelController::class);
        });

        Route::get('car-types', F_CarTypeController::class);
        Route::get('categories', F_CategoryController::class);

        Route::prefix('stores')->group(function () {
            Route::controller(F_StoreController::class)->group(function () {
                Route::get('/', '__invoke');
                Route::get('{store_id}/details', 'show');
            });

            Route::get('{store_id}/products', [F_ProductController::class, '__invoke']);
            Route::get('products/{product_id}', [F_ProductController::class, 'show']);
        });

        Route::prefix('cities')->group(function () {
            Route::get('/', F_StateController::class);
            Route::get('{state}/areas', F_AreaController::class);
        });
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('favorites')->group(function () {
        Route::get('/', [F_FavoriteController::class, 'index']);
        Route::post('/', [F_FavoriteController::class, 'store']);
        Route::delete('{product_id?}', [F_FavoriteController::class, 'destroy']);
    });

    Route::prefix('addresses')->group(function () {
        Route::get('/', [F_AddressController::class, 'index']);
        Route::post('/', [F_AddressController::class, 'store']);
        Route::post('{id}', [F_AddressController::class, 'update']);
        Route::delete('{id}', [F_AddressController::class, 'destroy']);
    });

    Route::prefix('auth')->group(function () {
        Route::get('me', [F_AuthController::class, 'me']);
    });

    Route::prefix('user')->group(function () {
        Route::post('setup-account', [F_AuthController::class, 'setupAccount']);
    });
});
