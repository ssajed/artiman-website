@extends('admin.layouts.app')

@section('title', 'داشبورد مدیریت')

@section('content')
<style>
    .artiman-launcher {
        --launcher-green: #237747;
        --launcher-green-dark: #185b34;
        --launcher-green-soft: #eaf4ed;
        --launcher-ink: #26332c;
        --launcher-muted: #748078;
        --launcher-border: #e3eae5;
        --launcher-surface: #fff;
        direction: rtl;
        display: grid;
        gap: 30px;
        color: var(--launcher-ink);
        font-family: Vazirmatn, Tahoma, sans-serif;
    }

    .artiman-launcher *,
    .artiman-launcher *::before,
    .artiman-launcher *::after {
        box-sizing: border-box;
    }

    .artiman-launcher [hidden] {
        display: none !important;
    }

    .launcher-hero {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(270px, 390px);
        align-items: center;
        gap: 34px;
        overflow: hidden;
        padding: clamp(25px, 4vw, 42px);
        border: 1px solid #dce9df;
        border-radius: 24px;
        background:
            radial-gradient(circle at 95% 12%, rgba(63, 139, 87, .11), transparent 30%),
            linear-gradient(115deg, #fff 35%, #f6faf7);
        box-shadow: 0 12px 32px rgba(32, 71, 45, .055);
    }

    .launcher-hero::after {
        position: absolute;
        right: -70px;
        bottom: -180px;
        width: 300px;
        height: 300px;
        border: 1px solid rgba(35, 119, 71, .08);
        border-radius: 50%;
        box-shadow: 0 0 0 28px rgba(35, 119, 71, .025), 0 0 0 58px rgba(35, 119, 71, .02);
        content: "";
        pointer-events: none;
    }

    .launcher-hero-copy,
    .launcher-search-card {
        position: relative;
        z-index: 1;
    }

    .launcher-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 13px;
        color: var(--launcher-green);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .01em;
    }

    .launcher-eyebrow svg {
        width: 17px;
        height: 17px;
    }

    .launcher-title {
        margin: 0;
        color: #20392a;
        font-size: clamp(24px, 3vw, 34px);
        font-weight: 850;
        letter-spacing: -.035em;
        line-height: 1.55;
    }

    .launcher-intro {
        max-width: 660px;
        margin: 8px 0 0;
        color: #6f7c73;
        font-size: 13px;
        line-height: 2;
    }

    .launcher-trust-line {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-top: 20px;
        color: #5b6c60;
        font-size: 11px;
        font-weight: 650;
    }

    .launcher-trust-mark {
        display: inline-grid;
        width: 24px;
        height: 24px;
        place-items: center;
        border: 1px solid #d4e7d9;
        border-radius: 8px;
        background: #f2f8f3;
        color: var(--launcher-green);
    }

    .launcher-trust-mark svg {
        width: 14px;
        height: 14px;
    }

    .launcher-search-card {
        padding: 19px;
        border: 1px solid rgba(218, 230, 221, .9);
        border-radius: 17px;
        background: rgba(255, 255, 255, .92);
        box-shadow: 0 8px 22px rgba(37, 78, 49, .045);
        backdrop-filter: blur(8px);
    }

    .launcher-search-label {
        display: block;
        margin-bottom: 9px;
        color: #3a4b40;
        font-size: 12px;
        font-weight: 800;
    }

    .launcher-search-wrap {
        position: relative;
    }

    .launcher-search-icon {
        position: absolute;
        top: 50%;
        right: 13px;
        width: 18px;
        height: 18px;
        color: #87958b;
        pointer-events: none;
        transform: translateY(-50%);
    }

    .launcher-search {
        width: 100%;
        min-height: 48px;
        padding: 11px 42px 11px 13px;
        border: 1px solid #dfe7e1;
        border-radius: 11px;
        outline: none;
        background: #fbfcfb;
        color: var(--launcher-ink);
        font: inherit;
        font-size: 12px;
        transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
    }

    .launcher-search::placeholder {
        color: #9aa49d;
    }

    .launcher-search:focus {
        border-color: #64a579;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(35, 119, 71, .11);
    }

    .launcher-search-hint {
        margin: 9px 2px 0;
        color: #89958d;
        font-size: 10px;
        line-height: 1.8;
    }

    .launcher-section {
        min-width: 0;
    }

    .launcher-section-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        margin: 0 0 14px;
    }

    .launcher-section-symbol {
        display: inline-grid;
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        place-items: center;
        border: 1px solid #e1e9e3;
        border-radius: 11px;
        background: #fff;
        color: var(--launcher-green);
        box-shadow: 0 3px 9px rgba(35, 80, 49, .035);
    }

    .launcher-section-symbol svg {
        width: 18px;
        height: 18px;
    }

    .launcher-section-title {
        margin: 0;
        color: #314238;
        font-size: 15px;
        font-weight: 850;
        line-height: 1.7;
    }

    .launcher-section-caption {
        margin: 1px 0 0;
        color: #87938b;
        font-size: 10px;
        line-height: 1.7;
    }

    .launcher-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 220px), 1fr));
        gap: 13px;
    }

    .launcher-card {
        position: relative;
        display: grid;
        grid-template-columns: 48px minmax(0, 1fr) auto;
        align-items: start;
        gap: 12px;
        min-height: 112px;
        padding: 17px 16px;
        overflow: hidden;
        border: 1px solid var(--launcher-border);
        border-radius: 15px;
        background: var(--launcher-surface);
        color: var(--launcher-ink);
        text-decoration: none;
        transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease, background .18s ease;
    }

    .launcher-card::before {
        position: absolute;
        inset: 0 0 0 auto;
        width: 3px;
        background: #dfe7e1;
        content: "";
        transition: background .18s ease;
    }

    a.launcher-card:hover {
        transform: translateY(-3px);
        border-color: #b8d5c0;
        background: #fefffe;
        box-shadow: 0 10px 24px rgba(31, 82, 48, .09);
        color: var(--launcher-ink);
    }

    a.launcher-card:hover::before,
    a.launcher-card:focus-visible::before {
        background: var(--launcher-green);
    }

    .launcher-card:focus-visible {
        outline: 3px solid rgba(35, 119, 71, .38);
        outline-offset: 3px;
    }

    .launcher-card.is-upcoming {
        background: #fbfcfb;
        color: #4e5b53;
    }

    .launcher-icon {
        display: inline-grid;
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        place-items: center;
        border: 1px solid #dceade;
        border-radius: 13px;
        background: #edf6ef;
        color: var(--launcher-green);
    }

    .launcher-icon svg {
        width: 22px;
        height: 22px;
    }

    .launcher-card.is-upcoming .launcher-icon {
        border-color: #e5e9e6;
        background: #f2f4f2;
        color: #7b8980;
    }

    .launcher-card-copy {
        min-width: 0;
        padding-top: 2px;
    }

    .launcher-card-title {
        display: block;
        color: inherit;
        font-size: 12px;
        font-weight: 850;
        line-height: 1.85;
    }

    .launcher-card-description {
        display: block;
        margin-top: 4px;
        color: #7d8981;
        font-size: 10px;
        line-height: 1.8;
    }

    .launcher-card-state {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        align-self: start;
        margin-top: 1px;
        padding: 4px 7px;
        border: 1px solid #dbeade;
        border-radius: 20px;
        background: #f2f8f3;
        color: #287346;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .launcher-card-state svg {
        width: 11px;
        height: 11px;
    }

    .launcher-card.is-upcoming .launcher-card-state {
        border-color: #e5e8e6;
        background: #f1f3f1;
        color: #737e76;
    }

    .launcher-card.is-upcoming::before {
        background: #e6eae7;
    }

    .launcher-empty {
        padding: 32px 18px;
        border: 1px dashed #cbd9ce;
        border-radius: 16px;
        background: #fff;
        color: var(--launcher-muted);
        text-align: center;
    }

    .launcher-empty svg {
        width: 28px;
        height: 28px;
        margin-bottom: 8px;
        color: #7a9b83;
    }

    .launcher-empty strong {
        display: block;
        color: #405147;
        font-size: 13px;
    }

    .launcher-empty p {
        margin: 5px 0 0;
        font-size: 11px;
    }

    .launcher-sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    @media (max-width: 850px) {
        .launcher-hero {
            grid-template-columns: minmax(0, 1fr);
            gap: 22px;
        }

        .launcher-search-card {
            max-width: none;
        }
    }

    @media (max-width: 560px) {
        .artiman-launcher {
            gap: 23px;
        }

        .launcher-hero {
            padding: 22px 18px;
            border-radius: 18px;
        }

        .launcher-title {
            font-size: 23px;
        }

        .launcher-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 9px;
        }

        .launcher-card {
            min-height: 95px;
            padding: 14px 13px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .artiman-launcher *,
        .artiman-launcher *::before,
        .artiman-launcher *::after {
            scroll-behavior: auto !important;
            transition-duration: .01ms !important;
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
        }
    }
</style>

<div class="artiman-launcher">
    <header class="launcher-hero">
        <div class="launcher-hero-copy">
            <div class="launcher-eyebrow">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M4 20V9m8 11V4m8 16v-7" />
                    <path d="M2 20h20M2 9h4m4-5h4m4 9h4" />
                </svg>
                فضای کاری یکپارچه
            </div>
            <h1 class="launcher-title">سامانه مدیریت آرتیمان صنعت</h1>
            <p class="launcher-intro">
                دسترسی یکپارچه به ابزارهای مدیریت وب‌سایت و مسیر توسعه سامانه صنعتی آرتیمان.
                فقط بخش‌های فعال به صفحه عملیاتی متصل هستند.
            </p>
            <div class="launcher-trust-line">
                <span class="launcher-trust-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <path d="M12 3 4.5 6v5.5c0 4.5 3.1 7.8 7.5 9.5 4.4-1.7 7.5-5 7.5-9.5V6L12 3Z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                </span>
                دسترسی مدیریتی امن و بخش‌بندی‌شده
            </div>
        </div>

        <div class="launcher-search-card">
            <label class="launcher-search-label" for="artimanLauncherSearch">دسترسی سریع به بخش‌ها</label>
            <div class="launcher-search-wrap" role="search">
                <svg class="launcher-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true" focusable="false">
                    <circle cx="10.8" cy="10.8" r="6.8" />
                    <path d="m16 16 5 5" />
                </svg>
                <input
                    type="search"
                    id="artimanLauncherSearch"
                    class="launcher-search"
                    autocomplete="off"
                    placeholder="مثلاً محصولات، فروش یا انبار"
                    aria-label="جست‌وجوی ماژول‌های سامانه"
                    aria-controls="artimanLauncherModules"
                >
            </div>
            <p class="launcher-search-hint">نام یا موضوع یک بخش را وارد کنید تا فهرست لحظه‌ای فیلتر شود.</p>
        </div>
    </header>

    <p class="launcher-sr-only" id="artimanLauncherStatus" role="status" aria-live="polite" aria-atomic="true"></p>

    <div id="artimanLauncherModules">
        <section class="launcher-section" aria-labelledby="launcher-web-title">
            <header class="launcher-section-heading">
                <span class="launcher-section-symbol" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <path d="M3 9h18M8 6.5h.01M11 6.5h.01" />
                    </svg>
                </span>
                <div>
                    <h2 class="launcher-section-title" id="launcher-web-title">مدیریت وب‌سایت</h2>
                    <p class="launcher-section-caption">کاتالوگ و محتوای قابل مدیریت سایت</p>
                </div>
            </header>
            <div class="launcher-grid">
                <a href="{{ route('admin.products.index') }}" class="launcher-card" data-search="محصولات کاتالوگ محصول برج خنک کننده کالا">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z" />
                            <path d="m4.3 7.6 7.7 4.5 7.7-4.5M12 12v9m-4-16.5 8 4.6" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">محصولات</span>
                        <span class="launcher-card-description">مدیریت کاتالوگ و مشخصات محصولات</span>
                    </span>
                    <span class="launcher-card-state">فعال</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="launcher-card" data-search="دسته بندی گروه بندی طبقه بندی محصولات">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="M3 6.5A1.5 1.5 0 0 1 4.5 5h5l2 2h8A1.5 1.5 0 0 1 21 8.5v9a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 17.5v-11Z" />
                            <path d="M3.5 10h17" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">دسته‌بندی‌ها</span>
                        <span class="launcher-card-description">سامان‌دهی گروه‌های محصولات</span>
                    </span>
                    <span class="launcher-card-state">فعال</span>
                </a>

                <a href="{{ route('admin.products.create') }}" class="launcher-card" data-search="ثبت محصول جدید ایجاد محصول افزودن کالا">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 8v8m-4-4h8" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">ثبت محصول جدید</span>
                        <span class="launcher-card-description">افزودن محصول به کاتالوگ آرتیمان</span>
                    </span>
                    <span class="launcher-card-state">فعال</span>
                </a>

                <article class="launcher-card is-upcoming" aria-label="ترجمه محتوا، به‌زودی" data-search="ترجمه محتوا زبان فارسی انگلیسی عربی ترکی چندزبانه">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M3.5 9h17M3.5 15h17M12 3a15 15 0 0 1 0 18m0-18a15 15 0 0 0 0 18" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">ترجمه محتوا</span>
                        <span class="launcher-card-description">مدیریت نسخه‌های چندزبانه سایت</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>
            </div>
        </section>

        <section class="launcher-section" aria-labelledby="launcher-sales-title">
            <header class="launcher-section-heading">
                <span class="launcher-section-symbol" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <path d="M16 20v-1.5a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4V20m5.5-9a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-7.5a4 4 0 0 1 0 7.5m2.5 3a4 4 0 0 1 2 3.5V20" />
                    </svg>
                </span>
                <div>
                    <h2 class="launcher-section-title" id="launcher-sales-title">فروش و مشتریان</h2>
                    <p class="launcher-section-caption">ارتباط با مشتری و پیگیری درخواست‌ها</p>
                </div>
            </header>
            <div class="launcher-grid">
                <article class="launcher-card is-upcoming" aria-label="مشتریان و سرنخ‌ها، به‌زودی" data-search="مشتریان سرنخ سرنخ‌ها crm ارتباط مشتری">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <circle cx="9" cy="8" r="3.5" />
                            <path d="M2.5 20v-1.5A4.5 4.5 0 0 1 7 14h4a4.5 4.5 0 0 1 4.5 4.5V20M16 5a3.5 3.5 0 0 1 0 6.8M18 14.5a4.5 4.5 0 0 1 3.5 4.4V20" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">مشتریان و سرنخ‌ها</span>
                        <span class="launcher-card-description">پیگیری ارتباط و فرصت‌های فروش</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>

                <article class="launcher-card is-upcoming" aria-label="فروش و پیش‌فاکتور، به‌زودی" data-search="فروش پیش فاکتور سفارش قیمت پیشنهاد قیمت">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="M6 3h9l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                            <path d="M14 3v5h5M8 13h8m-8 4h8" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">فروش و پیش‌فاکتور</span>
                        <span class="launcher-card-description">مدیریت پیشنهادها و سفارش‌های فروش</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>

                <article class="launcher-card is-upcoming" aria-label="استعلام‌ها، به‌زودی" data-search="استعلام درخواست مشاوره فرم تماس درخواست مشتری">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="M3 5h18v14H3z" />
                            <path d="m3.5 6 8.5 7L20.5 6" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">استعلام‌ها</span>
                        <span class="launcher-card-description">بررسی درخواست‌های دریافتی مشتریان</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>
            </div>
        </section>

        <section class="launcher-section" aria-labelledby="launcher-factory-title">
            <header class="launcher-section-heading">
                <span class="launcher-section-symbol" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <path d="M3 21V9l6 3V9l6 3V5h6v16H3Z" />
                        <path d="M7 17h2m3 0h2m3 0h2M17 8h2" />
                    </svg>
                </span>
                <div>
                    <h2 class="launcher-section-title" id="launcher-factory-title">مهندسی و کارخانه</h2>
                    <p class="launcher-section-caption">طراحی، ساخت و کنترل عملیات تولید</p>
                </div>
            </header>
            <div class="launcher-grid">
                <article class="launcher-card is-upcoming" aria-label="طراحی برج خنک‌کننده، به‌زودی" data-search="طراحی برج خنک کننده مهندسی انتخاب مشخصات فنی">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="M4 20h16M6 20l2-14h8l2 14M9 9h6m-7 4h8m-9 4h10M9 3h6" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">طراحی برج خنک‌کننده</span>
                        <span class="launcher-card-description">تعریف و بررسی مشخصات فنی محصول</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>

                <article class="launcher-card is-upcoming" aria-label="ساختار محصول BOM، به‌زودی" data-search="ساختار محصول bom مواد قطعات مهندسی">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <rect x="9" y="3" width="6" height="5" rx="1" />
                            <rect x="2" y="16" width="6" height="5" rx="1" />
                            <rect x="16" y="16" width="6" height="5" rx="1" />
                            <path d="M12 8v4m-7 4v-2h14v2" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">ساختار محصول (BOM)</span>
                        <span class="launcher-card-description">تعریف مواد و اجزای ساخت محصول</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>

                <article class="launcher-card is-upcoming" aria-label="تولید، به‌زودی" data-search="تولید برنامه ریزی ساخت عملیات کارخانه">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" />
                            <path d="m19.4 15 .1.1 1.4 1.1-1.5 2.6-1.7-.7a8 8 0 0 1-1.7 1l-.3 1.9h-3l-.3-1.9a8 8 0 0 1-1.7-1l-1.7.7-1.5-2.6 1.5-1.2a7 7 0 0 1 0-2l-1.5-1.2L7 9.2l1.7.7a8 8 0 0 1 1.7-1l.3-1.9h3l.3 1.9a8 8 0 0 1 1.7 1l1.7-.7 1.5 2.6-1.5 1.2a7 7 0 0 1 0 2Z" transform="translate(-1 -1)" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">تولید</span>
                        <span class="launcher-card-description">برنامه‌ریزی و پیگیری عملیات ساخت</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>

                <article class="launcher-card is-upcoming" aria-label="خرید و تأمین، به‌زودی" data-search="خرید تامین تأمین کننده سفارش خرید مواد اولیه">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h8.5a2 2 0 0 0 1.9-1.4L21 8H6" />
                            <circle cx="10" cy="20" r="1" />
                            <circle cx="18" cy="20" r="1" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">خرید و تأمین</span>
                        <span class="launcher-card-description">پیگیری تأمین‌کنندگان و درخواست خرید</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>

                <article class="launcher-card is-upcoming" aria-label="انبار، به‌زودی" data-search="انبار موجودی گردش کالا ورود خروج">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="m3 8 9-5 9 5v11l-9 3-9-3V8Z" />
                            <path d="m3.5 8.5 8.5 4.7 8.5-4.7M12 13v9m-4-16 9 5" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">انبار</span>
                        <span class="launcher-card-description">مدیریت موجودی و گردش کالا</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>

                <article class="launcher-card is-upcoming" aria-label="کنترل کیفیت، به‌زودی" data-search="کنترل کیفیت qc بازرسی آزمون استاندارد">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <circle cx="10.5" cy="10.5" r="6.5" />
                            <path d="m15.5 15.5 5 5m-13-10 2 2 4-4" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">کنترل کیفیت</span>
                        <span class="launcher-card-description">ثبت بازرسی و نتایج کنترل کیفیت</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>
            </div>
        </section>

        <section class="launcher-section" aria-labelledby="launcher-management-title">
            <header class="launcher-section-heading">
                <span class="launcher-section-symbol" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <path d="M4 19V5m0 14h17M8 15l3-4 3 2 5-7" />
                    </svg>
                </span>
                <div>
                    <h2 class="launcher-section-title" id="launcher-management-title">مدیریت و گزارش‌ها</h2>
                    <p class="launcher-section-caption">نمای کلی پروژه و ابزارهای مدیریتی</p>
                </div>
            </header>
            <div class="launcher-grid">
                <a href="{{ route('admin.project-progress.index') }}" class="launcher-card" data-search="پیشرفت پروژه گزارش پروژه فعالیت‌ها برنامه زمان بندی">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M8 2v4m8-4v4M3 9h18M7 14h3m4 0h3m-10 4h3" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">پیشرفت پروژه</span>
                        <span class="launcher-card-description">برنامه و وضعیت فعالیت‌های پروژه آرتیمان</span>
                    </span>
                    <span class="launcher-card-state">فعال</span>
                </a>

                <article class="launcher-card is-upcoming" aria-label="گزارش‌ها، به‌زودی" data-search="گزارش‌ها مدیریتی عملکرد تحلیل گزارش">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <path d="M4 20V11m5 9V5m5 15v-7m5 7V8m-17 12h20" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">گزارش‌ها</span>
                        <span class="launcher-card-description">گزارش‌های عملیاتی و مدیریتی</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>

                <article class="launcher-card is-upcoming" aria-label="کاربران و دسترسی‌ها، به‌زودی" data-search="کاربران دسترسی نقش امنیت مدیریت کاربران">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <rect x="5" y="10" width="14" height="11" rx="2" />
                            <path d="M8 10V7a4 4 0 0 1 8 0v3m-4 5v2" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">کاربران و دسترسی‌ها</span>
                        <span class="launcher-card-description">مدیریت اعضا و سطح دسترسی سامانه</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>

                <article class="launcher-card is-upcoming" aria-label="تنظیمات سامانه، به‌زودی" data-search="تنظیمات سامانه پیکربندی شخصی سازی">
                    <span class="launcher-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                            <circle cx="12" cy="12" r="3" />
                            <path d="m19.4 15 .1.1 1.4 1.1-1.5 2.6-1.7-.7a8 8 0 0 1-1.7 1l-.3 1.9h-3l-.3-1.9a8 8 0 0 1-1.7-1L9 18.8l-1.5-2.6L9 15a7 7 0 0 1 0-2l-1.5-1.2L9 9.2l1.7.7a8 8 0 0 1 1.7-1l.3-1.9h3l.3 1.9a8 8 0 0 1 1.7 1l1.7-.7 1.5 2.6-1.5 1.2a7 7 0 0 1 0 2Z" transform="translate(-1 -1)" />
                        </svg>
                    </span>
                    <span class="launcher-card-copy">
                        <span class="launcher-card-title">تنظیمات سامانه</span>
                        <span class="launcher-card-description">مدیریت پیکربندی‌های عمومی سامانه</span>
                    </span>
                    <span class="launcher-card-state">به‌زودی</span>
                </article>
            </div>
        </section>
    </div>

    <div class="launcher-empty" id="artimanLauncherEmpty" role="status" hidden>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <circle cx="10.8" cy="10.8" r="6.8" />
            <path d="m16 16 5 5M8 10.8h5.6" />
        </svg>
        <strong>بخشی با این عبارت پیدا نشد</strong>
        <p>نام یا موضوع دیگری را جست‌وجو کنید.</p>
    </div>
</div>

<script>
(() => {
    const launcher = document.querySelector('.artiman-launcher');
    const search = launcher?.querySelector('#artimanLauncherSearch');

    if (!launcher || !search) {
        return;
    }

    const cards = Array.from(launcher.querySelectorAll('.launcher-card'));
    const sections = Array.from(launcher.querySelectorAll('.launcher-section'));
    const emptyMessage = launcher.querySelector('#artimanLauncherEmpty');
    const status = launcher.querySelector('#artimanLauncherStatus');

    const normalize = (value) => value
        .normalize('NFKC')
        .toLocaleLowerCase('fa')
        .replace(/[يى]/g, 'ی')
        .replace(/ك/g, 'ک')
        .replace(/[\u064b-\u065f\u0670\u0640]/g, '')
        .replace(/[\u200c\u200e\u200f]/g, '')
        .replace(/[۰-۹]/g, (digit) => String(digit.charCodeAt(0) - 0x06f0))
        .replace(/[٠-٩]/g, (digit) => String(digit.charCodeAt(0) - 0x0660))
        .replace(/\s+/g, ' ')
        .trim();

    const filterModules = () => {
        const query = normalize(search.value);
        let visibleCount = 0;

        cards.forEach((card) => {
            const searchableText = normalize(`${card.textContent} ${card.dataset.search || ''}`);
            const matches = query === '' || searchableText.includes(query);

            card.hidden = !matches;
            visibleCount += matches ? 1 : 0;
        });

        sections.forEach((section) => {
            section.hidden = !section.querySelector('.launcher-card:not([hidden])');
        });

        emptyMessage.hidden = visibleCount > 0;

        if (status) {
            status.textContent = query === ''
                ? ''
                : visibleCount === 0
                    ? 'موردی پیدا نشد.'
                    : `${new Intl.NumberFormat('fa').format(visibleCount)} ماژول نمایش داده می‌شود.`;
        }
    };

    search.addEventListener('input', filterModules);
})();
</script>
@endsection
