@extends('website.layouts.app')

@section('title', 'آرتیمان صنعت — تولیدکننده برج‌های خنک‌کننده صنعتی')

@section('meta')
    <meta name="description" content="آرتیمان صنعت، تولیدکننده برج‌های خنک‌کننده صنعتی. ارائه راهکارهای خنک‌سازی برای صنایع مختلف.">
    <meta property="og:title" content="آرتیمان صنعت — تولیدکننده برج‌های خنک‌کننده صنعتی">
    <meta property="og:description" content="راهکارهای خنک‌سازی برای صنایع مختلف.">
    <meta property="og:type" content="website">
@endsection

@section('content')
    {{-- Hero Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">
                        آرتیمان صنعت
                    </h1>
                    <p class="lead mb-4">
                        تولیدکننده برج‌های خنک‌کننده صنعتی
                    </p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('website.products.index') }}" class="btn btn-primary btn-lg">
                            مشاهده محصولات
                        </a>
                        <a href="{{ route('website.inquiry.create') }}" class="btn btn-outline-secondary btn-lg">
                            درخواست مشاوره
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Introduction Section (Placeholder for future content) --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h2 class="h3 fw-bold mb-3">درباره آرتیمان صنعت</h2>
                    <p class="mb-0">
                        شرکت آرتیمان صنعت در زمینه طراحی و تولید برج‌های خنک‌کننده صنعتی فعالیت می‌کند. محصولات ما در صنایع مختلف از جمله نیروگاهی، پتروشیمی، فولاد و تهویه مطبوع مورد استفاده قرار می‌گیرند.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection