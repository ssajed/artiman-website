<?php

namespace App\Modules\ProjectProgress\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\ProjectProgress\Models\ProjectActivity;
use App\Modules\ProjectProgress\Models\ProjectPhase;
use App\Modules\ProjectProgress\Support\ProjectCalendar;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use InvalidArgumentException;

class ProjectProgressController extends Controller
{
    public function index(): View
    {
        $phases = ProjectPhase::query()
            ->with([
                'activities' => fn ($query) => $query->orderBy('start_date')->orderBy('id'),
                'activities.phase',
            ])
            ->orderBy('sort_order')
            ->get();
        $activities = $phases->flatMap->activities;
        $today = ProjectCalendar::today();
        $todayActivities = $activities->filter(fn (ProjectActivity $activity) =>
            $activity->start_date->toDateString() <= $today->toDateString()
            && $activity->end_date->toDateString() >= $today->toDateString()
            && $activity->status !== ProjectActivity::STATUS_COMPLETED
        );
        $overdueActivities = $activities
            ->filter(fn (ProjectActivity $activity) => $activity->effective_status === 'overdue')
            ->sortBy('end_date')
            ->values();
        $calendarDays = $this->buildCalendar($activities, $today);

        return view('admin.project-progress.index', [
            'phases' => $phases,
            'activities' => $activities,
            'todayActivities' => $todayActivities,
            'overdueActivities' => $overdueActivities,
            'calendarDays' => $calendarDays,
            'today' => $today,
            'deliveryDate' => CarbonImmutable::parse(ProjectCalendar::DELIVERY_DATE, ProjectCalendar::TIMEZONE),
            'deliveryDateJalali' => ProjectCalendar::toJalali(ProjectCalendar::DELIVERY_DATE),
            'overallProgress' => $this->calculateProgress($activities),
        ]);
    }

    public function create(): View
    {
        return view('admin.project-progress.activities.form', [
            'activity' => new ProjectActivity([
                'status' => ProjectActivity::STATUS_NOT_STARTED,
                'priority' => ProjectActivity::PRIORITY_MEDIUM,
            ]),
            'phases' => ProjectPhase::orderBy('sort_order')->get(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        ProjectActivity::create($validated);

        return redirect()->route('admin.project-progress.index')
            ->with('success', 'فعالیت پروژه ثبت شد.');
    }

    public function edit(ProjectActivity $activity): View
    {
        return view('admin.project-progress.activities.form', [
            'activity' => $activity,
            'phases' => ProjectPhase::orderBy('sort_order')->get(),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, ProjectActivity $activity): RedirectResponse
    {
        $activity->update($this->validatedData($request));

        return redirect()->route('admin.project-progress.index')
            ->with('success', 'تغییرات فعالیت ذخیره شد.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'phase_id' => ['required', 'integer', 'exists:project_progress_phases,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'start_date' => ['required', 'string', 'regex:/^[0-9۰-۹٠-٩]{4}[\/-][0-9۰-۹٠-٩]{1,2}[\/-][0-9۰-۹٠-٩]{1,2}$/u'],
            'end_date' => ['required', 'string', 'regex:/^[0-9۰-۹٠-٩]{4}[\/-][0-9۰-۹٠-٩]{1,2}[\/-][0-9۰-۹٠-٩]{1,2}$/u'],
            'status' => ['required', Rule::in([
                ProjectActivity::STATUS_NOT_STARTED,
                ProjectActivity::STATUS_IN_PROGRESS,
                ProjectActivity::STATUS_COMPLETED,
            ])],
            'priority' => ['required', Rule::in([
                ProjectActivity::PRIORITY_LOW,
                ProjectActivity::PRIORITY_MEDIUM,
                ProjectActivity::PRIORITY_HIGH,
                ProjectActivity::PRIORITY_CRITICAL,
            ])],
        ]);

        $validated['start_date'] = $this->parseJalaliDate($validated['start_date'], 'start_date');
        $validated['end_date'] = $this->parseJalaliDate($validated['end_date'], 'end_date');

        if ($validated['start_date'] > $validated['end_date']) {
            throw ValidationException::withMessages([
                'end_date' => 'تاریخ پایان باید برابر یا پس از تاریخ شروع باشد.',
            ]);
        }

        return $validated;
    }

    private function parseJalaliDate(string $date, string $field): string
    {
        try {
            $gregorianDate = ProjectCalendar::toGregorian($date);
        } catch (InvalidArgumentException $exception) {
            throw ValidationException::withMessages([
                $field => 'تاریخ شمسی واردشده معتبر نیست.',
            ]);
        }

        if (! ProjectCalendar::isWorkingDay(CarbonImmutable::parse($gregorianDate, ProjectCalendar::TIMEZONE))) {
            throw ValidationException::withMessages([
                $field => 'تاریخ شروع و پایان فعالیت باید در روز کاری باشد.',
            ]);
        }

        return $gregorianDate;
    }

    /**
     * @param Collection<int, ProjectActivity> $activities
     * @return array<int, array{date: CarbonImmutable, working: bool, activities: Collection<int, ProjectActivity>}>
     */
    private function buildCalendar(Collection $activities, CarbonImmutable $today): array
    {
        $deliveryDate = CarbonImmutable::parse(ProjectCalendar::DELIVERY_DATE, ProjectCalendar::TIMEZONE);

        if ($today->greaterThan($deliveryDate)) {
            return [];
        }

        $days = [];

        for ($date = $today; $date->lessThanOrEqualTo($deliveryDate); $date = $date->addDay()) {
            $working = ProjectCalendar::isWorkingDay($date);
            $dayActivities = $working
                ? $activities->filter(fn (ProjectActivity $activity) =>
                    $activity->start_date->toDateString() <= $date->toDateString()
                    && $activity->end_date->toDateString() >= $date->toDateString()
                )->values()
                : collect();

            $days[] = [
                'date' => $date,
                'working' => $working,
                'activities' => $dayActivities,
            ];
        }

        return $days;
    }

    /**
     * @param Collection<int, ProjectActivity> $activities
     */
    private function calculateProgress(Collection $activities): int
    {
        if ($activities->isEmpty()) {
            return 0;
        }

        $points = $activities->sum(fn (ProjectActivity $activity) => match ($activity->status) {
            ProjectActivity::STATUS_COMPLETED => 100,
            ProjectActivity::STATUS_IN_PROGRESS => 50,
            default => 0,
        });

        return (int) round($points / $activities->count());
    }
}
