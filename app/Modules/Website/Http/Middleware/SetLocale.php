<?php

namespace App\Modules\Website\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales (excluding default 'fa').
     */
    private const SUPPORTED_LOCALES = ['en', 'tr', 'ar'];

    /**
     * Default locale when no locale parameter is present.
     */
    private const DEFAULT_LOCALE = 'fa';

    /**
     * Handle an incoming request.
     *
     * Detects and sets the application locale based on the URL parameter.
     * If no locale is provided, defaults to Persian (fa).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if ($locale && in_array($locale, self::SUPPORTED_LOCALES, true)) {
            App::setLocale($locale);
        } else {
            App::setLocale(self::DEFAULT_LOCALE);
        }

        return $next($request);
    }
}