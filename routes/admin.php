<?php

use App\Http\Controllers\api\v1\Admin\{
    A_CompanyController,
    A_UserController,
    A_AuthController,
    A_PromoCodeController,
    F_RepSalesController
};
use App\Http\Controllers\api\v1\General\G_TermsController;
use App\Http\Controllers\api\v1\Supplier\S_AuthController;
use App\Http\Controllers\api\v1\Supplier\S_CompanyController;
use App\Http\Controllers\api\v1\Supplier\S_OfferController;
use App\Http\Controllers\api\v1\Supplier\S_OrderController;
use App\Http\Controllers\api\v1\Supplier\S_PermissionController;
use App\Http\Controllers\api\v1\Supplier\S_ProductController;
use App\Http\Controllers\api\v1\Supplier\S_RepOrderController;
use App\Http\Controllers\api\v1\Supplier\S_StatisticsController;
use App\Http\Controllers\api\v1\Supplier\S_StoreController;
use App\Http\Controllers\api\v1\Supplier\S_TeamController;
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

Route::post('terms/{name}/update', [G_TermsController::class, 'updateTerms']);

Route::middleware('guest:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [S_AuthController::class, 'login']);
    });
});

Route::middleware(['auth:sanctum', SetLocale::class])->group(function () {
    Route::get('companies', [A_CompanyController::class, 'index']);
    Route::post('companies', [A_CompanyController::class, 'store']);
    Route::post('rep-sales', [F_RepSalesController::class, 'store']);
    Route::get('users', [A_UserController::class, 'index']);
    Route::prefix('auth')->group(function () {
        Route::get('virtual-login/{user}', [A_AuthController::class, 'loginWithID']);
    });

    Route::apiResource('promo-codes', A_PromoCodeController::class)->except(['update']);

});
