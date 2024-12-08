<?php

namespace App\Repositories\SMS\Providers;

use App\Repositories\SMS\SMSProviderInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class Provider1 implements SMSProviderInterface
{
    /**
     * @throws ConnectionException
     */
    public function send(string $to, string $message): bool
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Authorization' => config('services.sms.provider1.secret'),
            'Content-Type' => 'application/json',
        ])->post(config('services.sms.provider1.url'), [
            'phone' => $to,
            'method' => 'sms',
            'template_id' => 1,
            'otp_format' => 'numeric',
            'number_of_digits' => 4,
            'is_fallback_on' => false
        ]);

        return $this->isResponseSuccessful($response);
    }

    private function isResponseSuccessful($response): bool
    {
        return isset($response->Status) && (string)$response->Status === 'Success';
    }
}
