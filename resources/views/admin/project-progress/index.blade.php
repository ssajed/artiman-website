@extends('admin.layouts.app')

@section('title', 'پیشرفت پروژه')

@section('content')
<style>
    .project-progress {
        --progress-green: #237747;
        --progress-border: #e1e7e3;
        color: #26332c;
    }

    .project-progress-header,
    .progress-panel-heading,
    .activity-heading,
    .schedule-day-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .project-progress-header {
        flex-wrap: wrap;
        margin-bottom: 22px;
    }

    .project-progress-header h1 {
        margin: 0 0 6px;
        font-size: 24px;
        font-weight: 800;
    }

    .project-progress-header p {
        margin: 0;
        color: #78867d;
        line-height: 1.8;
    }

    .project-progress-card {
        padding: 20px;
        border: 1px solid var(--progress-border);
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 4px 16px rgba(24, 61, 42, .04);
    }

    .progress-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .summary-card strong {
        display: block;
        margin-bottom: 8px;
        color: #78867d;
        font-size: 12px;
        font-weight: 600;
    }

    .summary-card span {
        color: #20392c;
        font-size: 25px;
        font-weight: 800;
    }

    .progress-track {
        height: 9px;
        overflow: hidden;
        border-radius: 10px;
        background: #edf2ee;
    }

    .progress-track span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: var(--progress-green);
    }

    .progress-panel-heading {
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .progress-panel-heading h2,
    .section-heading {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
    }

    .progress-panel-heading a {
        text-decoration: none;
    }

    .phase-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 20px;
    }

    .phase-item {
        padding: 14px;
        border: 1px solid #edf1ee;
        border-radius: 12px;
    }

    .phase-item strong {
        font-size: 13px;
        font-weight: 750;
    }

    .phase-item .phase-progress-value {
        color: var(--progress-green);
        font-weight: 800;
    }

    .phase-item .progress-track {
        height: 6px;
        margin-top: 10px;
    }

    .attention-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .attention-card h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
    }

    .attention-count {
        min-width: 28px;
        padding: 3px 8px;
        border-radius: 20px;
        background: #eff4f0;
        color: #45634f;
        font-size: 12px;
        text-align: center;
    }

    .attention-card.overdue .attention-count {
        background: #fff0ed;
        color: #a53b32;
    }

    .activity-list {
        display: grid;
        gap: 10px;
        margin-top: 14px;
    }

    .activity-item {
        padding: 13px;
        border: 1px solid #edf1ee;
        border-radius: 11px;
    }

    .activity-heading {
        align-items: flex-start;
    }

    .activity-heading a {
        color: #26332c;
        font-weight: 750;
        text-decoration: none;
    }

    .activity-heading a:hover {
        color: var(--progress-green);
    }

    .activity-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 8px;
        color: #748179;
        font-size: 11px;
    }

    .status-pill,
    .priority-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 9px;
        border-radius: 20px;
        background: #f0f3f1;
        color: #57645c;
        font-size: 11px;
        white-space: nowrap;
    }

    .status-pill.status-completed {
        background: #e6f4ea;
        color: #237747;
    }

    .status-pill.status-in_progress {
        background: #e9f1ff;
        color: #315f9e;
    }

    .status-pill.status-overdue {
        background: #fff0ed;
        color: #a53b32;
    }

    .priority-pill.priority-critical,
    .priority-pill.priority-high {
        background: #fff2e2;
        color: #8c5715;
    }

    .empty-state {
        margin: 12px 0 0;
        color: #859087;
        font-size: 13px;
    }

    .schedule-panel {
        margin-bottom: 22px;
    }

    .schedule-panel > .section-heading {
        margin-bottom: 14px;
    }

    .schedule-list {
        display: grid;
        gap: 10px;
    }

    .schedule-day {
        display: grid;
        grid-template-columns: minmax(145px, .24fr) minmax(0, 1fr);
        gap: 16px;
        padding: 15px;
        border: 1px solid #edf1ee;
        border-radius: 12px;
    }

    .schedule-day.is-today {
        border-color: #9cc8aa;
        background: #fbfefc;
    }

    .schedule-day.is-closed {
        background: #f7f8f7;
        color: #849087;
    }

    .schedule-day-date {
        font-size: 13px;
        font-weight: 800;
    }

    .schedule-day-name {
        margin-top: 4px;
        color: #78867d;
        font-size: 11px;
    }

    .schedule-activity {
        margin-bottom: 9px;
    }

    .schedule-activity:last-child {
        margin-bottom: 0;
    }

    .schedule-activity a {
        color: #26332c;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
    }

    .schedule-activity p {
        margin: 4px 0 0;
        color: #78867d;
        font-size: 11px;
    }

    .holiday-note {
        color: #78867d;
        font-size: 12px;
    }

    .project-flash {
        margin-bottom: 16px;
    }

    @media (max-width: 760px) {
        .progress-summary,
        .attention-grid {
            grid-template-columns: 1fr;
        }

        .phase-grid {
            grid-template-columns: 1fr;
        }

        .schedule-day {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .project-progress-header h1 {
            font-size: 21px;
        }
    }
</style>

<div class="project-progress" dir="rtl">
    <div class="project-progress-header">
        <div>
            <h1>پیشرفت پروژه سایت</h1>
            <p>برنامه تا موعد تحویل {{ $deliveryDateJalali }}؛ پنج‌شنبه و جمعه روز غیرکاری هستند.</p>
        </div>
        <a href="{{ route('admin.project-progress.activities.create') }}" class="btn btn-success">
            + افزودن فعالیت
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success project-flash">{{ session('success') }}</div>
    @endif

    <section class="progress-summary" aria-label="خلاصه پیشرفت پروژه">
        <div class="project-progress-card summary-card">
            <strong>پیشرفت کل پروژه</strong>
            <span>{{ $overallProgress }}٪</span>
            <div class="progress-track mt-2" role="progressbar" aria-valuenow="{{ $overallProgress }}" aria-valuemin="0" aria-valuemax="100">
                <span style="width: {{ $overallProgress }}%"></span>
            </div>
        </div>
        <div class="project-progress-card summary-card">
            <strong>فعالیت‌های امروز</strong>
            <span>{{ $todayActivities->count() }}</span>
        </div>
        <div class="project-progress-card summary-card">
            <strong>فعالیت‌های عقب‌افتاده</strong>
            <span>{{ $overdueActivities->count() }}</span>
        </div>
    </section>

    <section class="attention-grid">
        <div class="project-progress-card attention-card overdue">
            <div class="progress-panel-heading">
                <h2>کارهای عقب‌افتاده</h2>
                <span class="attention-count">{{ $overdueActivities->count() }}</span>
            </div>
            @if ($overdueActivities->isEmpty())
                <p class="empty-state">در حال حاضر فعالیت عقب‌افتاده‌ای نداریم.</p>
            @else
                <div class="activity-list">
                    @foreach ($overdueActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-heading">
                                <a href="{{ route('admin.project-progress.activities.edit', $activity) }}">{{ $activity->title }}</a>
                                <span class="status-pill status-overdue">عقب‌افتاده</span>
                            </div>
                            <div class="activity-meta">
                                <span>{{ $activity->phase->name }}</span>
                                <span>شروع: {{ \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($activity->start_date) }}</span>
                                <span>پایان: {{ \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($activity->end_date) }}</span>
                                <span class="priority-pill priority-{{ $activity->priority }}">
                                    اولویت:
                                    @switch($activity->priority)
                                        @case('critical') بحرانی @break
                                        @case('high') بالا @break
                                        @case('low') پایین @break
                                        @default متوسط
                                    @endswitch
                                </span>
                            </div>
                            @if ($activity->description)
                                <p class="empty-state">{{ $activity->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="project-progress-card attention-card">
            <div class="progress-panel-heading">
                <h2>فعالیت‌های امروز — {{ \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($today) }}</h2>
                <span class="attention-count">{{ $todayActivities->count() }}</span>
            </div>
            @if ($todayActivities->isEmpty())
                <p class="empty-state">برای امروز فعالیتی برنامه‌ریزی نشده است.</p>
            @else
                <div class="activity-list">
                    @foreach ($todayActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-heading">
                                <a href="{{ route('admin.project-progress.activities.edit', $activity) }}">{{ $activity->title }}</a>
                                <span class="status-pill status-{{ $activity->effective_status }}">
                                    @switch($activity->effective_status)
                                        @case('completed') انجام‌شده @break
                                        @case('in_progress') در حال انجام @break
                                        @case('overdue') عقب‌افتاده @break
                                        @default انجام‌نشده
                                    @endswitch
                                </span>
                            </div>
                            <div class="activity-meta">
                                <span>{{ $activity->phase->name }}</span>
                                <span>شروع: {{ \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($activity->start_date) }}</span>
                                <span>پایان: {{ \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($activity->end_date) }}</span>
                                <span class="priority-pill priority-{{ $activity->priority }}">
                                    اولویت:
                                    @switch($activity->priority)
                                        @case('critical') بحرانی @break
                                        @case('high') بالا @break
                                        @case('low') پایین @break
                                        @default متوسط
                                    @endswitch
                                </span>
                            </div>
                            @if ($activity->description)
                                <p class="empty-state">{{ $activity->description }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="project-progress-card schedule-panel">
        <div class="progress-panel-heading">
            <h2 class="section-heading">برنامه روزانه تا موعد تحویل</h2>
            <a href="{{ route('admin.project-progress.activities.create') }}" class="btn btn-sm btn-outline-success">
                افزودن فعالیت
            </a>
        </div>

        <div class="schedule-list">
            @forelse ($calendarDays as $day)
                <article class="schedule-day {{ $day['working'] ? '' : 'is-closed' }} {{ $day['date']->isSameDay($today) ? 'is-today' : '' }}">
                    <div>
                        <div class="schedule-day-date">{{ \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($day['date']) }}</div>
                        <div class="schedule-day-name">
                            {{ \App\Modules\ProjectProgress\Support\ProjectCalendar::weekdayName($day['date']) }}
                            @if (! $day['working']) · تعطیل @endif
                        </div>
                    </div>
                    <div>
                        @if (! $day['working'])
                            <span class="holiday-note">
                                @if ($day['date']->isSameDay($deliveryDate))
                                    تعطیل تقویمی — موعد هدف تحویل پروژه، بدون فعالیت کاری.
                                @else
                                    روز غیرکاری — فعالیتی زمان‌بندی نمی‌شود.
                                @endif
                            </span>
                        @elseif ($day['activities']->isEmpty())
                            <span class="holiday-note">فعالیتی برنامه‌ریزی نشده است.</span>
                        @else
                            @foreach ($day['activities'] as $activity)
                                <div class="schedule-activity">
                                    <a href="{{ route('admin.project-progress.activities.edit', $activity) }}">{{ $activity->title }}</a>
                                    <p>
                                        {{ $activity->phase->name }} ·
                                        @switch($activity->effective_status)
                                            @case('completed') انجام‌شده @break
                                            @case('in_progress') در حال انجام @break
                                            @case('overdue') عقب‌افتاده @break
                                            @default انجام‌نشده
                                        @endswitch
                                        · اولویت
                                        @switch($activity->priority)
                                            @case('critical') بحرانی @break
                                            @case('high') بالا @break
                                            @case('low') پایین @break
                                            @default متوسط
                                        @endswitch
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </article>
            @empty
                <p class="empty-state">موعد تحویل گذشته است؛ برای ادامه، تاریخ فعالیت‌ها را بازبینی کنید.</p>
            @endforelse
        </div>
    </section>

    <section class="project-progress-card">
        <h2 class="section-heading">پیشرفت مرحله‌ها</h2>
        @if ($phases->isEmpty())
            <p class="empty-state">مرحله‌ای برای پروژه ثبت نشده است.</p>
        @else
            <div class="phase-grid">
                @foreach ($phases as $phase)
                    <div class="phase-item">
                        <div class="progress-panel-heading">
                            <strong>{{ $phase->name }}</strong>
                            <span class="phase-progress-value">{{ $phase->progress_percent }}٪</span>
                        </div>
                        <div class="progress-track" role="progressbar" aria-valuenow="{{ $phase->progress_percent }}" aria-valuemin="0" aria-valuemax="100">
                            <span style="width: {{ $phase->progress_percent }}%"></span>
                        </div>
                        <div class="activity-meta">{{ $phase->activities->count() }} فعالیت</div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="project-progress-card mt-4">
        <div class="progress-panel-heading">
            <h2 class="section-heading">همه فعالیت‌ها</h2>
            <span class="attention-count">{{ $activities->count() }}</span>
        </div>
        @if ($activities->isEmpty())
            <p class="empty-state">هنوز فعالیتی ثبت نشده است.</p>
        @else
            <div class="activity-list">
                @foreach ($activities as $activity)
                    <div class="activity-item">
                        <div class="activity-heading">
                            <a href="{{ route('admin.project-progress.activities.edit', $activity) }}">{{ $activity->title }}</a>
                            <span class="status-pill status-{{ $activity->effective_status }}">
                                @switch($activity->effective_status)
                                    @case('completed') انجام‌شده @break
                                    @case('in_progress') در حال انجام @break
                                    @case('overdue') عقب‌افتاده @break
                                    @default انجام‌نشده
                                @endswitch
                            </span>
                        </div>
                        <div class="activity-meta">
                            <span>{{ $activity->phase->name }}</span>
                            <span>شروع: {{ \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($activity->start_date) }}</span>
                            <span>پایان: {{ \App\Modules\ProjectProgress\Support\ProjectCalendar::toJalali($activity->end_date) }}</span>
                            <span class="priority-pill priority-{{ $activity->priority }}">
                                @switch($activity->priority)
                                    @case('critical') بحرانی @break
                                    @case('high') بالا @break
                                    @case('low') پایین @break
                                    @default متوسط
                                @endswitch
                            </span>
                            <a href="{{ route('admin.project-progress.activities.edit', $activity) }}">ویرایش</a>
                        </div>
                        @if ($activity->description)
                            <p class="empty-state">{{ $activity->description }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
