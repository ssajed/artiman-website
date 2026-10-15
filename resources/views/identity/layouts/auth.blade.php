<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ورود') | آرتیمان صنعت</title>

    @vite(['resources/css/app.css'])

    <style>
        body {
        font-family: 'Vazirmatn', Tahoma, Arial, sans-serif; 
        }

        .auth-background {
            background:
                radial-gradient(ellipse at 10% 10%, rgba(22, 163, 74, .08), transparent 35%),
                #f3f5f4;
        }

        .auth-pattern {
            background-image:
                linear-gradient(rgba(255,255,255,.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .auth-card {
            box-shadow: 0 24px 70px rgba(15, 23, 42, .10);
        }

        .auth-input {
            transition: border-color .2s, box-shadow .2s;
        }

        .auth-input:focus {
            outline: none;
            border-color: #15803d;
            box-shadow: 0 0 0 4px rgba(21, 128, 61, .10);
        }

        .auth-button {
            transition: transform .2s, box-shadow .2s, background-color .2s;
        }

        .auth-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(21, 128, 61, .22);
        }
    </style>
</head>

<body class="auth-background min-h-screen text-slate-800 antialiased">
    @yield('content')
</body>
</html>