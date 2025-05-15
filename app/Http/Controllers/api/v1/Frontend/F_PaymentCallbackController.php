<?php

namespace App\Http\Controllers\api\v1\Frontend;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\TransactionAttempt;
use Illuminate\Http\Request;

class F_PaymentCallbackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        \Log::info('payment callback: '.json_encode($request->all()));

        if ($request->has('payment_result')) {
            if ($request->payment_result->response_status == 'A') {
                $transaction = TransactionAttempt::findOrFail(decodeString($request->cart_id));
                $transaction = tap($transaction)->update([
                    'payment_status' => true,
                    'status' => 'paid',
                    'paymob_callback' => json_encode($request->all()),
                    'paymob_transaction_id' => $request->tran_ref
                ]);

                $transaction->order->update([
                    'status' => OrderStatusEnum::ACCEPTED
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Payment completed successfully.',
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Payment failed.',
            ], 400);
        }
        return response()->json([
            'status' => false,
            'message' => 'Error Response',
        ], 400);
    }
}
