<?php

namespace App\Services\Payment;

use App\DTOs\PaymentRequestDTO;
use App\DTOs\PaymentResponseDTO;

class PaymentService
{

    public function __construct(private PaymentGatewayInterface $gateway)
    {
    }

    public function createPayment(PaymentRequestDTO $data): PaymentResponseDTO
    {
        return $this->gateway->createPayment($data);
    }

    public function verifyPayment(array $data): PaymentResponseDTO
    {
        return $this->gateway->verifyPayment($data);
    }
}
