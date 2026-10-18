
@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">ظ…ط¯غŒط±غŒطھ ط¯ط³طھظ‡â€Œط¨ظ†ط¯غŒâ€Œظ‡ط§</h1>
            <p class="text-muted mb-0">
                ظ…ط¯غŒط±غŒطھ ع¯ط±ظˆظ‡â€Œط¨ظ†ط¯غŒ ظ…ط­طµظˆظ„ط§طھ ط¢ط±طھغŒظ…ط§ظ† طµظ†ط¹طھ
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-success">
            <span class="me-1">+</span>
            ط«ط¨طھ ط¯ط³طھظ‡â€Œط¨ظ†ط¯غŒ ط¬ط¯غŒط¯
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="ط¨ط³طھظ†"></button>
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
                            <th class="px-3" style="width: 80px;">ط±ط¯غŒظپ</th>
                            <th>ظ†ط§ظ… ط¯ط³طھظ‡â€Œط¨ظ†ط¯غŒ</th>
                            <th>ط´ظ†ط§ط³ظ‡ ط§ظ†ع¯ظ„غŒط³غŒ</th>
                            <th>ط¯ط³طھظ‡â€Œط¨ظ†ط¯غŒ ظˆط§ظ„ط¯</th>
                            <th class="text-center">طھط¹ط¯ط§ط¯ ظ…ط­طµظˆظ„ط§طھ</th>
                            <th class="text-center">طھط±طھغŒط¨ ظ†ظ…ط§غŒط´</th>
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
                                    {{ $category->parent?->name ?? 'â€”' }}
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
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        ظ‡ظ†ظˆط² ط¯ط³طھظ‡â€Œط¨ظ†ط¯غŒâ€Œط§غŒ ط«ط¨طھ ظ†ط´ط¯ظ‡ ط§ط³طھ.
                                    </div>

                                    <a href="{{ route('admin.categories.create') }}"
                                       class="btn btn-outline-success">
                                        ط«ط¨طھ ط§ظˆظ„غŒظ† ط¯ط³طھظ‡â€Œط¨ظ†ط¯غŒ
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
