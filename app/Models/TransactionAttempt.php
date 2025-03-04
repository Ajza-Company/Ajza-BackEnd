<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionAttempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_status',
        'amount',
        'saved_card_id',
        'paymob_order_id',
        'paymob_transaction_id',
        'paymob_iframe_token',
        'paymob_callback',
        'currency_code',
        'type',
        'order_id'
    ];
}
