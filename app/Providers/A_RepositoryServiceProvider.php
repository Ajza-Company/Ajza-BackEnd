<?php

namespace App\Providers;

use App\Repositories\Admin\Company\Fetch\A_FetchCompanyInterface;
use App\Repositories\Admin\Company\Fetch\A_FetchCompanyRepository;
use App\Repositories\Admin\User\Fetch\A_FetchUserInterface;
use App\Repositories\Admin\User\Fetch\A_FetchUserRepository;
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
            A_FetchCompanyRepository::class
        );

        $this->app->bind(
            A_FetchUserInterface::class,
            A_FetchUserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
