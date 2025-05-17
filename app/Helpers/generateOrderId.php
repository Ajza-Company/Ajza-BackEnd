<?php

use App\Enums\EncodingMethodsEnum;
use App\Models\Order;
use Illuminate\Contracts\Encryption\DecryptException;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Crypt;

if (!function_exists('generateOrderId')) {
    /**
     * Returns decoded Item
     */
    function generateOrderId(string $categoryPrefix): ?string
    {
        // Get current timestamp
        $timestamp = now()->format('YmdHis');

        // Generate a random number between 1000000-9999999
        $random = rand(1000, 9999);

        // Combine prefix, timestamp and random number
        $orderId = '#'. strtoupper($categoryPrefix) . $timestamp . $random;

        // Check if order ID already exists (just to be extra safe)
        while (Order::where('order_id', $orderId)->exists()) {
            $random = rand(1000, 9999);
            $orderId = strtoupper($categoryPrefix) . '_' . $timestamp . $random;
        }

        return $orderId;
    }
}
