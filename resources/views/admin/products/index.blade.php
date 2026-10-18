@extends('admin.layouts.app')

@section('title', 'مدیریت محصولات')

@section('content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 mb-1">مدیریت محصولات</h1>
            <p class="text-muted mb-0">فهرست و مدیریت محصولات آرتیمان صنعت</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            + ثبت محصول جدید
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>عنوان محصول</th>
                        <th>دسته‌بندی</th>
                        <th>وضعیت انتشار</th>
                        <th>شناسه</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                <strong>{{ $product->title }}</strong>
                                <div class="small text-muted">{{ $product->slug }}</div>
                            </td>
                            <td>{{ $product->category?->name ?? 'بدون دسته‌بندی' }}</td>
                            <td>
                                @if ($product->is_published)
                                    <span class="badge bg-success">منتشر شده</span>
                                @else
                                    <span class="badge bg-secondary">پیش‌نویس</span>
                                @endif
                            </td>
                            <td>{{ $product->id }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-sm btn-outline-success">
                                    ✏️ ویرایش
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                هنوز محصولی ثبت نشده است.
                                <div class="mt-3">
                                    <a href="{{ route('admin.products.create') }}"
                                       class="btn btn-outline-success btn-sm">
                                        ثبت اولین محصول
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="card-footer bg-white">{{ $products->links() }}</div>
        @endif
    </div>
</div>
@endsection