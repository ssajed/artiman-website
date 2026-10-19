
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'پنل مدیریت') | آرتیمان صنعت</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --admin-green: #237747;
            --admin-green-dark: #185b34;
            --admin-green-light: #e8f4ec;
            --admin-bg: #f4f6f5;
            --admin-border: #e1e7e3;
            --admin-text: #26332c;
            --admin-muted: #7b8780;
            --admin-sidebar: #fff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--admin-bg);
            color: var(--admin-text);
            font-family: Vazirmatn, Tahoma, sans-serif;
            font-size: 14px;
        }

        a {
            color: inherit;
        }

        .admin-header {
            min-height: 76px;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            background: #fff;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-brand {
            color: var(--admin-green);
            font-size: 20px;
            font-weight: 800;
            text-decoration: none;
        }

        .admin-subtitle {
            color: var(--admin-muted);
            font-size: 12px;
            margin-top: 5px;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-user-name {
            color: #45534a;
            font-size: 13px;
        }

        .admin-logout {
            border: 1px solid #dce4df;
            background: #fff;
            color: #45534a;
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            font: inherit;
        }

        .admin-logout:hover {
            background: #f8eeee;
            color: #a33434;
        }

        .admin-shell {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            max-width: 1800px;
            margin: 0 auto;
            padding: 20px;
        }

        .dashboard-launcher {
            max-width: 1500px;
        }

        .dashboard-launcher .admin-content {
            width: 100%;
        }

        .dashboard-launcher .admin-main {
            padding: 12px;
            background: transparent;
            border: none;
        }
        .admin-sidebar {
            width: 270px;
            min-width: 270px;
            padding: 14px;
            background: var(--admin-sidebar);
            border: 1px solid var(--admin-border);
            border-radius: 14px;
        }

        .sidebar-heading {
            padding: 8px 10px 14px;
            color: var(--admin-green);
            font-weight: 800;
            font-size: 14px;
            border-bottom: 1px solid #edf0ee;
            margin-bottom: 8px;
        }

        .admin-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .admin-nav-group {
            margin-top: 12px;
        }

        .admin-nav-title {
            padding: 8px 10px;
            color: #89938d;
            font-size: 11px;
            font-weight: 800;
        }

        .admin-nav a,
        .admin-nav .nav-disabled {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            min-height: 39px;
            padding: 9px 11px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            transition: background .15s ease, color .15s ease;
        }

        .admin-nav a {
            color: #45534a;
        }

        .admin-nav a:hover,
        .admin-nav a.active {
            background: var(--admin-green-light);
            color: var(--admin-green);
        }

        .admin-nav a.active {
            font-weight: 800;
            border-right: 3px solid var(--admin-green);
        }

        .nav-disabled {
            color: #a0a8a3;
            cursor: default;
        }

        .nav-badge {
            flex-shrink: 0;
            padding: 3px 6px;
            border-radius: 5px;
            background: #f0f2f1;
            color: #8a948e;
            font-size: 10px;
            font-weight: 500;
        }

        .nav-separator {
            height: 1px;
            margin: 10px 4px;
            background: #edf0ee;
        }

        .admin-content {
            flex: 1;
            min-width: 0;
        }

        .admin-main {
            min-height: 400px;
            padding: 22px;
            background: #fff;
            border: 1px solid var(--admin-border);
            border-radius: 14px;
        }

        .admin-footer {
            padding: 18px 20px 24px;
            text-align: center;
            color: #89938d;
            font-size: 12px;
        }

        .sidebar-site-link {
            display: block;
            margin-top: 14px;
            padding: 11px;
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            text-align: center;
            color: var(--admin-green);
            text-decoration: none;
            font-size: 13px;
        }

        .sidebar-site-link:hover {
            background: var(--admin-green-light);
        }

        @media (max-width: 900px) {
            .admin-shell {
                flex-direction: column;
                padding: 12px;
            }

            .dashboard-launcher {
            max-width: 1500px;
        }

        .dashboard-launcher .admin-content {
            width: 100%;
        }

        .dashboard-launcher .admin-main {
            padding: 12px;
            background: transparent;
            border: none;
        }
        .admin-sidebar {
                width: 100%;
                min-width: 0;
            }

            .admin-nav {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 4px;
            }

            .admin-nav-group {
                margin-top: 8px;
            }

            .admin-main {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .admin-header {
                padding: 13px;
            }

            .admin-nav {
                grid-template-columns: 1fr;
            }

            .admin-user {
                width: 100%;
                justify-content: space-between;
            }
        }
        
        .admin-nav .menu-icon {
            width: 28px;
            height: 28px;
            min-width: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f1f5f2;
            color: #64756a;
            font-size: 16px;
            line-height: 1;
        }

        .admin-nav a.active .menu-icon,
        .admin-nav a:hover .menu-icon {
            background: #d7eadf;
            color: #237747;
        }

        .admin-nav .nav-disabled .menu-icon {
            background: #f6f7f6;
            color: #a0a8a3;
        }

        .admin-nav .menu-label {
            flex: 1;
        }

    </style>
</head>
<body>
    <header class="admin-header">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                آرتیمان صنعت
            </a>
            <div class="admin-subtitle">
                سامانه مدیریت کسب‌وکار
            </div>
        </div>

        <div class="admin-user">
            <span class="admin-user-name">
                {{ auth()->user()?->name ?? 'مدیر سیستم' }}
            </span>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="admin-logout">
                    خروج از حساب
                </button>
            </form>
        </div>
    </header>

    <div class="admin-shell {{ request()->routeIs('admin.dashboard') ? 'dashboard-launcher' : '' }}">
        @unless(request()->routeIs('admin.dashboard'))
        <aside class="admin-sidebar">
            <div class="sidebar-heading">منوی مدیریت</div>

            <nav class="admin-nav">
                <div class="admin-nav-group">
                    <div class="admin-nav-title">مدیریت عمومی</div>

                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                        <span class="menu-label">داشبورد</span>
                    </a>

                    <a href="{{ route('admin.project-progress.index') }}"
                       class="{{ request()->routeIs('admin.project-progress.*') ? 'active' : '' }}">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M8 2v4m8-4v4M3 9h18M7 14h3m4 0h3m-10 4h3" />
                        </svg>
                        <span class="menu-label">پیشرفت پروژه</span>
                    </a>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="8" r="3" />
                            <path d="M3 20v-1a6 6 0 0 1 12 0v1M16 5.5a3 3 0 0 1 0 5.8M18 14a5 5 0 0 1 3 5v1" />
                        </svg>
                        <span class="menu-label">کاربران و سطح دسترسی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 21V5l8-3 8 3v16M2 21h20M8 9h1m6 0h1M8 13h1m6 0h1M10 21v-4h4v4" />
                        </svg>
                        <span class="menu-label">اطلاعات و تنظیمات شرکت</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19V5m0 14h17" />
                            <path d="m7 15 4-4 3 2 6-7" />
                        </svg>
                        <span class="menu-label">گزارش‌های مدیریتی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">فروش و مشتریان</div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 18 18 4m0 0h-7m7 0v7M5 6v13h13" />
                        </svg>
                        <span class="menu-label">سرنخ‌های فروش</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="8" r="3" />
                            <circle cx="18" cy="9" r="2" />
                            <path d="M3 20v-1a6 6 0 0 1 12 0v1m1-5a4 4 0 0 1 5 4v1" />
                        </svg>
                        <span class="menu-label">مشتریان و شرکت‌ها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 18 18 4m0 0h-7m7 0v7M5 6v13h13" />
                        </svg>
                        <span class="menu-label">فرصت‌های فروش</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <path d="m4 7 8 6 8-6" />
                        </svg>
                        <span class="menu-label">استعلام‌های مشتریان</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 3h9l4 4v14H6zM15 3v5h5M9 12h7m-7 4h7" />
                        </svg>
                        <span class="menu-label">پیش‌فاکتورها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 3h9l4 4v14H6zM15 3v5h5M9 12h7m-7 4h7" />
                            <path d="m9 8 2 2 4-4" />
                        </svg>
                        <span class="menu-label">سفارش‌های فروش</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">محصولات و مهندسی</div>

                    <a href="{{ route('admin.products.index') }}"
                       class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m12 3 9 5-9 5-9-5 9-5Z" />
                            <path d="m3 12 9 5 9-5M3 16l9 5 9-5" />
                        </svg>
                        <span class="menu-label">مدیریت محصولات</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                       class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                            <circle cx="8" cy="6" r="1" />
                            <circle cx="8" cy="12" r="1" />
                            <circle cx="8" cy="18" r="1" />
                        </svg>
                        <span class="menu-label">دسته‌بندی محصولات</span>
                    </a>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="5" r="2" />
                            <circle cx="5" cy="19" r="2" />
                            <circle cx="19" cy="19" r="2" />
                            <path d="M12 7v5m0 0-7 5m7-5 7 5" />
                        </svg>
                        <span class="menu-label">ساختار مواد و BOM</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 21V4h12v17M4 21h16M9 8h6m-6 4h6m-6 4h6" />
                        </svg>
                        <span class="menu-label">طراحی برج خنک‌کننده</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 3h9l4 4v14H6zM15 3v5h5M9 12h7m-7 4h7" />
                        </svg>
                        <span class="menu-label">نقشه‌ها و مدارک فنی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">برنامه‌ریزی و تولید</div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="5" width="16" height="16" rx="2" />
                            <path d="M8 3v4m8-4v4M4 10h16m-12 4 2 2 4-4" />
                        </svg>
                        <span class="menu-label">برنامه‌ریزی تولید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="5" y="4" width="14" height="17" rx="2" />
                            <path d="M9 4V2h6v2m-5 6h4m-4 4h6m-6 4h6" />
                        </svg>
                        <span class="menu-label">دستورکارهای تولید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="5" cy="12" r="2" />
                            <circle cx="12" cy="12" r="2" />
                            <circle cx="19" cy="12" r="2" />
                            <path d="M7 12h3m4 0h3" />
                        </svg>
                        <span class="menu-label">ایستگاه‌ها و مراحل تولید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7 12 3l8 4v10l-8 4-8-4V7Z" />
                            <path d="m4 7 8 4 8-4m-8 4v10" />
                        </svg>
                        <span class="menu-label">قطعات فایبرگلاس و سریال</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3v3m0-3 2 2m-2-2-2 2M5 21h14l-2-12H7L5 21Z" />
                            <path d="M12 12l3-2" />
                        </svg>
                        <span class="menu-label">وزن قبل و بعد از تریم</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">خرید و تأمین‌کنندگان</div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="20" r="1" />
                            <circle cx="18" cy="20" r="1" />
                            <path d="M3 4h2l2.5 11h11l2-8H6" />
                        </svg>
                        <span class="menu-label">درخواست‌های خرید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 3h9l4 4v14H6zM15 3v5h5M9 12h7m-7 4h7" />
                            <path d="m9 8 2 2 4-4" />
                        </svg>
                        <span class="menu-label">سفارش‌های خرید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21V8l9-5 9 5v13M2 21h20M7 12h2m6 0h2m-10 4h2m6 0h2m-7 5v-4h4v4" />
                        </svg>
                        <span class="menu-label">تأمین‌کنندگان</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16v16H4zM4 13h4l2 3h4l2-3h4" />
                            <path d="M12 4v7m-3-3 3 3 3-3" />
                        </svg>
                        <span class="menu-label">رسید مواد خریداری‌شده</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">انبار و موجودی</div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 7 12 3l9 4-9 4-9-4Z" />
                            <path d="M3 12l9 4 9-4m-18 5 9 4 9-4M12 11v5" />
                        </svg>
                        <span class="menu-label">موجودی انبارها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16v16H4zM4 13h4l2 3h4l2-3h4" />
                            <path d="M12 11V5m-3 3 3-3 3 3" />
                        </svg>
                        <span class="menu-label">رسید انبار</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 12h15m-6-6 6 6-6 6" />
                            <path d="M5 5v14" />
                        </svg>
                        <span class="menu-label">حواله و مصرف مواد</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 8h15m-5-5 5 5-5 5M20 16H5m5-5-5 5 5 5" />
                        </svg>
                        <span class="menu-label">انتقال بین انبارها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 0 1 15-6l2 2M20 4v4h-4M21 12a9 9 0 0 1-15 6l-2-2m0 4v-4h4" />
                        </svg>
                        <span class="menu-label">گردش کالا و سریال‌ها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">کنترل کیفیت</div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3 20 6v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-3Z" />
                            <path d="m8 12 3 3 5-6" />
                        </svg>
                        <span class="menu-label">کنترل کیفیت ورودی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9" />
                            <path d="m8 12 3 3 5-6M12 3v2" />
                        </svg>
                        <span class="menu-label">کنترل حین تولید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m12 3 9 5-9 5-9-5 9-5Z" />
                            <path d="m3 12 9 5 9-5m-18 5 9 4 9-4m-6-8 2 2 4-4" />
                        </svg>
                        <span class="menu-label">کنترل محصول نهایی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 21V4m0 0h13l-3 4 3 4H5" />
                            <path d="M12 14v3m0 2h.01" />
                        </svg>
                        <span class="menu-label">عدم انطباق و اقدامات اصلاحی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">خدمات و گزارش‌ها</div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 7 7 14m5-9 2-2a5 5 0 0 1 7 7l-2 2M9 15l-2 2a5 5 0 0 1-7-7l2-2" transform="translate(1 1)" />
                            <path d="m5 19 4-4" />
                        </svg>
                        <span class="menu-label">نصب و خدمات پس از فروش</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19V5m0 14h17" />
                            <path d="m7 15 4-4 3 2 6-7" />
                        </svg>
                        <span class="menu-label">گزارش فروش و مشتریان</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19V5m0 14h17" />
                            <path d="m7 15 4-4 3 2 6-7" />
                            <circle cx="18" cy="6" r="2" />
                        </svg>
                        <span class="menu-label">گزارش تولید و کیفیت</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <svg class="menu-icon" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19V5m0 14h17" />
                            <path d="m7 15 4-4 3 2 6-7" />
                            <path d="M7 7h3" />
                        </svg>
                        <span class="menu-label">گزارش خرید و انبار</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>
            </nav>

            <a href="{{ url('/') }}" target="_blank" rel="noopener"
               class="sidebar-site-link">
                مشاهده وب‌سایت
            </a>
        </aside>
        @endunless

        <section class="admin-content">
            <main class="admin-main">
                @yield('content')
            </main>
        </section>
    </div>

    <footer class="admin-footer">
        آرتیمان صنعت — پنل مدیریت کسب‌وکار
    </footer>

    
</body>

</body>
</html>
