<?php

namespace App\Modules\ProjectProgress\Providers;

use Illuminate\Support\ServiceProvider;

class ProjectProgressServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
    }
}
