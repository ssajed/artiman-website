
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
                        <span>داشبورد</span>
                    </a>

                    <div class="nav-disabled">
                        <span>کاربران و سطح دسترسی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>اطلاعات و تنظیمات شرکت</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>گزارش‌های مدیریتی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">فروش و مشتریان</div>

                    <div class="nav-disabled">
                        <span>سرنخ‌های فروش</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>مشتریان و شرکت‌ها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>فرصت‌های فروش</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>استعلام‌های مشتریان</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>پیش‌فاکتورها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>سفارش‌های فروش</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">محصولات و مهندسی</div>

                    <a href="{{ route('admin.products.index') }}"
                       class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <span>مدیریت محصولات</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                       class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <span>دسته‌بندی محصولات</span>
                    </a>

                    <div class="nav-disabled">
                        <span>ساختار مواد و BOM</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>طراحی برج خنک‌کننده</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>نقشه‌ها و مدارک فنی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">برنامه‌ریزی و تولید</div>

                    <div class="nav-disabled">
                        <span>برنامه‌ریزی تولید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>دستورکارهای تولید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>ایستگاه‌ها و مراحل تولید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>قطعات فایبرگلاس و سریال</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>وزن قبل و بعد از تریم</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">خرید و تأمین‌کنندگان</div>

                    <div class="nav-disabled">
                        <span>درخواست‌های خرید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>سفارش‌های خرید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>تأمین‌کنندگان</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>رسید مواد خریداری‌شده</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">انبار و موجودی</div>

                    <div class="nav-disabled">
                        <span>موجودی انبارها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>رسید انبار</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>حواله و مصرف مواد</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>انتقال بین انبارها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>گردش کالا و سریال‌ها</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">کنترل کیفیت</div>

                    <div class="nav-disabled">
                        <span>کنترل کیفیت ورودی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>کنترل حین تولید</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>کنترل محصول نهایی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>عدم انطباق و اقدامات اصلاحی</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>
                </div>

                <div class="nav-separator"></div>

                <div class="admin-nav-group">
                    <div class="admin-nav-title">خدمات و گزارش‌ها</div>

                    <div class="nav-disabled">
                        <span>نصب و خدمات پس از فروش</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>گزارش فروش و مشتریان</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>گزارش تولید و کیفیت</span>
                        <span class="nav-badge">به‌زودی</span>
                    </div>

                    <div class="nav-disabled">
                        <span>گزارش خرید و انبار</span>
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

    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const icons = [
                { words: ['داشبورد'], icon: '▦' },
                { words: ['کاربران', 'دسترسی'], icon: '♙' },
                { words: ['تنظیمات', 'اطلاعات شرکت'], icon: '⚙' },
                { words: ['گزارش'], icon: '▤' },
                { words: ['سرنخ', 'فرصت فروش', 'فروش'], icon: '↗' },
                { words: ['مشتریان', 'شرکت‌ها'], icon: '♧' },
                { words: ['استعلام'], icon: '✉' },
                { words: ['پیش‌فاکتور'], icon: '▧' },
                { words: ['سفارش'], icon: '▣' },
                { words: ['محصولات'], icon: '◈' },
                { words: ['دسته‌بندی'], icon: '▤' },
                { words: ['BOM', 'مواد'], icon: '⌘' },
                { words: ['طراحی برج'], icon: '⚙' },
                { words: ['نقشه', 'مدارک فنی'], icon: '▧' },
                { words: ['تولید'], icon: '⚒' },
                { words: ['دستورکار'], icon: '☷' },
                { words: ['ایستگاه', 'مراحل تولید'], icon: '⚙' },
                { words: ['فایبرگلاس', 'سریال'], icon: '▦' },
                { words: ['وزن', 'تریم'], icon: '⚖' },
                { words: ['خرید'], icon: '🛒' },
                { words: ['تأمین‌کنندگان'], icon: '♧' },
                { words: ['رسید'], icon: '↓' },
                { words: ['انبار', 'موجودی'], icon: '▣' },
                { words: ['حواله', 'مصرف مواد'], icon: '↗' },
                { words: ['انتقال'], icon: '⇄' },
                { words: ['کیفیت'], icon: '✓' },
                { words: ['عدم انطباق', 'اصلاحی'], icon: '⚑' },
                { words: ['نصب', 'خدمات پس از فروش'], icon: '🔧' },
                { words: ['وب‌سایت'], icon: '◎' }
            ];

            document.querySelectorAll(
                '.admin-nav a, .admin-nav .nav-disabled'
            ).forEach(function (item) {
                if (item.querySelector('.menu-icon')) return;

                const label = item.querySelector('span:not(.nav-badge)');
                if (!label) return;

                const text = label.textContent.trim();
                const match = icons.find(function (entry) {
                    return entry.words.some(function (word) {
                        return text.includes(word);
                    });
                });

                const icon = document.createElement('span');
                icon.className = 'menu-icon';
                icon.setAttribute('aria-hidden', 'true');
                icon.textContent = match ? match.icon : '•';

                item.insertBefore(icon, item.firstChild);
                label.classList.add('menu-label');
            });
        });
    </script>
</body>

</body>
</html>
