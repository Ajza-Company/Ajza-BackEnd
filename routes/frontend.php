<?php

use App\Http\Controllers\api\v1\Frontend\F_AreaController;
use App\Http\Controllers\api\v1\Frontend\F_AuthController;
use App\Http\Controllers\api\v1\Frontend\F_CarBrandController;
use App\Http\Controllers\api\v1\Frontend\F_CarModelController;
use App\Http\Controllers\api\v1\Frontend\F_CarTypeController;
use App\Http\Controllers\api\v1\Frontend\F_LocaleController;
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

Route::middleware('guest:sanctum')->group(function () {
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
        Route::get('stores', F_StoreController::class);

        Route::prefix('stores')->controller(F_StoreController::class)->group(function () {
            Route::get('/', '__invoke');
            Route::get('{store_id}/details', 'show');
        });

        Route::prefix('cities')->group(function () {
            Route::get('/', F_StateController::class);
            Route::get('{state}/areas', F_AreaController::class);
        });
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('setup-account', [F_AuthController::class, 'setupAccount']);
    });
});
