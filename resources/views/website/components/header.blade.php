<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('website.home') }}">
            آرتیمان صنعت
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="باز کردن منو">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('website.home') }}">خانه</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('website.products.index') }}">محصولات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('website.services') }}">خدمات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('website.about') }}">درباره ما</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('website.contact') }}">تماس با ما</a>
                </li>
            </ul>

            <div class="d-flex flex-wrap align-items-center gap-2">
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-success">
                            پنل مدیریت
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success">
                            حساب کاربری
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-success">
                        ورود به سیستم
                    </a>
                @endauth

                <a href="{{ route('website.inquiry.create') }}" class="btn btn-primary">
                    درخواست مشاوره
                </a>
            </div>
        </div>
    </div>
</nav>
