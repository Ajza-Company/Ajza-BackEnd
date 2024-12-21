<?php

namespace App\Providers;

use App\Repositories\Supplier\Offer\Create\S_CreateOfferInterface;
use App\Repositories\Supplier\Offer\Create\S_CreateOfferRepository;
use App\Repositories\Supplier\Offer\Find\S_FindOfferInterface;
use App\Repositories\Supplier\Offer\Find\S_FindOfferRepository;
use App\Repositories\Supplier\Offer\Insert\S_InsertOfferInterface;
use App\Repositories\Supplier\Offer\Insert\S_InsertOfferRepository;
use App\Repositories\Supplier\Order\Find\S_FindOrderInterface;
use App\Repositories\Supplier\Order\Find\S_FindOrderRepository;
use App\Repositories\Supplier\Store\Create\S_CreateStoreInterface;
use App\Repositories\Supplier\Store\Create\S_CreateStoreRepository;
use App\Repositories\Supplier\Store\Find\S_FindStoreInterface;
use App\Repositories\Supplier\Store\Find\S_FindStoreRepository;
use Illuminate\Support\ServiceProvider;

class S_RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            S_FindStoreInterface::class,
            S_FindStoreRepository::class);

        $this->app->bind(
            S_CreateStoreInterface::class,
            S_CreateStoreRepository::class);

        $this->app->bind(
            S_FindOrderInterface::class,
            S_FindOrderRepository::class);

        $this->app->bind(
            S_CreateOfferInterface::class,
            S_CreateOfferRepository::class);

        $this->app->bind(
            S_InsertOfferInterface::class,
            S_InsertOfferRepository::class);

        $this->app->bind(
            S_FindOfferInterface::class,
            S_FindOfferRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
