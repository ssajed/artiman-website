@extends('admin.layouts.app')

@php use Illuminate\Support\Facades\Storage; @endphp

@section('title', 'ویرایش محصول')

@section('content')
@php
    $formSpecs = old('specs', $product->specs ?? []);
    $formSpecs = array_values($formSpecs);
    $specRows = max(3, count($formSpecs));
    $formImages = old('images', $product->images ?? []);
@endphp

<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1">ویرایش محصول</h1>
            <p class="text-muted mb-0">{{ $product->title }}</p>
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

    <form action="{{ route('admin.products.update', $product) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3"><strong>اطلاعات اصلی محصول</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="title" class="form-label">عنوان محصول *</label>
                        <input type="text" id="title" name="title" class="form-control"
                               value="{{ old('title', $product->title) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="category_id" class="form-label">دسته‌بندی</label>
                        <select id="category_id" name="category_id" class="form-select">
                            <option value="">بدون دسته‌بندی</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @selected(old('category_id', $product->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="slug" class="form-label">آدرس انگلیسی محصول (Slug)</label>
                        <input type="text" id="slug" name="slug" class="form-control"
                               value="{{ old('slug', $product->slug) }}" dir="ltr">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">وضعیت انتشار</label>
                        <div class="form-check mt-2">
                            <input type="checkbox" id="is_published" name="is_published"
                                   value="1" class="form-check-input"
                                   @checked(old('is_published', $product->is_published))>
                            <label for="is_published" class="form-check-label">
                                انتشار محصول در سایت
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="short_description" class="form-label">توضیحات کوتاه</label>
                        <textarea id="short_description" name="short_description" rows="3"
                                  class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label for="full_description" class="form-label">توضیحات کامل</label>
                        <textarea id="full_description" name="full_description" rows="6"
                                  class="form-control">{{ old('full_description', $product->full_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3"><strong>تصاویر محصول</strong></div>
            <div class="card-body">
                @if (count($formImages))
                    <p class="text-muted small">برای حذف تصویر، گزینه زیر آن را انتخاب کن.</p>
                    <div class="row g-3 mb-4">
                        @foreach ($formImages as $image)
                            @if (filled($image))
                                <div class="col-6 col-md-3">
                                    @if (filter_var($image, FILTER_VALIDATE_URL))
                                        <img src="{{ $image }}" alt="تصویر محصول"
                                             class="img-thumbnail w-100 mb-2"
                                             style="height:150px;object-fit:contain">
                                    @else
                                        <img src="{{ Storage::disk('public')->url($image) }}"
                                             alt="تصویر محصول" class="img-thumbnail w-100 mb-2"
                                             style="height:150px;object-fit:contain">
                                    @endif
                                    <input type="hidden" name="images[]" value="{{ $image }}">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                               name="remove_images[]" value="{{ $image }}"
                                               id="remove-image-{{ $loop->index }}"
                                               @checked(in_array($image, old('remove_images', []), true))>
                                        <label class="form-check-label"
                                               for="remove-image-{{ $loop->index }}">حذف این تصویر</label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">برای این محصول تصویری ثبت نشده است.</p>
                @endif

                <div>
                    <label for="image_uploads" class="form-label">افزودن تصاویر جدید</label>
                    <input type="file" id="image_uploads" name="image_uploads[]"
                           class="form-control" accept="image/*" multiple>
                    <div class="form-text">می‌توانی چند تصویر انتخاب کنی. حداکثر حجم هر تصویر ۵ مگابایت است.</div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3"><strong>مشخصات فنی</strong></div>
            <div class="card-body">
                <p class="text-muted small">برای هر مشخصه، نام، مقدار و واحد را وارد کن.</p>
                @for ($i = 0; $i < $specRows; $i++)
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">نام مشخصه {{ $i + 1 }}</label>
                            <input type="text" name="specs[{{ $i }}][key]" class="form-control"
                                   value="{{ old("specs.$i.key", $formSpecs[$i]['key'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">مقدار</label>
                            <input type="text" name="specs[{{ $i }}][value]" class="form-control"
                                   value="{{ old("specs.$i.value", $formSpecs[$i]['value'] ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">واحد</label>
                            <input type="text" name="specs[{{ $i }}][unit]" class="form-control"
                                   value="{{ old("specs.$i.unit", $formSpecs[$i]['unit'] ?? '') }}">
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3"><strong>اطلاعات سئو</strong></div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="meta_title" class="form-label">عنوان سئو</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-control"
                           value="{{ old('meta_title', $product->meta_title) }}">
                </div>
                <div>
                    <label for="meta_description" class="form-label">توضیحات سئو</label>
                    <textarea id="meta_description" name="meta_description" rows="3"
                              class="form-control">{{ old('meta_description', $product->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-success px-4">ذخیره تغییرات</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-light">انصراف</a>
        </div>
    </form>
</div>
@endsection