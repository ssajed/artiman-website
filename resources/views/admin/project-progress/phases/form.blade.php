@extends('admin.layouts.app')

@section('title', $isEditing ? 'ویرایش مرحله پروژه' : 'افزودن مرحله پروژه')

@section('content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h4 mb-1">{{ $isEditing ? 'ویرایش مرحله پروژه' : 'افزودن مرحله پروژه' }}</h1>
            <p class="text-muted mb-0">نام و ترتیب نمایش مرحله را ثبت کنید.</p>
        </div>
        <a href="{{ route('admin.project-progress.index') }}" class="btn btn-outline-secondary">بازگشت به پیشرفت پروژه</a>
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

    <form action="{{ $isEditing ? route('admin.project-progress.phases.update', $phase) : route('admin.project-progress.phases.store') }}"
          method="POST">
        @csrf
        @if ($isEditing)
            @method('PUT')
        @endif

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="name" class="form-label">نام مرحله *</label>
                        <input id="name" name="name" type="text" maxlength="255" required
                               class="form-control" value="{{ old('name', $phase->name) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="sort_order" class="form-label">ترتیب نمایش *</label>
                        <input id="sort_order" name="sort_order" type="number" min="0" max="65535" required
                               class="form-control" value="{{ old('sort_order', $phase->sort_order ?? 0) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <button type="submit" class="btn btn-success px-4">
                {{ $isEditing ? 'ذخیره تغییرات' : 'ثبت مرحله' }}
            </button>
            <a href="{{ route('admin.project-progress.index') }}" class="btn btn-light">انصراف</a>
        </div>
    </form>
</div>
@endsection
