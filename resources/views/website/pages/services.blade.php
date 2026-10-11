@extends('website.layouts.app')

@section('title', 'خدمات')

@section('meta')
    <meta name="description" content="خدمات آرتیمان صنعت">
    <meta property="og:title" content="خدمات">
    <meta property="og:description" content="خدمات آرتیمان صنعت">
    <meta property="og:type" content="website">
@endsection

@section('content')
    {{-- Hero Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-3">خدمات</h1>
                    <p class="lead mb-0">[محتوای معرفی خدمات - placeholder]</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Services List Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                {{-- Service 1 --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">[عنوان خدمت ۱]</h5>
                            <p class="card-text text-muted mb-0">[توضیح خدمت ۱ - placeholder]</p>
                        </div>
                    </div>
                </div>

                {{-- Service 2 --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">[عنوان خدمت ۲]</h5>
                            <p class="card-text text-muted mb-0">[توضیح خدمت ۲ - placeholder]</p>
                        </div>
                    </div>
                </div>

                {{-- Service 3 --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">[عنوان خدمت ۳]</h5>
                            <p class="card-text text-muted mb-0">[توضیح خدمت ۳ - placeholder]</p>
                        </div>
                    </div>
                </div>

                {{-- Service 4 --}}
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">[عنوان خدمت ۴]</h5>
                            <p class="card-text text-muted mb-0">[توضیح خدمت ۴ - placeholder]</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h4 fw-bold mb-3">نیاز به مشاوره دارید؟</h2>
                    <p class="text-muted mb-4">[متن CTA - placeholder]</p>
                    <a href="{{ route('website.inquiry.create') }}" class="btn btn-primary btn-lg">
                        درخواست مشاوره
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection