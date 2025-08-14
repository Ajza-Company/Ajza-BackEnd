<?php

use Illuminate\Support\Facades\Route;

Route::get('payment/status', function () {
    return 'test';
    return view('welcome');
})->name('payment.status');
