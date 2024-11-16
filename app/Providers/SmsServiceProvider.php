<?php

namespace App\Providers;

use App\Repositories\Services\Messaging\Sms\Send\SmsProvider1;
use App\Services\Frontend\SmsService;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SmsService::class, function ($app) {
            $providers = [
                'provider1' => new SmsProvider1(config('services.sms.provider1'))
            ];

            return new SmsService(
                providers: $providers,
                defaultProvider: config('services.sms.default')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
