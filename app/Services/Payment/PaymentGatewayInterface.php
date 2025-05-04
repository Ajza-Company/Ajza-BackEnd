<?php

namespace App\Services\Payment;

use App\DTOs\PaymentRequestDTO;
use App\DTOs\PaymentResponseDTO;

interface PaymentGatewayInterface
{
    public function createPayment(PaymentRequestDTO $data): PaymentResponseDTO;
    public function verifyPayment(array $data): PaymentResponseDTO;
}
