<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website Module Routes
|--------------------------------------------------------------------------
|
| Public website routes for Artiman Sanat.
|
| Multi-language URL structure:
| - Persian (fa): / (no prefix) — default language
| - English (en): /en/...
| - Turkish (tr): /tr/...
| - Arabic (ar): /ar/...
|
| Note: The 'web' middleware group is already applied by WebsiteServiceProvider.
| Only 'website.setLocale' middleware is applied here for locale detection.
|
*/

Route::middleware('website.setLocale')->group(function () {

    /**
     * Define all website routes.
     *
     * @param string $namePrefix Prefix for route names (empty for Persian, 'localized.' for other languages)
     */
    $defineRoutes = function (string $namePrefix = '') {
        // Homepage
        Route::get('/', 'App\Modules\Website\Http\Controllers\HomeController@index')
            ->name($namePrefix . 'website.home');

        // Products
        Route::get('/products', 'App\Modules\Website\Http\Controllers\ProductController@index')
            ->name($namePrefix . 'website.products.index');

        Route::get('/products/{slug}', 'App\Modules\Website\Http\Controllers\ProductController@show')
            ->name($namePrefix . 'website.products.show');

        // Static Pages
        Route::get('/services', 'App\Modules\Website\Http\Controllers\PageController@services')
            ->name($namePrefix . 'website.services');

        Route::get('/about', 'App\Modules\Website\Http\Controllers\PageController@about')
            ->name($namePrefix . 'website.about');

        Route::get('/contact', 'App\Modules\Website\Http\Controllers\PageController@contact')
            ->name($namePrefix . 'website.contact');

        // Inquiry Form (GET only — POST route will be added when InquiryController is ready)
        Route::get('/inquiry/create', 'App\Modules\Website\Http\Controllers\InquiryController@create')
            ->name($namePrefix . 'website.inquiry.create');
    };

    // ========================================
    // Group 1: Persian (no prefix) — default language
    // ========================================
    $defineRoutes();

    // ========================================
    // Group 2: Localized (with prefix) — en, tr, ar
    // ========================================
    Route::group([
        'prefix' => '{locale}',
        'where' => ['locale' => 'en|tr|ar'],
    ], function () use ($defineRoutes) {
        $defineRoutes('localized.');
    });
});