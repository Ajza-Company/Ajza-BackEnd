<?php

namespace App\Repositories\SMS;

interface SMSProviderInterface
{
    public function send(string $to, string $message): bool;
}
