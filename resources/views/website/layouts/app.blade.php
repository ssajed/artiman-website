<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    @yield('meta')

    @vite(['resources/css/website.css', 'resources/js/website.js'])

    @yield('styles')
</head>
<body>
    <header>
        @include('website.components.header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('website.components.footer')
    </footer>

    @yield('scripts')
</body>
</html>