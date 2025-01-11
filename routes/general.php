<?php

use App\Http\Controllers\api\v1\General\G_AreaController;
use App\Http\Controllers\api\v1\General\G_CancelOrderController;
use App\Http\Controllers\api\v1\General\G_NotificationController;
use App\Http\Controllers\api\v1\General\G_RepChatController;
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

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::middleware(SetLocale::class)->group(function () {
        Route::get('notifications', G_NotificationController::class);
    });
    Route::prefix('orders')->group(function () {
        Route::post('{order_id}/cancel', G_CancelOrderController::class);
    });
    Route::prefix('rep-orders')->group(function () {
        Route::get('/chats', [G_RepChatController::class, 'index']);
        Route::get('/chats/{chat_id}', [G_RepChatController::class, 'show']);
        Route::get('/chats/{chat_id}/messages', [G_RepChatController::class, 'messages']);
        Route::post('/chats/{chat_id}/messages', [G_RepChatController::class, 'sendMessage']);
        Route::post('/chats/{chat_id}/offers', [G_RepChatController::class, 'sendOffer']);

        // Offer routes
        Route::post('/offers/{offer}', [G_RepChatController::class, 'updateOffer']);
    });
});
