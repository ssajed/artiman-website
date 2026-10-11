<?php

namespace App\Modules\Products\Providers;

use App\Modules\Products\Contracts\ProductCatalogInterface;
use App\Modules\Products\Services\ProductCatalogService;
use Illuminate\Support\ServiceProvider;

class ProductsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductCatalogInterface::class, ProductCatalogService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}