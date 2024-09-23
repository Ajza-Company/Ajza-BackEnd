<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (class_exists(TelescopeApplicationServiceProvider::class)) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Request::macro('getPageSize', function ($default = 15) {
            return $this->input('page_size', $default);
        });

        Builder::macro('adaptivePaginate', function ($defaultPageSize = 15) {
            $request = request();
            if ($request->isMethod('GET') && $request->has('page')) {
                return $this->paginate($request->getPageSize($defaultPageSize));
            }
            return $this->get();
        });
    }
}
