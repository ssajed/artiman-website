@extends('website.layouts.app')

@section('title', $product['meta_title'] ?: $product['title'])

@section('meta')
    @php
        $metaDescription = $product['meta_description'] ?: \Illuminate\Support\Str::limit($product['short_description'] ?? '', 160);

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

@section('content')
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="bg-light py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('website.home') }}" class="text-decoration-none">خانه</a>
                </li>
                <li class="breadcrumb-item">
                    @php
                        $indexRouteName = app()->getLocale() === 'fa' ? 'website.products.index' : 'localized.website.products.index';
                        $indexRouteParams = app()->getLocale() === 'fa' ? [] : ['locale' => app()->getLocale()];
                    @endphp
                    <a href="{{ route($indexRouteName, $indexRouteParams) }}" class="text-decoration-none">محصولات</a>
                </li>
                @if($category)
                    <li class="breadcrumb-item">
                        <span class="text-muted">{{ $category['name'] }}</span>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $product['title'] }}
                </li>
            </ol>
        </div>
    </nav>

    {{-- Product Header --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    @if($category)
                        <span class="badge bg-success mb-3">{{ $category['name'] }}</span>
                    @endif
                    <h1 class="display-5 fw-bold mb-3">{{ $product['title'] }}</h1>
                    <p class="lead text-muted mb-0">{{ $product['short_description'] ?? '' }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Product Images (if available) --}}
    @if(!empty($product['images']) && is_array($product['images']))
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <h2 class="h3 fw-bold mb-4">تصاویر محصول</h2>
                        <div class="row g-3">
                            @foreach($product['images'] as $image)
                                @php
                                    // ساخت URL صحیح برای فایل‌های ذخیره‌شده در storage/app/public/products/
                                    // فرض بر این است که $image نام فایل (مثلاً image.jpg) است
                                    $imageUrl = asset('storage/products/' . $image);
                                @endphp
                                <div class="col-md-4">
                                    <img src="{{ $imageUrl }}"
                                         class="img-fluid rounded shadow-sm w-100"
                                         alt="{{ $product['title'] }}"
                                         style="object-fit: cover; height: 250px;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Product Full Description --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h2 class="h3 fw-bold mb-4">توضیحات کامل</h2>
                    {{-- استفاده از white-space: pre-line برای نمایش صحیح خطوط جدید بدون نیاز به nl2br --}}
                    {{-- {{ }} به‌طور خودکار محتوا را Escape می‌کند و از XSS جلوگیری می‌کند --}}
                    <div class="text-muted" style="white-space: pre-line; line-height: 1.8;">
                        {{ $product['full_description'] ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Technical Specifications --}}
    @if(!empty($product['specs']) && is_array($product['specs']))
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <h2 class="h3 fw-bold mb-4">مشخصات فنی</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered bg-white">
                                <tbody>
                                    @foreach($product['specs'] as $spec)
                                        <tr>
                                            <th class="fw-bold bg-light" style="width: 35%;">
                                                {{ $spec['key'] ?? '' }}
                                            </th>
                                            <td>
                                                {{ $spec['value'] ?? '' }}
                                                @if(!empty($spec['unit']))
                                                    <span class="text-muted small ms-1">{{ $spec['unit'] }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- CTA Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h4 fw-bold mb-3">نیاز به مشاوره برای این محصول دارید؟</h2>
                    <p class="text-muted mb-4">
                        برای دریافت اطلاعات بیشتر، استعلام قیمت یا مشاوره تخصصی، با کارشناسان ما در تماس باشید.
                    </p>
                    @php
                        $inquiryRoute = app()->getLocale() === 'fa'
                            ? 'website.inquiry.create'
                            : 'localized.website.inquiry.create';
                        $inquiryParams = app()->getLocale() === 'fa'
                            ? []
                            : ['locale' => app()->getLocale()];
                        $inquiryRouteExists = \Illuminate\Support\Facades\Route::has($inquiryRoute);
                    @endphp
                    @if($inquiryRouteExists)
                        <a href="{{ route($inquiryRoute, $inquiryParams) }}" class="btn btn-success btn-lg">
                            درخواست مشاوره و استعلام
                        </a>
                    @else
                        <span class="text-muted">
                            برای درخواست مشاوره، با ما تماس بگیرید.
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection