<?php

namespace App\Modules\Website\Providers;

use App\Modules\Website\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WebsiteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register middleware alias for multi-language support
        $this->app['router']->aliasMiddleware('website.setLocale', SetLocale::class);

        // Load website routes with web middleware group
        Route::middleware('web')
            ->group(__DIR__.'/../routes/web.php');
    }
}