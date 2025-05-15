<?php

use App\Http\Controllers\api\v1\Frontend\F_PaymentCallbackController;
use Illuminate\Support\Facades\Route;

Route::get('payment/callback', F_PaymentCallbackController::class)->name('payment.callback');
