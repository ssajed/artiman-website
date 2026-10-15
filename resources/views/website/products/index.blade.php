@extends('website.layouts.app')

@section('title', 'محصولات')

@section('meta')
    <meta name="description" content="محصولات آرتیمان صنعت">
    @php
        $canonicalRoute = app()->getLocale() === 'fa' 
            ? 'website.products.index' 
            : 'localized.website.products.index';
        $canonicalParams = app()->getLocale() === 'fa' 
            ? [] 
            : ['locale' => app()->getLocale()];
    @endphp
    <link rel="canonical" href="{{ route($canonicalRoute, $canonicalParams) }}">
    <meta property="og:title" content="محصولات">
    <meta property="og:description" content="محصولات آرتیمان صنعت">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route($canonicalRoute, $canonicalParams) }}">
@endsection

@section('content')
    {{-- Hero Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-3">محصولات</h1>
                    <p class="lead text-muted mb-0">
                        مجموعه محصولات آرتیمان صنعت
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Products Grid --}}
    <section class="py-5">
        <div class="container">
            @if($products->isEmpty())
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <p class="text-muted fs-5">
                            در حال حاضر محصولی برای نمایش وجود ندارد.
                        </p>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    {{-- Category Badge --}}
                                    @if(isset($categoriesMap[$product['category_id']]))
                                        <span class="badge bg-success mb-3 align-self-start">
                                            {{ $categoriesMap[$product['category_id']] }}
                                        </span>
                                    @endif

                                    {{-- Product Title --}}
                                    <h5 class="card-title fw-bold mb-2">
                                        @php
                                            $routeName = app()->getLocale() === 'fa' 
                                                ? 'website.products.show' 
                                                : 'localized.website.products.show';
                                            $routeParams = app()->getLocale() === 'fa'
                                                ? ['slug' => $product['slug']]
                                                : ['locale' => app()->getLocale(), 'slug' => $product['slug']];
                                        @endphp
                                        <a href="{{ route($routeName, $routeParams) }}" 
                                           class="text-decoration-none text-dark stretched-link">
                                            {{ $product['title'] }}
                                        </a>
                                    </h5>

                                    {{-- Short Description --}}
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ \Illuminate\Support\Str::limit($product['short_description'] ?? '', 120) }}
                                    </p>

                                    {{-- View Details Button --}}
                                    <div class="mt-auto">
                                        <a href="{{ route($routeName, $routeParams) }}" 
                                           class="btn btn-success">
                                            مشاهده جزئیات
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h4 fw-bold mb-3">محصول موردنظر خود را پیدا نکردید؟</h2>
                    <p class="text-muted mb-4">
                        برای دریافت مشاوره تخصصی و راهنمایی در انتخاب محصول مناسب، با ما تماس بگیرید.
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
                            درخواست مشاوره
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