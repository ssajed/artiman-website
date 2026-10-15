@extends('identity.layouts.auth')

@section('title', 'ورود به پنل')

@section('content')
{{-- Container اصلی با dir="ltr" برای حفظ جایگاه فیزیکی ستون‌ها (عکس در چپ، فرم در راست) --}}
<div class="min-h-screen flex w-full" dir="ltr">
    
    {{-- پنل عکس کارخانه - سمت چپ بصری (در موبایل پنهان) --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden"
         style="background-image: url('{{ asset('images/login-background.jpg') }}'); background-size: cover; background-position: center;">
        
        {{-- لایه گرادیان سبز تیره و خاکستری برای خوانایی متن --}}
        <div class="absolute inset-0 bg-gradient-to-br from-green-900/85 via-green-800/75 to-gray-900/85"></div>
        
        {{-- محتوای پنل صنعتی - با dir="rtl" برای راست‌چین بودن متن فارسی --}}
        <div class="relative z-10 flex flex-col justify-between w-full p-12 text-white" dir="rtl">
            
            {{-- بخش بالایی: لوگوی واقعی --}}
            <div>
                <img src="{{ asset('images/Artiman-logo.svg') }}" 
                     alt="آرتیمان صنعت" 
                     class="h-14 w-auto opacity-95">
            </div>
            
            {{-- بخش میانی: تیتر و توضیحات --}}
            <div class="my-auto">
                <h2 class="text-4xl font-bold mb-6 leading-tight">
                    پیشرو در صنعت<br>
                    برج‌های خنک‌کننده
                </h2>
                <p class="text-lg text-white/90 leading-relaxed max-w-md">
                    آرتیمان صنعت، طراح و تولیدکننده برج‌های خنک‌کننده فایبرگلاس با استانداردهای بین‌المللی، همراه قابل اعتماد صنایع بزرگ کشور.
                </p>
                
                {{-- ویژگی‌های کلیدی --}}
                <div class="mt-10 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center backdrop-blur-sm flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <span class="text-white/95">کیفیت تضمین‌شده و استانداردهای ISO</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center backdrop-blur-sm flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-white/95">بازدهی بالا و مصرف بهینه انرژی</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center backdrop-blur-sm flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-white/95">پشتیبانی فنی و خدمات پس از فروش</span>
                    </div>
                </div>
            </div>
            
            {{-- بخش پایینی --}}
            <div class="text-sm text-white/70">
                www.artiman-sanat.com
            </div>
        </div>
    </div>
    
    {{-- بخش فرم ورود - سمت راست بصری --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 lg:p-12 bg-gray-50" dir="rtl">
        <div class="w-full max-w-md">
            
            {{-- لوگو و عنوان (فقط در موبایل) --}}
            <div class="text-center mb-8 lg:hidden">
                <img src="{{ asset('images/Artiman-logo.svg') }}" 
                     alt="آرتیمان صنعت" 
                     class="h-14 w-auto mx-auto mb-4">
                <h1 class="text-xl font-bold text-gray-800 mb-1">ورود به پنل آرتیمان صنعت</h1>
                <p class="text-gray-600 text-sm">برای دسترسی به پنل، اطلاعات خود را وارد کنید.</p>
            </div>
            
            {{-- عنوان دسکتاپ --}}
            <div class="hidden lg:block mb-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">ورود به پنل آرتیمان صنعت</h1>
                <p class="text-gray-600 text-sm">برای دسترسی به پنل مدیریت، اطلاعات خود را وارد کنید.</p>
            </div>
            
            {{-- فرم ورود --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    {{-- فیلد ایمیل --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            ایمیل
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                dir="ltr"
                                autocomplete="username"
                                class="w-full pr-10 pl-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent transition-colors text-gray-800 placeholder-gray-400 text-left @error('email') border-red-500 focus:ring-red-500 @enderror"
                                placeholder="example@artiman.com"
                            >
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- فیلد رمز عبور --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            رمز عبور
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required
                                dir="ltr"
                                autocomplete="current-password"
                                class="w-full pr-10 pl-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent transition-colors text-gray-800 placeholder-gray-400 text-left @error('password') border-red-500 focus:ring-red-500 @enderror"
                                placeholder="••••••••"
                            >
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    {{-- مرا به خاطر بسپار --}}
                    <div class="flex items-center">
                        <input 
                            id="remember" 
                            type="checkbox" 
                            name="remember" 
                            {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                        >
                        <label for="remember" class="mr-2 text-sm text-gray-700">
                            مرا به خاطر بسپار
                        </label>
                    </div>

                    {{-- دکمه ورود --}}
                    <button 
                        type="submit" 
                        class="w-full bg-green-700 hover:bg-green-800 text-white font-medium py-3 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 shadow-sm"
                    >
                        ورود به حساب
                    </button>
                </form>
            </div>

            {{-- کپی‌رایت --}}
            <div class="text-center mt-6">
                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} آرتیمان صنعت. تمامی حقوق محفوظ است.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection