<?php

use App\Http\Controllers\api\v1\Frontend\F_AuthController;
use App\Http\Controllers\api\v1\Frontend\F_CarBrandController;
use App\Http\Controllers\api\v1\Frontend\F_CarModelController;
use App\Http\Controllers\api\v1\Frontend\F_CarTypeController;
use App\Http\Controllers\api\v1\Frontend\F_LocaleController;
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
        Route::post('send-otp', [F_AuthController::class, 'sendOtp']);
        Route::post('verify-otp', [F_AuthController::class, 'verifyOtp']);
        Route::post('create-account', [F_AuthController::class, 'createAccount']);
        Route::post('setup-account', [F_AuthController::class, 'setupAccount']);
    });

    Route::prefix('car-brands')->group(function () {
        Route::get('/', F_CarBrandController::class);
        Route::get('{car_brand}/car-models', F_CarModelController::class);
    });

    Route::get('car-types', F_CarTypeController::class);
    Route::get('locales', F_LocaleController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('setup-account', [F_AuthController::class, 'setupAccount']);
    });
});
