@extends('website.layouts.app')

@section('title', 'تماس با ما')

@section('meta')
    <meta name="description" content="تماس با آرتیمان صنعت">
    <meta property="og:title" content="تماس با ما">
    <meta property="og:description" content="تماس با آرتیمان صنعت">
    <meta property="og:type" content="website">
@endsection

@section('content')
    {{-- Hero Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-5 fw-bold mb-3">تماس با ما</h1>
                    <p class="lead mb-0">[محتوای معرفی بخش تماس - placeholder]</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Information Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                {{-- Column 1: Contact Details --}}
                <div class="col-lg-6">
                    <div class="bg-white p-4 rounded shadow-sm h-100">
                        <h2 class="h4 fw-bold mb-4">اطلاعات تماس</h2>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <strong>تلفن:</strong>
                                <span class="text-muted">[درج شماره تلفن]</span>
                            </li>
                            <li class="mb-3">
                                <strong>ایمیل:</strong>
                                <span class="text-muted">[درج ایمیل]</span>
                            </li>
                            <li class="mb-3">
                                <strong>آدرس:</strong>
                                <span class="text-muted">[درج آدرس]</span>
                            </li>
                            <li class="mb-0">
                                <strong>کد پستی:</strong>
                                <span class="text-muted">[درج کد پستی]</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Column 2: Working Hours --}}
                <div class="col-lg-6">
                    <div class="bg-white p-4 rounded shadow-sm h-100">
                        <h2 class="h4 fw-bold mb-4">ساعات کاری</h2>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <strong>شنبه تا چهارشنبه:</strong>
                                <span class="text-muted">[درج ساعات کاری]</span>
                            </li>
                            <li class="mb-3">
                                <strong>پنج‌شنبه:</strong>
                                <span class="text-muted">[درج ساعات کاری]</span>
                            </li>
                            <li class="mb-0">
                                <strong>جمعه:</strong>
                                <span class="text-muted">[درج ساعات کاری]</span>
                            </li>
                        </ul>
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