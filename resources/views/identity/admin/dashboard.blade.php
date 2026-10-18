@extends('admin.layouts.app')

@section('title', 'داشبورد مدیریت')

@section('content')
<style>
    .app-launcher {
        direction: rtl;
        color: #26372d;
    }

    .launcher-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .launcher-heading h1 {
        margin: 0 0 8px;
        font-size: 25px;
        font-weight: 800;
    }

    .launcher-heading p {
        margin: 0;
        color: #78867d;
        line-height: 1.9;
        font-size: 13px;
    }

    .launcher-search {
        width: 100%;
        max-width: 320px;
        padding: 12px 15px;
        border: 1px solid #dfe7e1;
        border-radius: 12px;
        background: #fff;
        color: #26372d;
        font: inherit;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .launcher-search:focus {
        border-color: #27834e;
        box-shadow: 0 0 0 3px rgba(39,131,78,.10);
    }

    .launcher-section {
        margin-bottom: 28px;
    }

    .launcher-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 15px;
        font-size: 15px;
        font-weight: 800;
    }

    .launcher-section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        border-radius: 4px;
        background: #27834e;
    }

    .launcher-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
        gap: 15px;
    }

    .launcher-app {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        min-height: 155px;
        padding: 20px 12px 16px;
        border: 1px solid #e3eae5;
        border-radius: 16px;
        background: #fff;
        color: #33443a;
        text-align: center;
        text-decoration: none;
        transition: transform .2s, border-color .2s, box-shadow .2s;
    }

    a.launcher-app:hover {
        transform: translateY(-4px);
        border-color: #a9cfb6;
        box-shadow: 0 10px 25px rgba(35, 90, 53, .09);
        color: #237747;
    }

    .launcher-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 62px;
        height: 62px;
        margin-bottom: 13px;
        border-radius: 18px;
        font-size: 30px;
        line-height: 1;
    }

    .launcher-app-title {
        font-size: 13px;
        font-weight: 800;
        line-height: 1.8;
    }

    .launcher-app-description {
        margin-top: 4px;
        color: #87938b;
        font-size: 11px;
        line-height: 1.8;
    }

    .launcher-badge {
        margin-top: 9px;
        padding: 3px 9px;
        border-radius: 20px;
        background: #f0f2f1;
        color: #77817a;
        font-size: 10px;
    }

    .launcher-empty {
        display: none;
        padding: 25px;
        border: 1px dashed #cbd8ce;
        border-radius: 14px;
        color: #78867d;
        text-align: center;
        background: #fff;
    }

    @media (max-width: 600px) {
        .launcher-heading h1 {
            font-size: 21px;
        }

        .launcher-search {
            max-width: none;
        }

        .launcher-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .launcher-app {
            min-height: 145px;
            padding: 16px 8px 12px;
        }

        .launcher-icon {
            width: 54px;
            height: 54px;
            font-size: 26px;
        }
    }
</style>

<div class="app-launcher">
    <div class="launcher-heading">
        <div>
            <h1>برنامه‌های آرتیمان صنعت</h1>
            <p>برای ورود به هر بخش، آیکون مربوط به آن را انتخاب کنید.</p>
        </div>

        <input
            type="search"
            id="launcherSearch"
            class="launcher-search"
            placeholder="جست‌وجوی بخش‌ها..."
            aria-label="جست‌وجوی بخش‌های داشبورد"
        >
    </div>

    <section class="launcher-section">
        <h2 class="launcher-section-title">مدیریت وب‌سایت</h2>

        <div class="launcher-grid">
            <a href="{{ route('admin.products.index') }}"
               class="launcher-app"
               data-search="محصولات کاتالوگ محصول برج خنک کننده">
                <span class="launcher-icon" style="background:#e3f4e8;color:#237747;">📦</span>
                <span class="launcher-app-title">محصولات</span>
                <span class="launcher-app-description">مدیریت کاتالوگ محصولات</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="launcher-app"
               data-search="دسته بندی گروه بندی محصولات">
                <span class="launcher-icon" style="background:#e4efff;color:#3169ad;">🗂️</span>
                <span class="launcher-app-title">دسته‌بندی‌ها</span>
                <span class="launcher-app-description">مدیریت گروه‌های محصولات</span>
            </a>

            <a href="{{ route('admin.products.create') }}"
               class="launcher-app"
               data-search="ثبت محصول جدید ایجاد محصول">
                <span class="launcher-icon" style="background:#fff0d9;color:#a96b15;">➕</span>
                <span class="launcher-app-title">ثبت محصول جدید</span>
                <span class="launcher-app-description">افزودن محصول به کاتالوگ</span>
            </a>

            <div class="launcher-app"
                 data-search="ترجمه زبان فارسی انگلیسی عربی ترکی">
                <span class="launcher-icon" style="background:#f0e8ff;color:#7951ac;">🌐</span>
                <span class="launcher-app-title">ترجمه محتوا</span>
                <span class="launcher-app-description">مدیریت زبان‌های سایت</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>
        </div>
    </section>

    <section class="launcher-section">
        <h2 class="launcher-section-title">فروش و مشتریان</h2>

        <div class="launcher-grid">
            <div class="launcher-app" data-search="سرنخ مشتریان crm">
                <span class="launcher-icon" style="background:#e3f4e8;color:#237747;">👥</span>
                <span class="launcher-app-title">مشتریان و سرنخ‌ها</span>
                <span class="launcher-app-description">پیگیری ارتباط با مشتریان</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>

            <div class="launcher-app" data-search="پیش فاکتور فروش سفارش فروش">
                <span class="launcher-icon" style="background:#e4efff;color:#3169ad;">🧾</span>
                <span class="launcher-app-title">فروش و پیش‌فاکتور</span>
                <span class="launcher-app-description">مدیریت درخواست‌های فروش</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>

            <div class="launcher-app" data-search="استعلام درخواست مشتری">
                <span class="launcher-icon" style="background:#fff0d9;color:#a96b15;">📨</span>
                <span class="launcher-app-title">استعلام‌ها</span>
                <span class="launcher-app-description">بررسی درخواست‌های دریافتی</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>
        </div>
    </section>

    <section class="launcher-section">
        <h2 class="launcher-section-title">مهندسی و کارخانه</h2>

        <div class="launcher-grid">
            <div class="launcher-app" data-search="طراحی برج خنک کننده انتخاب مشخصات">
                <span class="launcher-icon" style="background:#e4efff;color:#3169ad;">🏗️</span>
                <span class="launcher-app-title">طراحی برج خنک‌کننده</span>
                <span class="launcher-app-description">تعریف مشخصات فنی محصول</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>

            <div class="launcher-app" data-search="مهندسی bom ساختار مواد قطعات">
                <span class="launcher-icon" style="background:#f0e8ff;color:#7951ac;">🧩</span>
                <span class="launcher-app-title">ساختار محصول (BOM)</span>
                <span class="launcher-app-description">تعریف مواد و قطعات محصول</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>

            <div class="launcher-app" data-search="تولید برنامه ریزی دستور کار">
                <span class="launcher-icon" style="background:#e3f4e8;color:#237747;">⚙️</span>
                <span class="launcher-app-title">تولید</span>
                <span class="launcher-app-description">برنامه‌ریزی و عملیات ساخت</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>

            <div class="launcher-app" data-search="خرید تامین کننده سفارش خرید">
                <span class="launcher-icon" style="background:#fff0d9;color:#a96b15;">🛒</span>
                <span class="launcher-app-title">خرید و تأمین</span>
                <span class="launcher-app-description">درخواست‌ها و سفارش‌های خرید</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>

            <div class="launcher-app" data-search="انبار موجودی ورود خروج کالا">
                <span class="launcher-icon" style="background:#e0f4f4;color:#187d7d;">🏬</span>
                <span class="launcher-app-title">انبار</span>
                <span class="launcher-app-description">موجودی و گردش کالا</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>

            <div class="launcher-app" data-search="کنترل کیفیت qc بازرسی">
                <span class="launcher-icon" style="background:#ffe7e5;color:#bd5148;">🔍</span>
                <span class="launcher-app-title">کنترل کیفیت</span>
                <span class="launcher-app-description">بازرسی و ثبت نتایج کیفیت</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>
        </div>
    </section>

    <section class="launcher-section">
        <h2 class="launcher-section-title">مدیریت و گزارش‌ها</h2>

        <div class="launcher-grid">
            <div class="launcher-app" data-search="گزارش مدیریتی آمار عملکرد">
                <span class="launcher-icon" style="background:#e4efff;color:#3169ad;">📊</span>
                <span class="launcher-app-title">گزارش‌ها</span>
                <span class="launcher-app-description">گزارش عملکرد بخش‌ها</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>

            <div class="launcher-app" data-search="کاربران دسترسی امنیت">
                <span class="launcher-icon" style="background:#f0e8ff;color:#7951ac;">🔐</span>
                <span class="launcher-app-title">کاربران و دسترسی‌ها</span>
                <span class="launcher-app-description">مدیریت کاربران سامانه</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>

            <div class="launcher-app" data-search="تنظیمات آیکون منو ترتیب بخش ها">
                <span class="launcher-icon" style="background:#eef1ee;color:#58675d;">🎨</span>
                <span class="launcher-app-title">تنظیمات داشبورد</span>
                <span class="launcher-app-description">شخصی‌سازی آیکون‌ها و منوها</span>
                <span class="launcher-badge">به‌زودی</span>
            </div>
        </div>
    </section>

    <div id="launcherEmpty" class="launcher-empty">
        بخشی با این عبارت پیدا نشد.
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('launcherSearch');
    const apps = Array.from(document.querySelectorAll('.launcher-app'));
    const sections = Array.from(document.querySelectorAll('.launcher-section'));
    const emptyMessage = document.getElementById('launcherEmpty');

    if (!search) return;

    search.addEventListener('input', function () {
        const query = search.value.trim().toLocaleLowerCase('fa');
        let visibleCount = 0;

        apps.forEach(function (app) {
            const text = (
                app.innerText + ' ' + (app.dataset.search || '')
            ).toLocaleLowerCase('fa');

            const visible = !query || text.includes(query);
            app.style.display = visible ? '' : 'none';

            if (visible) visibleCount++;
        });

        sections.forEach(function (section) {
            const hasVisibleApps = Array.from(
                section.querySelectorAll('.launcher-app')
            ).some(function (app) {
                return app.style.display !== 'none';
            });

            section.style.display = hasVisibleApps ? '' : 'none';
        });

        emptyMessage.style.display = visibleCount ? 'none' : 'block';
    });
});
</script>
@endsection
