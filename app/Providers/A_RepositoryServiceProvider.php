<?php

namespace App\Providers;

use App\Repositories\Admin\Company\Fetch\A_FetchCompanyInterface;
use App\Repositories\Admin\Company\Fetch\A_FetchCompanyRepository;
use Illuminate\Support\ServiceProvider;

class A_RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            A_FetchCompanyInterface::class,
            A_FetchCompanyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
