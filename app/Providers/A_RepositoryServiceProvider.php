<?php

namespace App\Providers;

use App\Repositories\Admin\Company\Fetch\A_FetchCompanyInterface;
use App\Repositories\Admin\Company\Fetch\A_FetchCompanyRepository;
use App\Repositories\Admin\User\Fetch\A_FetchUserInterface;
use App\Repositories\Admin\User\Fetch\A_FetchUserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Frontend\Company\Find\F_FindCompanyInterface;
use App\Repositories\Frontend\Company\Find\F_FindCompanyRepository;
use App\Repositories\Admin\Company\Create\F_CreateCompanyInterface;
use App\Repositories\Admin\Company\Create\F_CreateCompanyRepository;
use App\Repositories\Frontend\Country\Fetch\F_FetchCountryInterface;
use App\Repositories\Frontend\Country\Fetch\F_FetchCountryRepository;

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
            F_CreateCompanyInterface::class,
            F_CreateCompanyRepository::class
        );

        $this->app->bind(
            F_FindCompanyInterface::class,
            F_FindCompanyRepository::class
        );

        $this->app->bind(
            A_FetchUserInterface::class,
            A_FetchUserRepository::class
        );

        $this->app->bind(
        F_FetchCountryInterface::class, 
        F_FetchCountryRepository::class
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
