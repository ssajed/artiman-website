<?php

declare(strict_types=1);

namespace App\Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register core module services.
     */
    public function register(): void
    {
        // Foundation only. No business logic.
        // No Singleton binding required at this phase.
    }

    /**
     * Bootstrap core module services.
     */
    public function boot(): void
    {
        // Load migrations for the Core module
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}