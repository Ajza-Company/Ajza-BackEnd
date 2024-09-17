<?php

namespace App\Providers;

use App\Repositories\Frontend\OtpCode\Create\F_CreateOtpCodeInterface;
use App\Repositories\Frontend\OtpCode\Create\F_CreateOtpCodeRepository;
use Illuminate\Support\ServiceProvider;

class F_RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            F_CreateOtpCodeInterface::class,
            F_CreateOtpCodeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
