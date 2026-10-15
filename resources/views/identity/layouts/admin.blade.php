<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'پنل مدیریت') | آرتیمان صنعت</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-800">
    <header class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
            <a href="{{ route('admin.dashboard') }}" class="font-bold text-green-700">
                آرتیمان صنعت
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg border border-gray-300 px-3 py-2 text-sm hover:bg-gray-50">
                        خروج
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="mx-auto grid max-w-7xl gap-6 px-4 py-6 md:grid-cols-[220px_1fr]">
        <aside class="rounded-xl border border-gray-200 bg-white p-4">
            <p class="mb-3 text-xs font-semibold text-gray-500">مدیریت</p>
            <a href="{{ route('admin.dashboard') }}" class="block rounded-lg bg-green-50 px-3 py-2 font-medium text-green-800">
                داشبورد
            </a>
        </aside>

        <main class="min-w-0">
            @yield('content')
        </main>
    </div>
</body>
</html>