@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">ویرایش دسته‌بندی</h1>
            <p class="text-muted mb-0">ویرایش اطلاعات دسته‌بندی محصولات آرتیمان صنعت</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">بازگشت به فهرست</a>
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
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">نام دسته‌بندی <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="{{ old('name', $category->name) }}" maxlength="255" required autofocus>
                    </div>

                    <div class="col-md-6">
                        <label for="slug" class="form-label fw-semibold">شناسه انگلیسی (Slug)</label>
                        <input type="text" id="slug" name="slug" class="form-control" dir="ltr"
                               value="{{ old('slug', $category->slug) }}" maxlength="255">
                        <small class="text-muted">برای آدرس صفحه دسته‌بندی استفاده می‌شود.</small>
                    </div>

                    <div class="col-md-6">
                        <label for="parent_id" class="form-label fw-semibold">دسته‌بندی والد</label>
                        <select id="parent_id" name="parent_id" class="form-select">
                            <option value="">بدون والد (دسته‌بندی اصلی)</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}"
                                    @selected(old('parent_id', $category->parent_id) == $item->id)>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="sort_order" class="form-label fw-semibold">ترتیب نمایش</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control"
                               value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">توضیحات</label>
                        <textarea id="description" name="description" class="form-control" rows="4"
                                  maxlength="2000">{{ old('description', $category->description) }}</textarea>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4">ذخیره تغییرات</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light border">انصراف</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
