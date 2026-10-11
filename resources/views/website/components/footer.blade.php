<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row">
            {{-- Column 1: About Company --}}
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="fw-bold mb-3">آرتیمان صنعت</h5>
                <p class="text-white-50 mb-0">
                    تولیدکننده برج‌های خنک‌کننده صنعتی
                </p>
            </div>

            {{-- Column 2: Quick Links --}}
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="fw-bold mb-3">دسترسی سریع</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('website.home') }}" class="text-white-50 text-decoration-none">
                            خانه
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('website.products.index') }}" class="text-white-50 text-decoration-none">
                            محصولات
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('website.services') }}" class="text-white-50 text-decoration-none">
                            خدمات
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('website.about') }}" class="text-white-50 text-decoration-none">
                            درباره ما
                        </a>
                    </li>
                    <li class="mb-0">
                        <a href="{{ route('website.contact') }}" class="text-white-50 text-decoration-none">
                            تماس با ما
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Column 3: Contact Information --}}
            <div class="col-lg-4">
                <h5 class="fw-bold mb-3">اطلاعات تماس</h5>
                <ul class="list-unstyled text-white-50 mb-0">
                    <li class="mb-2">تلفن: [درج شماره تلفن]</li>
                    <li class="mb-2">ایمیل: [درج ایمیل]</li>
                    <li class="mb-0">آدرس: [درج آدرس]</li>
                </ul>
            </div>
        </div>

        {{-- Copyright Bar --}}
        <div class="border-top border-secondary mt-4 pt-3">
            <p class="text-center text-white-50 mb-0">
                &copy; {{ date('Y') }} آرتیمان صنعت. تمامی حقوق محفوظ است.
            </p>
        </div>
    </div>
</footer>