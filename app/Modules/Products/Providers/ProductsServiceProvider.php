<?php

namespace App\Modules\Products\Providers;

use App\Modules\Products\Contracts\ProductCatalogInterface;
use App\Modules\Products\Services\ProductCatalogService;
use Illuminate\Support\ServiceProvider;

class ProductsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProductCatalogInterface::class,
            ProductCatalogService::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $routesFile = __DIR__ . '/../routes/admin.php';

        if (file_exists($routesFile)) {
            $this->loadRoutesFrom($routesFile);
        }
    }
}
