<?php

namespace App\Providers;

use App\Repositories\Admin\Company\Fetch\A_FetchCompanyInterface;
use App\Repositories\Admin\Company\Fetch\A_FetchCompanyRepository;
use App\Repositories\Admin\User\Fetch\A_FetchUserInterface;
use App\Repositories\Admin\User\Fetch\A_FetchUserRepository;
use App\Repositories\Admin\RepSales\Fetch\A_FetchRepSalesInterface;
use App\Repositories\Admin\RepSales\Fetch\A_FetchRepSalesRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Frontend\Company\Find\F_FindCompanyInterface;
use App\Repositories\Frontend\Company\Find\F_FindCompanyRepository;
use App\Repositories\Admin\Company\Create\F_CreateCompanyInterface;
use App\Repositories\Admin\Company\Create\F_CreateCompanyRepository;
use App\Repositories\Frontend\Country\Fetch\F_FetchCountryInterface;
use App\Repositories\Frontend\Country\Fetch\F_FetchCountryRepository;
use App\Repositories\Admin\PromoCode\Create\A_CreatePromoCodeInterface;
use App\Repositories\Admin\PromoCode\Create\A_CreatePromoCodeRepository;
use App\Repositories\Admin\PromoCode\Fetch\A_FetchPromoCodeInterface;
use App\Repositories\Admin\PromoCode\Fetch\A_FetchPromoCodeRepository;
use App\Repositories\Admin\PromoCode\Find\A_FindPromoCodeInterface;
use App\Repositories\Admin\PromoCode\Find\A_FindPromoCodeRepository;
use App\Repositories\Admin\Product\Fetch\A_FetchProductInterface;
use App\Repositories\Admin\Product\Fetch\A_FetchProductRepository;
use App\Repositories\Admin\Product\Find\A_FindProductInterface;
use App\Repositories\Admin\Product\Find\A_FindProductRepository;

class A_RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->bind(
            A_FindProductInterface::class,
            A_FindProductRepository::class
        );

        $this->app->bind(
            A_FetchProductInterface::class,
            A_FetchProductRepository::class
        );

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
            A_FetchRepSalesInterface::class,
            A_FetchRepSalesRepository::class
        );

        $this->app->bind(
            F_FetchCountryInterface::class,
            F_FetchCountryRepository::class
        );

        $this->app->bind(
            A_CreatePromoCodeInterface::class,
            A_CreatePromoCodeRepository::class
        );

        $this->app->bind(
            A_FetchPromoCodeInterface::class,
            A_FetchPromoCodeRepository::class
        );

        $this->app->bind(
            A_FindPromoCodeInterface::class,
            A_FindPromoCodeRepository::class
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
