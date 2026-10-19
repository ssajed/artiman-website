<?php

namespace Tests\Feature\Modules\ProjectProgress;

use App\Modules\Identity\Models\User;
use App\Modules\ProjectProgress\Models\ProjectActivity;
use App\Modules\ProjectProgress\Models\ProjectPhase;
use App\Modules\ProjectProgress\Support\ProjectCalendar;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProjectProgressTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-10-19 10:00:00', 'Asia/Tehran'));
    }

    protected function tearDown(): void
    {
        CarbonImmutable::setTestNow();

        parent::tearDown();
    }

    public function test_project_progress_is_restricted_to_admins(): void
    {
        $user = User::factory()->create();
        $phase = ProjectPhase::create(['key' => 'test', 'name' => 'مرحله آزمایشی']);
        $activity = $phase->activities()->create([
            'title' => 'فعالیت محافظت‌شده',
            'start_date' => '2026-10-24',
            'end_date' => '2026-10-25',
            'status' => ProjectActivity::STATUS_NOT_STARTED,
            'priority' => ProjectActivity::PRIORITY_MEDIUM,
        ]);

        $this->actingAs($user)
            ->get(route('admin.project-progress.index'))
            ->assertForbidden();

        $this->actingAs($user)
            ->get(route('admin.project-progress.activities.edit', $activity))
            ->assertForbidden();

        $this->actingAs($user)
            ->get(route('admin.project-progress.phases.create'))
            ->assertForbidden();

        $this->actingAs($user)
            ->get(route('admin.project-progress.phases.edit', $phase))
            ->assertForbidden();

        $this->actingAs($user)
            ->post(route('admin.project-progress.activities.store'), [
                'phase_id' => $phase->id,
                'title' => 'فعالیت غیرمجاز',
                'start_date' => '۱۴۰۵/۰۸/۰۱',
                'end_date' => '۱۴۰۵/۰۸/۰۲',
                'status' => ProjectActivity::STATUS_NOT_STARTED,
                'priority' => ProjectActivity::PRIORITY_MEDIUM,
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->post(route('admin.project-progress.phases.store'), [
                'name' => 'مرحله غیرمجاز',
                'sort_order' => 5,
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->put(route('admin.project-progress.activities.update', $activity), [
                'phase_id' => $phase->id,
                'title' => 'تغییر غیرمجاز',
                'start_date' => '۱۴۰۵/۰۸/۰۲',
                'end_date' => '۱۴۰۵/۰۸/۰۳',
                'status' => ProjectActivity::STATUS_COMPLETED,
                'priority' => ProjectActivity::PRIORITY_MEDIUM,
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->put(route('admin.project-progress.phases.update', $phase), [
                'name' => 'ویرایش غیرمجاز',
                'sort_order' => 1,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('project_progress_activities', ['title' => 'فعالیت غیرمجاز']);
        $this->assertDatabaseHas('project_progress_activities', ['id' => $activity->id, 'title' => 'فعالیت محافظت‌شده']);
        $this->assertDatabaseHas('project_progress_phases', ['id' => $phase->id, 'name' => 'مرحله آزمایشی']);
    }

    public function test_baseline_activities_are_scheduled_on_working_day_boundaries(): void
    {
        $activities = ProjectActivity::query()->get();

        $this->assertCount(8, $activities);

        foreach ($activities as $activity) {
            $this->assertTrue(ProjectCalendar::isWorkingDay($activity->start_date), $activity->title);
            $this->assertTrue(ProjectCalendar::isWorkingDay($activity->end_date), $activity->title);
        }

        $this->actingAs($this->createAdmin())
            ->get(route('admin.project-progress.index'))
            ->assertOk()
            ->assertSee('1405/08/06')
            ->assertSee('1405/08/07')
            ->assertSee('تعطیل تقویمی — موعد هدف تحویل پروژه، بدون فعالیت کاری.');
    }

    public function test_admin_can_create_update_and_retrieve_activity_after_reauthentication(): void
    {
        $admin = $this->createAdmin();
        $phase = ProjectPhase::create(['key' => 'test', 'name' => 'آماده‌سازی', 'sort_order' => 1]);

        $this->actingAs($admin)
            ->post(route('admin.project-progress.activities.store'), [
                'phase_id' => $phase->id,
                'title' => 'آزمون انتشار',
                'description' => 'بررسی نسخه آماده انتشار',
                'start_date' => '۱۴۰۵/۰۸/۰۲',
                'end_date' => '۱۴۰۵/۰۸/۰۳',
                'status' => ProjectActivity::STATUS_NOT_STARTED,
                'priority' => ProjectActivity::PRIORITY_HIGH,
            ])
            ->assertRedirect(route('admin.project-progress.index'));

        $activity = ProjectActivity::where('title', 'آزمون انتشار')->firstOrFail();
        $this->assertSame('2026-10-24', $activity->start_date->toDateString());
        $this->assertSame('2026-10-25', $activity->end_date->toDateString());

        $this->put(route('admin.project-progress.activities.update', $activity), [
            'phase_id' => $phase->id,
            'title' => 'آزمون انتشار نهایی',
            'description' => 'تأیید شد',
            'start_date' => '۱۴۰۵/۰۸/۰۲',
            'end_date' => '۱۴۰۵/۰۸/۰۳',
            'status' => ProjectActivity::STATUS_COMPLETED,
            'priority' => ProjectActivity::PRIORITY_CRITICAL,
        ])->assertRedirect(route('admin.project-progress.index'));

        auth()->logout();
        $this->actingAs(User::findOrFail($admin->id))
            ->get(route('admin.project-progress.index'))
            ->assertOk()
            ->assertSee('آزمون انتشار نهایی')
            ->assertSee('تأیید شد')
            ->assertSee('1405/08/02');

        $this->assertDatabaseHas('project_progress_activities', [
            'id' => $activity->id,
            'status' => ProjectActivity::STATUS_COMPLETED,
            'description' => 'تأیید شد',
        ]);
    }

    public function test_admin_can_create_and_update_a_phase_persistently(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->post(route('admin.project-progress.phases.store'), [
                'name' => 'مرحله ثبت‌شده',
                'sort_order' => 9,
            ])
            ->assertRedirect(route('admin.project-progress.index'));

        $phase = ProjectPhase::where('name', 'مرحله ثبت‌شده')->firstOrFail();

        $this->get(route('admin.project-progress.phases.edit', $phase))
            ->assertOk()
            ->assertSee('مرحله ثبت‌شده');

        $this->put(route('admin.project-progress.phases.update', $phase), [
            'name' => 'مرحله به‌روزشده',
            'sort_order' => 10,
        ])->assertRedirect(route('admin.project-progress.index'));

        auth()->logout();

        $this->actingAs(User::findOrFail($admin->id));
        $this->get(route('admin.project-progress.index'))
            ->assertOk()
            ->assertSee('مرحله به‌روزشده')
            ->assertSee('href="'.route('admin.project-progress.index').'"', false)
            ->assertSeeText('پیشرفت پروژه');

        $this->assertDatabaseHas('project_progress_phases', [
            'id' => $phase->id,
            'name' => 'مرحله به‌روزشده',
            'sort_order' => 10,
        ]);
    }

    public function test_progress_percentages_follow_activity_statuses(): void
    {
        $this->actingAs($this->createAdmin());
        $phase = ProjectPhase::create(['key' => 'progress', 'name' => 'آزمون پیشرفت']);

        foreach ([
            ProjectActivity::STATUS_COMPLETED,
            ProjectActivity::STATUS_IN_PROGRESS,
            ProjectActivity::STATUS_NOT_STARTED,
        ] as $index => $status) {
            $phase->activities()->create([
                'title' => 'فعالیت '.$index,
                'start_date' => '2026-10-19',
                'end_date' => '2026-10-20',
                'status' => $status,
                'priority' => ProjectActivity::PRIORITY_MEDIUM,
            ]);
        }

        $this->get(route('admin.project-progress.index'))
            ->assertOk()
            ->assertSee('14٪')
            ->assertSee('50٪');

        $this->assertSame(50, $phase->fresh()->load('activities')->progress_percent);
    }

    public function test_today_and_overdue_activities_are_shown_before_the_schedule(): void
    {
        CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-10-24 10:00:00', 'Asia/Tehran'));
        $this->actingAs($this->createAdmin());
        $phase = ProjectPhase::create(['key' => 'attention', 'name' => 'فعالیت‌های نیازمند توجه']);

        $phase->activities()->create([
            'title' => 'کار عقب‌افتاده آزمایشی',
            'start_date' => '2026-10-19',
            'end_date' => '2026-10-21',
            'status' => ProjectActivity::STATUS_IN_PROGRESS,
            'priority' => ProjectActivity::PRIORITY_HIGH,
        ]);
        $phase->activities()->create([
            'title' => 'فعالیت امروز آزمایشی',
            'start_date' => '2026-10-24',
            'end_date' => '2026-10-26',
            'status' => ProjectActivity::STATUS_NOT_STARTED,
            'priority' => ProjectActivity::PRIORITY_MEDIUM,
        ]);

        $this->get(route('admin.project-progress.index'))
            ->assertOk()
            ->assertSeeInOrder(['کار عقب‌افتاده آزمایشی', 'فعالیت امروز آزمایشی']);
    }

    public function test_activity_dates_must_be_valid_and_end_after_start(): void
    {
        $admin = $this->createAdmin();
        $phase = ProjectPhase::create(['key' => 'validation', 'name' => 'اعتبارسنجی']);

        $this->actingAs($admin)
            ->from(route('admin.project-progress.activities.create'))
            ->post(route('admin.project-progress.activities.store'), [
                'phase_id' => $phase->id,
                'title' => 'تاریخ نامعتبر',
                'start_date' => '۱۴۰۵/۱۲/۳۰',
                'end_date' => '۱۴۰۵/۱۲/۲۹',
                'status' => ProjectActivity::STATUS_NOT_STARTED,
                'priority' => ProjectActivity::PRIORITY_MEDIUM,
            ])
            ->assertSessionHasErrors(['start_date']);
    }

    public function test_activity_end_date_cannot_precede_start_date(): void
    {
        $admin = $this->createAdmin();
        $phase = ProjectPhase::create(['key' => 'date-range', 'name' => 'بازه تاریخ']);

        $this->actingAs($admin)
            ->from(route('admin.project-progress.activities.create'))
            ->post(route('admin.project-progress.activities.store'), [
                'phase_id' => $phase->id,
                'title' => 'بازه نامعتبر',
                'start_date' => '۱۴۰۵/۰۸/۰۳',
                'end_date' => '۱۴۰۵/۰۸/۰۲',
                'status' => ProjectActivity::STATUS_NOT_STARTED,
                'priority' => ProjectActivity::PRIORITY_MEDIUM,
            ])
            ->assertSessionHasErrors(['end_date']);
    }

    public function test_activity_dates_cannot_be_scheduled_on_thursday_or_friday(): void
    {
        $admin = $this->createAdmin();
        $phase = ProjectPhase::create(['key' => 'closed-days', 'name' => 'روزهای تعطیل']);

        $this->actingAs($admin)
            ->from(route('admin.project-progress.activities.create'))
            ->post(route('admin.project-progress.activities.store'), [
                'phase_id' => $phase->id,
                'title' => 'فعالیت در روز تعطیل',
                'start_date' => '1405/08/01',
                'end_date' => '1405/08/02',
                'status' => ProjectActivity::STATUS_NOT_STARTED,
                'priority' => ProjectActivity::PRIORITY_MEDIUM,
            ])
            ->assertSessionHasErrors(['start_date']);
    }

    private function createAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate('admin', 'web'));

        return $admin;
    }
}
