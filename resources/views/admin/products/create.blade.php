
@extends('admin.layouts.app')

@section('title', 'ثبت محصول جدید')

@section('content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1">ثبت محصول جدید</h1>
            <p class="text-muted mb-0">اطلاعات محصول را وارد کنید.</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
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

    <form action="{{ route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <strong>اطلاعات اصلی محصول</strong>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="title" class="form-label">عنوان محصول *</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="form-control"
                            value="{{ old('title') }}"
                            placeholder="مثلاً برج خنک‌کننده مدل OCS-33"
                            required
                        >
                    </div>

                    <div class="col-md-4">
                        <label for="category_id" class="form-label">دسته‌بندی</label>
                        <select id="category_id" name="category_id" class="form-select">
                            <option value="">بدون دسته‌بندی</option>
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="slug" class="form-label">نشانی انگلیسی محصول (Slug)</label>
                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            class="form-control"
                            value="{{ old('slug') }}"
                            placeholder="ocs-33-cooling-tower"
                            dir="ltr"
                        >
                        <div class="form-text">در صورت خالی بودن، سیستم آن را تولید می‌کند.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">وضعیت انتشار</label>
                        <div class="form-check mt-2">
                            <input
                                type="checkbox"
                                id="is_published"
                                name="is_published"
                                value="1"
                                class="form-check-input"
                                @checked(old('is_published'))
                            >
                            <label for="is_published" class="form-check-label">
                                انتشار محصول در سایت
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="short_description" class="form-label">توضیحات کوتاه</label>
                        <textarea
                            id="short_description"
                            name="short_description"
                            rows="3"
                            class="form-control"
                        >{{ old('short_description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label for="full_description" class="form-label">توضیحات کامل</label>
                        <textarea
                            id="full_description"
                            name="full_description"
                            rows="6"
                            class="form-control"
                        >{{ old('full_description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <strong>تصاویر محصول</strong>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">آدرس تصویر</label>
                    <input
                        type="url"
                        name="images[]"
                        class="form-control"
                        value="{{ old('images.0') }}"
                        placeholder="https://example.com/product.jpg"
                        dir="ltr"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">آدرس تصویر دوم (اختیاری)</label>
                    <input
                        type="url"
                        name="images[]"
                        class="form-control"
                        value="{{ old('images.1') }}"
                        placeholder="https://example.com/product-2.jpg"
                        dir="ltr"
                    >
                </div>

                <div>
                    <label for="image_uploads" class="form-label">یا بارگذاری تصویر از کامپیوتر</label>
                    <input
                        type="file"
                        id="image_uploads"
                        name="image_uploads[]"
                        class="form-control"
                        accept="image/*"
                        multiple
                    >
                    <div class="form-text">حداکثر حجم هر تصویر ۵ مگابایت است.</div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <strong>مشخصات فنی</strong>
            </div>

            <div class="card-body">
                <p class="text-muted small">
                    برای هر مشخصه، نام، مقدار و واحد را وارد کنید. ردیف‌های خالی ذخیره نمی‌شوند.
                </p>

                @for ($i = 0; $i < 3; $i++)
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">نام مشخصه {{ $i + 1 }}</label>
                            <input
                                type="text"
                                name="specs[{{ $i }}][key]"
                                class="form-control"
                                value="{{ old("specs.$i.key") }}"
                                placeholder="مثلاً ظرفیت اسمی"
                            >
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">مقدار</label>
                            <input
                                type="text"
                                name="specs[{{ $i }}][value]"
                                class="form-control"
                                value="{{ old("specs.$i.value") }}"
                                placeholder="مثلاً 33"
                            >
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">واحد</label>
                            <input
                                type="text"
                                name="specs[{{ $i }}][unit]"
                                class="form-control"
                                value="{{ old("specs.$i.unit") }}"
                                placeholder="مثلاً تن تبرید"
                            >
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <strong>اطلاعات سئو</strong>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label for="meta_title" class="form-label">عنوان سئو</label>
                    <input
                        type="text"
                        id="meta_title"
                        name="meta_title"
                        class="form-control"
                        value="{{ old('meta_title') }}"
                    >
                </div>

                <div>
                    <label for="meta_description" class="form-label">توضیحات سئو</label>
                    <textarea
                        id="meta_description"
                        name="meta_description"
                        rows="3"
                        class="form-control"
                    >{{ old('meta_description') }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-success px-4">
                ذخیره محصول
            </button>

            <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                انصراف
            </a>
        </div>
    </form>
</div>
@endsection
