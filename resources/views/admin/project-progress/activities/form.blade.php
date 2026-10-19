@extends('admin.layouts.app')

@section('title', $isEditing ? 'ویرایش فعالیت پروژه' : 'افزودن فعالیت پروژه')

@section('content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h4 mb-1">{{ $isEditing ? 'ویرایش فعالیت پروژه' : 'افزودن فعالیت پروژه' }}</h1>
            <p class="text-muted mb-0">تاریخ‌ها را شمسی وارد کنید؛ نمونه روز کاری: ۱۴۰۵/۰۸/۰۲.</p>
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

    <form action="{{ $isEditing ? route('admin.project-progress.activities.update', $activity) : route('admin.project-progress.activities.store') }}"
          method="POST">
        @csrf
        @if ($isEditing)
            @method('PUT')
        @endif

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="title" class="form-label">عنوان فعالیت *</label>
                        <input id="title" name="title" type="text" maxlength="255" required
                               class="form-control" value="{{ old('title', $activity->title) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="phase_id" class="form-label">مرحله *</label>
                        <select id="phase_id" name="phase_id" required class="form-select">
                            <option value="">انتخاب مرحله</option>
                            @foreach ($phases as $phase)
                                <option value="{{ $phase->id }}"
                                    @selected(old('phase_id', $activity->phase_id) == $phase->id)>
                                    {{ $phase->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="start_date" class="form-label">تاریخ شروع شمسی *</label>
                        <input id="start_date" name="start_date" type="text" inputmode="numeric"
                               placeholder="۱۴۰۵/۰۸/۰۲" pattern="[0-9۰-۹٠-٩]{4}[-/][0-9۰-۹٠-٩]{1,2}[-/][0-9۰-۹٠-٩]{1,2}"
                               required dir="ltr" class="form-control"
                               value="{{ old('start_date', $isEditing ? \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($activity->start_date) : '') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="form-label">تاریخ پایان شمسی *</label>
                        <input id="end_date" name="end_date" type="text" inputmode="numeric"
                               placeholder="۱۴۰۵/۰۸/۰۳" pattern="[0-9۰-۹٠-٩]{4}[-/][0-9۰-۹٠-٩]{1,2}[-/][0-9۰-۹٠-٩]{1,2}"
                               required dir="ltr" class="form-control"
                               value="{{ old('end_date', $isEditing ? \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($activity->end_date) : '') }}">
                        <div class="form-text">پنج‌شنبه و جمعه روز غیرکاری هستند و در برنامه روزانه فعالیتی برای آن‌ها نمایش داده نمی‌شود.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">وضعیت *</label>
                        <select id="status" name="status" required class="form-select">
                            <option value="not_started" @selected(old('status', $activity->status) === 'not_started')>انجام‌نشده</option>
                            <option value="in_progress" @selected(old('status', $activity->status) === 'in_progress')>در حال انجام</option>
                            <option value="completed" @selected(old('status', $activity->status) === 'completed')>انجام‌شده</option>
                        </select>
                        @if ($isEditing && $activity->effective_status === 'overdue')
                            <div class="form-text text-danger">این فعالیت به‌صورت خودکار عقب‌افتاده محسوب می‌شود؛ تاریخ پایان یا وضعیت آن را به‌روزرسانی کنید.</div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="priority" class="form-label">اولویت *</label>
                        <select id="priority" name="priority" required class="form-select">
                            <option value="low" @selected(old('priority', $activity->priority) === 'low')>پایین</option>
                            <option value="medium" @selected(old('priority', $activity->priority) === 'medium')>متوسط</option>
                            <option value="high" @selected(old('priority', $activity->priority) === 'high')>بالا</option>
                            <option value="critical" @selected(old('priority', $activity->priority) === 'critical')>بحرانی</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">توضیحات و یادداشت‌های مدیر</label>
                        <textarea id="description" name="description" rows="5" maxlength="5000"
                                  class="form-control">{{ old('description', $activity->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <button type="submit" class="btn btn-success px-4">
                {{ $isEditing ? 'ذخیره تغییرات' : 'ثبت فعالیت' }}
            </button>
            <a href="{{ route('admin.project-progress.index') }}" class="btn btn-light">انصراف</a>
        </div>
    </form>
</div>
@endsection
