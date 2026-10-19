<?php

namespace App\Modules\ProjectProgress\Support;

use Carbon\CarbonImmutable;
use DateTimeInterface;
use InvalidArgumentException;

class ProjectCalendar
{
    public const TIMEZONE = 'Asia/Tehran';
    public const DELIVERY_DATE = '2026-10-29';

    private const PERSIAN_DIGITS = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    private const ARABIC_DIGITS = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

    public static function today(): CarbonImmutable
    {
        return CarbonImmutable::now(self::TIMEZONE)->startOfDay();
    }

    public static function isWorkingDay(DateTimeInterface $date): bool
    {
        return ! in_array((int) $date->format('N'), [4, 5], true);
    }

    public static function isOverdue(DateTimeInterface $dueDate, ?DateTimeInterface $today = null): bool
    {
        $date = CarbonImmutable::parse($dueDate->format('Y-m-d'), self::TIMEZONE)->addDay();
        $lastDate = $today
            ? CarbonImmutable::parse($today->format('Y-m-d'), self::TIMEZONE)
            : self::today();

        while ($date->lessThanOrEqualTo($lastDate)) {
            if (self::isWorkingDay($date)) {
                return true;
            }

            $date = $date->addDay();
        }

        return false;
    }

    public static function weekdayName(DateTimeInterface $date): string
    {
        return [
            1 => 'دوشنبه',
            2 => 'سه‌شنبه',
            3 => 'چهارشنبه',
            4 => 'پنج‌شنبه',
            5 => 'جمعه',
            6 => 'شنبه',
            7 => 'یک‌شنبه',
        ][(int) $date->format('N')];
    }

    public static function toJalali(DateTimeInterface|string $date): string
    {
        $gregorian = $date instanceof DateTimeInterface
            ? [$date->format('Y'), $date->format('n'), $date->format('j')]
            : self::parseGregorianDate($date);

        [$year, $month, $day] = $gregorian;
        $monthDays = [0, 31, self::isGregorianLeapYear($year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $adjustedYear = $month > 2 ? $year + 1 : $year;
        $days = 355666
            + (365 * $year)
            + intdiv($adjustedYear + 3, 4)
            - intdiv($adjustedYear + 99, 100)
            + intdiv($adjustedYear + 399, 400)
            + $day
            + array_sum(array_slice($monthDays, 0, $month));

        $jalaliYear = -1595 + (33 * intdiv($days, 12053));
        $days %= 12053;
        $jalaliYear += 4 * intdiv($days, 1461);
        $days %= 1461;

        if ($days > 365) {
            $jalaliYear += intdiv($days - 1, 365);
            $days = ($days - 1) % 365;
        }

        if ($days < 186) {
            $jalaliMonth = 1 + intdiv($days, 31);
            $jalaliDay = 1 + ($days % 31);
        } else {
            $jalaliMonth = 7 + intdiv($days - 186, 30);
            $jalaliDay = 1 + (($days - 186) % 30);
        }

        return sprintf('%04d/%02d/%02d', $jalaliYear, $jalaliMonth, $jalaliDay);
    }

    public static function toGregorian(string $jalaliDate): string
    {
        $normalized = str_replace(
            [...self::PERSIAN_DIGITS, ...self::ARABIC_DIGITS],
            [...range(0, 9), ...range(0, 9)],
            trim($jalaliDate)
        );

        if (! preg_match('/^(\d{4})[\/-](\d{1,2})[\/-](\d{1,2})$/', $normalized, $matches)) {
            throw new InvalidArgumentException('تاریخ باید با قالب سال/ماه/روز وارد شود.');
        }

        $year = (int) $matches[1];
        $month = (int) $matches[2];
        $day = (int) $matches[3];

        if ($year < 1300 || $year > 1500 || $month < 1 || $month > 12 || $day < 1 || $day > 31) {
            throw new InvalidArgumentException('تاریخ شمسی معتبر نیست.');
        }

        $adjustedYear = $year + 1595;
        $days = -355668
            + (365 * $adjustedYear)
            + (intdiv($adjustedYear, 33) * 8)
            + intdiv(($adjustedYear % 33) + 3, 4)
            + $day
            + ($month < 7 ? (($month - 1) * 31) : ((($month - 7) * 30) + 186));

        $gregorianYear = 400 * intdiv($days, 146097);
        $days %= 146097;

        if ($days > 36524) {
            $gregorianYear += 100 * intdiv(--$days, 36524);
            $days %= 36524;

            if ($days >= 365) {
                $days++;
            }
        }

        $gregorianYear += 4 * intdiv($days, 1461);
        $days %= 1461;

        if ($days > 365) {
            $gregorianYear += intdiv($days - 1, 365);
            $days = ($days - 1) % 365;
        }

        $gregorianDay = $days + 1;
        $monthDays = [0, 31, self::isGregorianLeapYear($gregorianYear) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $gregorianMonth = 1;

        while ($gregorianMonth <= 12 && $gregorianDay > $monthDays[$gregorianMonth]) {
            $gregorianDay -= $monthDays[$gregorianMonth];
            $gregorianMonth++;
        }

        $gregorianDate = sprintf('%04d-%02d-%02d', $gregorianYear, $gregorianMonth, $gregorianDay);

        if (self::toJalali($gregorianDate) !== sprintf('%04d/%02d/%02d', $year, $month, $day)) {
            throw new InvalidArgumentException('تاریخ شمسی معتبر نیست.');
        }

        return $gregorianDate;
    }

    private static function parseGregorianDate(string $date): array
    {
        if (! preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $matches)) {
            throw new InvalidArgumentException('تاریخ میلادی معتبر نیست.');
        }

        $year = (int) $matches[1];
        $month = (int) $matches[2];
        $day = (int) $matches[3];

        if (! checkdate($month, $day, $year)) {
            throw new InvalidArgumentException('تاریخ میلادی معتبر نیست.');
        }

        return [$year, $month, $day];
    }

    private static function isGregorianLeapYear(int $year): bool
    {
        return $year % 4 === 0 && ($year % 100 !== 0 || $year % 400 === 0);
    }
}
