<?php

namespace Tests\Unit\Modules\ProjectProgress;

use App\Modules\ProjectProgress\Support\ProjectCalendar;
use Carbon\CarbonImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProjectCalendarTest extends TestCase
{
    public function test_jalali_and_gregorian_dates_round_trip_for_delivery_date(): void
    {
        $this->assertSame('1405/08/07', ProjectCalendar::toJalali('2026-10-29'));
        $this->assertSame('2026-10-29', ProjectCalendar::toGregorian('۱۴۰۵/۰۸/۰۷'));
        $this->assertSame('2026-10-29', ProjectCalendar::toGregorian('1405-8-7'));
    }

    public function test_calendar_marks_thursday_and_friday_as_non_working(): void
    {
        $this->assertFalse(ProjectCalendar::isWorkingDay(CarbonImmutable::parse('2026-10-22')));
        $this->assertFalse(ProjectCalendar::isWorkingDay(CarbonImmutable::parse('2026-10-23')));
        $this->assertTrue(ProjectCalendar::isWorkingDay(CarbonImmutable::parse('2026-10-24')));
    }

    public function test_overdue_status_waits_until_a_working_day_after_the_due_date(): void
    {
        $dueDate = CarbonImmutable::parse('2026-10-21');

        $this->assertFalse(ProjectCalendar::isOverdue($dueDate, CarbonImmutable::parse('2026-10-22')));
        $this->assertFalse(ProjectCalendar::isOverdue($dueDate, CarbonImmutable::parse('2026-10-23')));
        $this->assertTrue(ProjectCalendar::isOverdue($dueDate, CarbonImmutable::parse('2026-10-24')));
    }

    public function test_invalid_jalali_dates_are_rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);

        ProjectCalendar::toGregorian('۱۴۰۵/۱۲/۳۰');
    }
}
