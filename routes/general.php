<?php

use App\Http\Controllers\api\v1\Frontend\F_CategoryController;
use App\Http\Controllers\api\v1\General\{G_AreaController,
    G_CancelOrderController,
    G_NotificationController,
    G_RepChatController,
    G_StateController,
    G_ProductController,
    G_TermsController};
use App\Http\Controllers\DeleteAccountController;
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
    Route::get('terms', [G_TermsController::class, 'terms']);
    Route::middleware(SetLocale::class)->group(function () {
        Route::get('delete-account', DeleteAccountController::class);
        Route::get('categories', F_CategoryController::class);
        Route::prefix('cities')->group(function () {
            Route::get('/', G_StateController::class);
            Route::get('{city_id}/areas', G_AreaController::class);
        });
    });
});

Route::prefix('v1')->group(function () {
    Route::middleware(SetLocale::class)->group(function () {
        Route::get('notifications', G_NotificationController::class);
    });
    Route::prefix('orders')->group(function () {
        Route::post('{order_id}/cancel', G_CancelOrderController::class);
    });

    Route::prefix('products')->group(function () {
        Route::get('/{store_id}', G_ProductController::class);
    });

    Route::prefix('rep-orders')->group(function () {
        Route::get('/chats', [G_RepChatController::class, 'index']);
        Route::get('/chats/{chat_id}', [G_RepChatController::class, 'show']);
        Route::get('/chats/{chat_id}/messages', [G_RepChatController::class, 'messages']);
        Route::post('/chats/{chat_id}/messages', [G_RepChatController::class, 'sendMessage']);
        Route::post('/chats/{chat_id}/offers', [G_RepChatController::class, 'sendOffer']);

        // Offer routes
        Route::post('/offers/{offer}/update', [G_RepChatController::class, 'updateOffer']);
    });
});
