<?php

namespace App\Services\Frontend;
use App\Repositories\Services\Messaging\Sms\SmsInterface;
use InvalidArgumentException;

class SmsService
{
    protected array $providers = [];
    protected string $defaultProvider;

    public function __construct(array $providers, string $defaultProvider)
    {
        $this->providers = $providers;
        $this->defaultProvider = $defaultProvider;
    }

    public function send(string $to, ?string $message = null, ?string $provider = null, ?array $options = []): bool
    {
        $provider = $provider ?? $this->defaultProvider;

        if (!isset($this->providers[$provider])) {
            throw new InvalidArgumentException("SMS provider [{$provider}] not configured.");
        }

        return $this->providers[$provider]->send($to, $message, $options);
    }

    public function provider(string $name): SmsInterface
    {
        if (!isset($this->providers[$name])) {
            throw new InvalidArgumentException("SMS provider [{$name}] not configured.");
        }

        return $this->providers[$name];
    }
}
