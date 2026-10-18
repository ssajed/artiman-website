
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">مدیریت دسته‌بندی‌ها</h1>
            <p class="text-muted mb-0">
                مدیریت گروه‌بندی محصولات آرتیمان صنعت
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-success">
            <span class="me-1">+</span>
            ثبت دسته‌بندی جدید
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="بستن"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3" style="width: 80px;">ردیف</th>
                            <th>نام دسته‌بندی</th>
                            <th>شناسه انگلیسی</th>
                            <th>دسته‌بندی والد</th>
                            <th class="text-center">تعداد محصولات</th>
                            <th class="text-center">ترتیب نمایش</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="px-3">
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $category->name }}
                                </td>

                                <td>
                                    <code dir="ltr">{{ $category->slug }}</code>
                                </td>

                                <td>
                                    {{ $category->parent?->name ?? '—' }}
                                </td>

                                <td class="text-center">
                                    <span class="badge text-bg-light">
                                        {{ $category->products_count }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    {{ $category->sort_order }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        هنوز دسته‌بندی‌ای ثبت نشده است.
                                    </div>

                                    <a href="{{ route('admin.categories.create') }}"
                                       class="btn btn-outline-success">
                                        ثبت اولین دسته‌بندی
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($categories->hasPages())
            <div class="card-footer bg-white">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
