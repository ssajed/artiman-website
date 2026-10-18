
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">ثبت دسته‌بندی جدید</h1>
            <p class="text-muted mb-0">ایجاد دسته‌بندی برای محصولات آرتیمان صنعت</p>
        </div>

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-outline-secondary">
            بازگشت به فهرست
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>لطفاً خطاهای زیر را اصلاح کنید:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">
                            نام دسته‌بندی <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            maxlength="255"
                            required
                            autofocus
                            placeholder="مثلاً برج خنک‌کننده"
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="slug" class="form-label fw-semibold">
                            شناسه انگلیسی (Slug)
                        </label>
                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            class="form-control"
                            dir="ltr"
                            value="{{ old('slug') }}"
                            maxlength="255"
                            placeholder="cooling-towers"
                        >
                        <small class="text-muted">
                            اختیاری؛ برای آدرس صفحه محصول استفاده می‌شود.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label for="parent_id" class="form-label fw-semibold">
                            دسته‌بندی والد
                        </label>
                        <select id="parent_id" name="parent_id" class="form-select">
                            <option value="">بدون والد (دسته‌بندی اصلی)</option>
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('parent_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="sort_order" class="form-label fw-semibold">
                            ترتیب نمایش
                        </label>
                        <input
                            type="number"
                            id="sort_order"
                            name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order', 0) }}"
                            min="0"
                        >
                        <small class="text-muted">
                            عدد کمتر، اولویت نمایش بالاتری دارد.
                        </small>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">
                            توضیحات
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            class="form-control"
                            rows="4"
                            maxlength="2000"
                            placeholder="توضیح کوتاهی درباره این دسته‌بندی..."
                        >{{ old('description') }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4">
                        ثبت دسته‌بندی
                    </button>

                    <a href="{{ route('admin.categories.index') }}"
                       class="btn btn-light border">
                        انصراف
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
