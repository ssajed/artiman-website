@extends('website.layouts.app')

@section('title', 'درباره ما')

@section('meta')
    <meta name="description" content="درباره آرتیمان صنعت">
    <meta property="og:title" content="درباره ما">
    <meta property="og:description" content="درباره آرتیمان صنعت">
    <meta property="og:type" content="website">
@endsection

@section('content')
    {{-- Hero Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-3">درباره ما</h1>
                    <p class="lead mb-0">[محتوای معرفی شرکت - placeholder]</p>
                </div>
            </div>
        </div>
    </section>

    {{-- About Content Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h2 class="h3 fw-bold mb-4">معرفی شرکت</h2>
                    <p class="mb-3">[پاراگراف ۱ معرفی شرکت - placeholder]</p>
                    <p class="mb-3">[پاراگراف ۲ معرفی شرکت - placeholder]</p>
                    <p class="mb-0">[پاراگراف ۳ معرفی شرکت - placeholder]</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Values Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h2 class="h3 fw-bold mb-4 text-center">ارزش‌های ما</h2>
                    <div class="row g-4">
                        {{-- Value 1 --}}
                        <div class="col-md-6">
                            <div class="bg-white p-4 rounded shadow-sm h-100">
                                <h5 class="fw-bold mb-2">[عنوان ارزش ۱]</h5>
                                <p class="text-muted mb-0">[توضیح ارزش ۱ - placeholder]</p>
                            </div>
                        </div>

                        {{-- Value 2 --}}
                        <div class="col-md-6">
                            <div class="bg-white p-4 rounded shadow-sm h-100">
                                <h5 class="fw-bold mb-2">[عنوان ارزش ۲]</h5>
                                <p class="text-muted mb-0">[توضیح ارزش ۲ - placeholder]</p>
                            </div>
                        </div>

                        {{-- Value 3 --}}
                        <div class="col-md-6">
                            <div class="bg-white p-4 rounded shadow-sm h-100">
                                <h5 class="fw-bold mb-2">[عنوان ارزش ۳]</h5>
                                <p class="text-muted mb-0">[توضیح ارزش ۳ - placeholder]</p>
                            </div>
                        </div>

                        {{-- Value 4 --}}
                        <div class="col-md-6">
                            <div class="bg-white p-4 rounded shadow-sm h-100">
                                <h5 class="fw-bold mb-2">[عنوان ارزش ۴]</h5>
                                <p class="text-muted mb-0">[توضیح ارزش ۴ - placeholder]</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="h4 fw-bold mb-3">سؤالی دارید؟</h2>
                    <p class="text-muted mb-4">[متن CTA - placeholder]</p>
                    <a href="{{ route('website.contact') }}" class="btn btn-primary btn-lg">
                        تماس با ما
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection