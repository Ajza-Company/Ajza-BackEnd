<?php

namespace App\Providers;

use App\Repositories\Frontend\Address\Create\F_CreateAddressInterface;
use App\Repositories\Frontend\Address\Create\F_CreateAddressRepository;
use App\Repositories\Frontend\Area\Fetch\F_FetchAreaInterface;
use App\Repositories\Frontend\Area\Fetch\F_FetchAreaRepository;
use App\Repositories\Frontend\CarBrand\Fetch\F_FetchCarBrandInterface;
use App\Repositories\Frontend\CarBrand\Fetch\F_FetchCarBrandRepository;
use App\Repositories\Frontend\CarModel\Fetch\F_FetchCarModelInterface;
use App\Repositories\Frontend\CarModel\Fetch\F_FetchCarModelRepository;
use App\Repositories\Frontend\CarType\Fetch\F_FetchCarTypeInterface;
use App\Repositories\Frontend\CarType\Fetch\F_FetchCarTypeRepository;
use App\Repositories\Frontend\Category\Fetch\F_FetchCategoryInterface;
use App\Repositories\Frontend\Category\Fetch\F_FetchCategoryRepository;
use App\Repositories\Frontend\OtpCode\Create\F_CreateOtpCodeInterface;
use App\Repositories\Frontend\OtpCode\Create\F_CreateOtpCodeRepository;
use App\Repositories\Frontend\Product\Find\F_FindProductInterface;
use App\Repositories\Frontend\Product\Find\F_FindProductRepository;
use App\Repositories\Frontend\ProductFavorite\Create\F_CreateProductFavoriteInterface;
use App\Repositories\Frontend\ProductFavorite\Create\F_CreateProductFavoriteRepository;
use App\Repositories\Frontend\RepOrder\Create\F_CreateRepOrderInterface;
use App\Repositories\Frontend\RepOrder\Create\F_CreateRepOrderRepository;
use App\Repositories\Frontend\State\Fetch\F_FetchStateInterface;
use App\Repositories\Frontend\State\Fetch\F_FetchStateRepository;
use App\Repositories\Frontend\Store\Fetch\F_FetchStoreInterface;
use App\Repositories\Frontend\Store\Fetch\F_FetchStoreRepository;
use App\Repositories\Frontend\Store\Find\F_FindStoreInterface;
use App\Repositories\Frontend\Store\Find\F_FindStoreRepository;
use App\Repositories\Frontend\User\Create\F_CreateUserInterface;
use App\Repositories\Frontend\User\Create\F_CreateUserRepository;
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

        $this->app->bind(
            F_CreateUserInterface::class,
            F_CreateUserRepository::class);

        $this->app->bind(
            F_FetchStoreInterface::class,
            F_FetchStoreRepository::class);

        $this->app->bind(
            F_FetchCarBrandInterface::class,
            F_FetchCarBrandRepository::class);

        $this->app->bind(
            F_FetchCarModelInterface::class,
            F_FetchCarModelRepository::class);

        $this->app->bind(
            F_FetchCarTypeInterface::class,
            F_FetchCarTypeRepository::class);

        $this->app->bind(
            F_FetchStateInterface::class,
            F_FetchStateRepository::class);

        $this->app->bind(
            F_FetchAreaInterface::class,
            F_FetchAreaRepository::class);

        $this->app->bind(
            F_FindStoreInterface::class,
            F_FindStoreRepository::class);

        $this->app->bind(
            F_FindProductInterface::class,
            F_FindProductRepository::class);

        $this->app->bind(
            F_FetchCategoryInterface::class,
            F_FetchCategoryRepository::class);

        $this->app->bind(
            F_CreateProductFavoriteInterface::class,
            F_CreateProductFavoriteRepository::class);

        $this->app->bind(
            F_CreateAddressInterface::class,
            F_CreateAddressRepository::class);

        $this->app->bind(
            F_CreateRepOrderInterface::class,
            F_CreateRepOrderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
