@extends('website.layouts.app')

@section('title', $product['meta_title'] ?: $product['title'])

@section('meta')
    @php
        $metaDescription = $product['meta_description']
            ?: \Illuminate\Support\Str::limit($product['short_description'] ?? '', 160);

        $canonicalRoute = app()->getLocale() === 'fa'
            ? 'website.products.show'
            : 'localized.website.products.show';

        $canonicalParams = app()->getLocale() === 'fa'
            ? ['slug' => $product['slug']]
            : ['locale' => app()->getLocale(), 'slug' => $product['slug']];
    @endphp

    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ route($canonicalRoute, $canonicalParams) }}">
    <meta property="og:title" content="{{ $product['meta_title'] ?: $product['title'] }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{ route($canonicalRoute, $canonicalParams) }}">
@endsection

@section('styles')
<style>
    .product-page {
        --artiman-green: #168653;
        --artiman-dark: #173d32;
        --artiman-muted: #6b7d76;
        color: #23352f;
        background: #fff;
        padding-bottom: 64px;
    }

    .product-page * { box-sizing: border-box; }

    .product-container {
        width: min(1180px, calc(100% - 40px));
        margin-inline: auto;
    }

    .product-breadcrumb {
        padding: 19px 0;
        background: #f5f8f6;
        border-bottom: 1px solid #e8efeb;
        font-size: 13px;
    }

    .product-breadcrumb ol {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        align-items: center;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .product-breadcrumb li + li::before {
        content: "/";
        color: #a4b2ac;
        margin-inline-end: 9px;
    }

    .product-breadcrumb a {
        color: #64766e;
        text-decoration: none;
    }

    .product-breadcrumb a:hover { color: var(--artiman-green); }

    .product-hero {
        padding: 54px 0 48px;
        background:
            radial-gradient(ellipse at 10% 0%, rgba(37, 155, 100, .10), transparent 42%),
            linear-gradient(135deg, #f6faf7 0%, #fff 68%);
        border-bottom: 1px solid #edf2ef;
    }

    .product-hero-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.04fr) minmax(0, .96fr);
        gap: 54px;
        align-items: center;
    }

    .product-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 13px;
        color: #147647;
        background: #e7f5ec;
        border: 1px solid #d2eadb;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .product-eyebrow-dot {
        width: 7px;
        height: 7px;
        background: #168653;
        border-radius: 50%;
    }

    .product-title {
        color: var(--artiman-dark);
        font-size: clamp(29px, 3.4vw, 45px);
        line-height: 1.55;
        font-weight: 850;
        letter-spacing: -.8px;
        margin: 0 0 17px;
    }

    .product-short-description {
        color: #66776f;
        font-size: 16px;
        line-height: 2.1;
        margin: 0;
    }

    .product-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
    }

    .product-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 9px;
        min-height: 49px;
        padding: 12px 21px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 750;
        transition: transform .2s, box-shadow .2s, background .2s;
    }

    .product-btn:hover { transform: translateY(-2px); }

    .product-btn-primary {
        color: #fff !important;
        background: var(--artiman-green);
        box-shadow: 0 8px 22px rgba(22, 134, 83, .2);
    }

    .product-btn-primary:hover {
        background: #106d43;
        box-shadow: 0 11px 26px rgba(22, 134, 83, .27);
    }

    .product-btn-secondary {
        color: var(--artiman-dark) !important;
        background: #fff;
        border: 1px solid #dce8e0;
    }

    .product-visual {
        position: relative;
        min-width: 0;
        padding: 15px;
        background: rgba(255,255,255,.8);
        border: 1px solid #e3ece6;
        border-radius: 25px;
        box-shadow: 0 22px 65px rgba(32, 71, 52, .10);
    }

    .product-visual::before {
        content: "";
        position: absolute;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: #e4f4e9;
        top: -24px;
        inset-inline-end: -18px;
        z-index: 0;
    }

    .product-main-image-wrap {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 340px;
        overflow: hidden;
        border-radius: 17px;
        background:
            linear-gradient(135deg, rgba(240,247,242,.85), rgba(255,255,255,.96));
    }

    .product-main-image {
        display: block;
        width: 100%;
        height: 370px;
        object-fit: contain;
        padding: 14px;
        transition: transform .35s ease;
    }

    .product-main-image:hover { transform: scale(1.035); }

    .product-image-placeholder {
        padding: 45px 20px;
        color: #7b8d83;
        text-align: center;
        line-height: 2;
    }

    .product-image-caption {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 5px 2px;
        color: #65776d;
        font-size: 12px;
    }

    .product-image-caption strong {
        color: var(--artiman-dark);
        font-size: 13px;
    }

    .product-section { padding: 65px 0 0; }

    .product-section-heading {
        margin-bottom: 28px;
    }

    .product-section-kicker {
        color: var(--artiman-green);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .product-section-title {
        color: var(--artiman-dark);
        font-size: clamp(23px, 2.4vw, 31px);
        line-height: 1.6;
        font-weight: 850;
        margin: 0;
    }

    .product-section-description {
        color: #718078;
        font-size: 14px;
        line-height: 2;
        margin: 8px 0 0;
    }

    .product-description-card {
        padding: 28px 30px;
        border: 1px solid #e5ede8;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(27, 65, 45, .035);
    }

    .product-full-description {
        color: #596b62;
        font-size: 15px;
        line-height: 2.25;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .product-full-description p:last-child { margin-bottom: 0; }

    .product-spec-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 13px;
    }

    .product-spec-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 18px;
        padding: 18px 20px;
        background: #fff;
        border: 1px solid #e5ede8;
        border-radius: 13px;
    }

    .product-spec-item:nth-child(4n + 1),
    .product-spec-item:nth-child(4n + 2) {
        background: #f8fbf9;
    }

    .product-spec-key {
        color: #718078;
        font-size: 13px;
        line-height: 1.9;
    }

    .product-spec-value {
        color: var(--artiman-dark);
        text-align: end;
        font-size: 14px;
        font-weight: 750;
        line-height: 1.9;
        overflow-wrap: anywhere;
    }

    .product-spec-unit {
        display: inline-block;
        color: #87968e;
        font-size: 12px;
        font-weight: 500;
        margin-inline-start: 4px;
    }

    .product-main-image-wrap { position: relative; }
    .product-slide-image { display: none !important; }
    .product-slide-image.is-active { display: block !important; }
    .product-slider-arrow {
        position: absolute;
        z-index: 3;
        top: 50%;
        transform: translateY(-50%);
        width: 42px;
        height: 42px;
        border: 1px solid #dce8e0;
        border-radius: 50%;
        background: rgba(255,255,255,.94);
        color: #173d32;
        font-size: 30px;
        line-height: 1;
        cursor: pointer;
        box-shadow: 0 3px 12px rgba(0,0,0,.10);
    }
    .product-slider-prev { inset-inline-start: 12px; }
    .product-slider-next { inset-inline-end: 12px; }
    .product-slider-arrow:hover { background: #e7f5ec; }
    .product-slider-counter {
        position: absolute;
        z-index: 3;
        bottom: 12px;
        inset-inline-end: 12px;
        padding: 5px 10px;
        border-radius: 20px;
        background: rgba(23,61,50,.82);
        color: #fff;
        font-size: 12px;
        direction: ltr;
    }
    .product-slider-thumbnails {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 9px;
        overflow-x: auto;
        padding: 12px 2px 3px;
        scrollbar-width: thin;
    }
    .product-slider-thumb {
        flex: 0 0 76px;
        width: 76px;
        height: 66px;
        padding: 3px;
        overflow: hidden;
        border: 2px solid #e3ece6;
        border-radius: 10px;
        background: #fff;
        cursor: pointer;
    }
    .product-slider-thumb img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 6px;
        background: #f5f8f6;
    }
    .product-slider-thumb.is-active {
        border-color: #168653;
        box-shadow: 0 0 0 2px rgba(22,134,83,.10);
    }
    .product-gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 17px;
    }

    .product-gallery-item {
        padding: 9px;
        border: 1px solid #e5ede8;
        border-radius: 15px;
        background: #fff;
        overflow: hidden;
    }

    .product-gallery-item img {
        display: block;
        width: 100%;
        height: 220px;
        object-fit: contain;
        border-radius: 10px;
        background: #f5f8f6;
    }

    .product-gallery-item p {
        color: #61736a;
        font-size: 12px;
        text-align: center;
        margin: 12px 0 4px;
    }

    .product-cta {
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 28px;
        padding: 36px 40px;
        border-radius: 22px;
        background: linear-gradient(120deg, #143e31, #19794c);
        color: #fff;
        box-shadow: 0 18px 40px rgba(23, 83, 55, .17);
    }

    .product-cta::after {
        content: "";
        position: absolute;
        width: 250px;
        height: 250px;
        border: 1px solid rgba(255,255,255,.11);
        border-radius: 50%;
        inset-inline-end: -80px;
        top: -130px;
        box-shadow: 0 0 0 30px rgba(255,255,255,.035), 0 0 0 60px rgba(255,255,255,.025);
        pointer-events: none;
    }

    .product-cta-content { position: relative; z-index: 1; }

    .product-cta h2 {
        color: #fff;
        font-size: clamp(21px, 2.5vw, 29px);
        font-weight: 850;
        line-height: 1.7;
        margin: 0 0 8px;
    }

    .product-cta p {
        color: rgba(255,255,255,.79);
        font-size: 14px;
        line-height: 2;
        margin: 0;
        max-width: 650px;
    }

    .product-cta .product-btn {
        position: relative;
        z-index: 1;
        flex-shrink: 0;
        color: #174632 !important;
        background: #fff;
    }

    .product-cta .product-btn:hover { background: #e9f6ee; }

    @media (max-width: 850px) {
        .product-hero-grid { grid-template-columns: 1fr; gap: 32px; }
        .product-hero { padding-top: 35px; }
        .product-visual { max-width: 620px; width: 100%; margin-inline: auto; }
        .product-main-image { height: 320px; }
        .product-cta { align-items: flex-start; flex-direction: column; padding: 29px; }
    }

    @media (max-width: 600px) {
        .product-container { width: min(100% - 28px, 1180px); }
        .product-hero { padding: 28px 0 35px; }
        .product-title { font-size: 28px; }
        .product-short-description { font-size: 14px; }
        .product-main-image-wrap { min-height: 240px; }
        .product-main-image { height: 270px; }
        .product-section { padding-top: 45px; }
        .product-description-card { padding: 20px; }
        .product-spec-grid { grid-template-columns: 1fr; gap: 9px; }
        .product-spec-item { padding: 15px; }
        .product-main-image-wrap { position: relative; }
    .product-slide-image { display: none !important; }
    .product-slide-image.is-active { display: block !important; }
    .product-slider-arrow {
        position: absolute;
        z-index: 3;
        top: 50%;
        transform: translateY(-50%);
        width: 42px;
        height: 42px;
        border: 1px solid #dce8e0;
        border-radius: 50%;
        background: rgba(255,255,255,.94);
        color: #173d32;
        font-size: 30px;
        line-height: 1;
        cursor: pointer;
        box-shadow: 0 3px 12px rgba(0,0,0,.10);
    }
    .product-slider-prev { inset-inline-start: 12px; }
    .product-slider-next { inset-inline-end: 12px; }
    .product-slider-arrow:hover { background: #e7f5ec; }
    .product-slider-counter {
        position: absolute;
        z-index: 3;
        bottom: 12px;
        inset-inline-end: 12px;
        padding: 5px 10px;
        border-radius: 20px;
        background: rgba(23,61,50,.82);
        color: #fff;
        font-size: 12px;
        direction: ltr;
    }
    .product-slider-thumbnails {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 9px;
        overflow-x: auto;
        padding: 12px 2px 3px;
        scrollbar-width: thin;
    }
    .product-slider-thumb {
        flex: 0 0 76px;
        width: 76px;
        height: 66px;
        padding: 3px;
        overflow: hidden;
        border: 2px solid #e3ece6;
        border-radius: 10px;
        background: #fff;
        cursor: pointer;
    }
    .product-slider-thumb img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 6px;
        background: #f5f8f6;
    }
    .product-slider-thumb.is-active {
        border-color: #168653;
        box-shadow: 0 0 0 2px rgba(22,134,83,.10);
    }
    .product-gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
        .product-gallery-item img { height: 150px; }
        .product-cta { padding: 25px 21px; }
        .product-cta .product-btn { width: 100%; }
        .product-hero-actions .product-btn { flex: 1 1 100%; }
    }
</style>
@endsection

@section('content')
    @php
        $imagePaths = [];

        foreach (($product['images'] ?? []) as $image) {
            if (!is_string($image) || trim($image) === '') {
                continue;
            }

            $image = trim($image);

            if (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://'])) {
                $imagePaths[] = $image;
                continue;
            }

            $image = ltrim(str_replace('\\', '/', $image), '/');

            if (\Illuminate\Support\Str::startsWith($image, 'storage/')) {
                $image = substr($image, strlen('storage/'));
            }

            $imagePaths[] = asset('storage/' . $image);
        }

        $imagePaths = array_values(array_unique($imagePaths));
        $mainImage = $imagePaths[0] ?? null;

        $inquiryRoute = app()->getLocale() === 'fa'
            ? 'website.inquiry.create'
            : 'localized.website.inquiry.create';

        $inquiryParams = app()->getLocale() === 'fa'
            ? []
            : ['locale' => app()->getLocale()];

        $inquiryRouteExists = \Illuminate\Support\Facades\Route::has($inquiryRoute);

        $indexRouteName = app()->getLocale() === 'fa'
            ? 'website.products.index'
            : 'localized.website.products.index';

        $indexRouteParams = app()->getLocale() === 'fa'
            ? []
            : ['locale' => app()->getLocale()];
    @endphp

    <div class="product-page">
        <nav class="product-breadcrumb" aria-label="مسیر صفحه">
            <div class="product-container">
                <ol>
                    <li><a href="{{ route('website.home') }}">خانه</a></li>
                    <li><a href="{{ route($indexRouteName, $indexRouteParams) }}">محصولات</a></li>
                    @if($category)
                        <li><a href="{{ route($indexRouteName, $indexRouteParams) }}">{{ $category['name'] }}</a></li>
                    @endif
                    <li aria-current="page">{{ $product['title'] }}</li>
                </ol>
            </div>
        </nav>

        <section class="product-hero">
            <div class="product-container product-hero-grid">
                <div class="product-hero-copy">
                    <div class="product-eyebrow">
                        <span class="product-eyebrow-dot"></span>
                        تجهیزات صنعتی آرتیمان صنعت
                    </div>

                    <h1 class="product-title">{{ $product['title'] }}</h1>

                    @if(!empty($product['short_description']))
                        <p class="product-short-description">{{ $product['short_description'] }}</p>
                    @else
                        <p class="product-short-description">
                            راهکاری مهندسی برای انتخاب تجهیزات خنک‌کاری متناسب با نیاز فرایند صنعتی شما.
                            برای دریافت اطلاعات فنی و انتخاب مناسب، با کارشناسان آرتیمان صنعت در ارتباط باشید.
                        </p>
                    @endif

                    <div class="product-hero-actions">
                        @if($inquiryRouteExists)
                            <a class="product-btn product-btn-primary" href="{{ route($inquiryRoute, $inquiryParams) }}">
                                درخواست استعلام و مشاوره
                                <span aria-hidden="true">←</span>
                            </a>
                        @endif

                        @if(!empty($product['specs']) && is_array($product['specs']))
                            <a class="product-btn product-btn-secondary" href="#product-specifications">
                                مشاهده مشخصات فنی
                                <span aria-hidden="true">↓</span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="product-visual">
                    <div class="product-main-image-wrap" data-product-slider>
                        @if(count($imagePaths) > 0)
                            @foreach($imagePaths as $index => $imageUrl)
                                <img
                                    class="product-main-image product-slide-image {{ $index === 0 ? 'is-active' : '' }}"
                                    data-slide-index="{{ $index }}"
                                    src="{{ $imageUrl }}"
                                    alt="{{ $product['title'] }}"
                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                    onerror="this.style.display='none';"
                                >
                            @endforeach

                            @if(count($imagePaths) > 1)
                                <button type="button" class="product-slider-arrow product-slider-prev" aria-label="Previous image" data-slide-prev>‹</button>
                                <button type="button" class="product-slider-arrow product-slider-next" aria-label="Next image" data-slide-next>›</button>
                                <span class="product-slider-counter" data-slide-counter>1 / {{ count($imagePaths) }}</span>
                            @endif
                        @else
                            <div class="product-image-placeholder">
                                <strong>تصویر محصول ثبت نشده است</strong>
                                <br>
                                تصویر این محصول را از پنل مدیریت بارگذاری کنید.
                            </div>
                        @endif
                    </div>

                    @if(count($imagePaths) > 1)
                        <div class="product-slider-thumbnails" aria-label="Product images">
                            @foreach($imagePaths as $index => $imageUrl)
                                <button
                                    type="button"
                                    class="product-slider-thumb {{ $index === 0 ? 'is-active' : '' }}"
                                    data-slide-to="{{ $index }}"
                                    aria-label="Image {{ $index + 1 }}"
                                    aria-pressed="{{ $index === 0 ? 'true' : 'false' }}"
                                >
                                    <img src="{{ $imageUrl }}" alt="" loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <div class="product-image-caption">
                        <strong>{{ $product['title'] }}</strong>
                        <span>محصول آرتیمان صنعت</span>
                    </div>
                </div>
            </div>
        </section>

        @if(!empty($product['full_description']))
            <section class="product-section">
                <div class="product-container">
                    <div class="product-section-heading">
                        <div class="product-section-kicker">PRODUCT OVERVIEW</div>
                        <h2 class="product-section-title">معرفی محصول</h2>
                        <p class="product-section-description">
                            آشنایی با محصول و کاربردهای آن
                        </p>
                    </div>

                    <div class="product-description-card">
                        <div class="product-full-description">{{ $product['full_description'] }}</div>
                    </div>
                </div>
            </section>
        @endif

        @if(!empty($product['specs']) && is_array($product['specs']))
            <section class="product-section" id="product-specifications">
                <div class="product-container">
                    <div class="product-section-heading">
                        <div class="product-section-kicker">TECHNICAL DATA</div>
                        <h2 class="product-section-title">مشخصات فنی</h2>
                        <p class="product-section-description">
                            اطلاعات ثبت‌شده برای بررسی و مقایسه فنی محصول
                        </p>
                    </div>

                    <div class="product-spec-grid">
                        @foreach($product['specs'] as $spec)
                            <div class="product-spec-item">
                                <div class="product-spec-key">{{ $spec['key'] ?? '' }}</div>
                                <div class="product-spec-value">
                                    {{ $spec['value'] ?? '' }}
                                    @if(!empty($spec['unit']))
                                        <span class="product-spec-unit">{{ $spec['unit'] }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
<section class="product-section">
            <div class="product-container">
                <div class="product-cta">
                    <div class="product-cta-content">
                        <h2>برای انتخاب مناسب، با ما مشورت کنید</h2>
                        <p>
                            برای دریافت اطلاعات تکمیلی، بررسی نیاز پروژه و ثبت درخواست استعلام،
                            با کارشناسان آرتیمان صنعت در ارتباط باشید.
                        </p>
                    </div>

                    @if($inquiryRouteExists)
                        <a class="product-btn" href="{{ route($inquiryRoute, $inquiryParams) }}">
                            درخواست استعلام محصول
                            <span aria-hidden="true">←</span>
                        </a>
                    @else
                        <a class="product-btn" href="{{ route('website.home') }}">
                            بازگشت به سایت آرتیمان
                        </a>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('[data-product-slider]').forEach(function (slider) {
    const images = Array.from(slider.querySelectorAll('[data-slide-index]'));
    if (images.length < 2) return;

    const visual = slider.closest('.product-visual');
    const thumbs = Array.from(visual.querySelectorAll('[data-slide-to]'));
    const counter = slider.querySelector('[data-slide-counter]');
    let activeIndex = 0;

    function showSlide(index) {
        activeIndex = (index + images.length) % images.length;

        images.forEach(function (image, i) {
            image.classList.toggle('is-active', i === activeIndex);
        });

        thumbs.forEach(function (thumb, i) {
            const active = i === activeIndex;
            thumb.classList.toggle('is-active', active);
            thumb.setAttribute('aria-pressed', active ? 'true' : 'false');
        });

        if (counter) counter.textContent = (activeIndex + 1) + ' / ' + images.length;
    }

    slider.querySelector('[data-slide-prev]')?.addEventListener('click', function () {
        showSlide(activeIndex - 1);
    });

    slider.querySelector('[data-slide-next]')?.addEventListener('click', function () {
        showSlide(activeIndex + 1);
    });

    thumbs.forEach(function (thumb, i) {
        thumb.addEventListener('click', function () {
            showSlide(i);
        });
    });

    showSlide(0);
});
</script>
@endsection
