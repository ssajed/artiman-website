<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $phases = [
            ['key' => 'release-readiness', 'name' => 'آماده‌سازی و دسترسی', 'sort_order' => 1],
            ['key' => 'public-content', 'name' => 'تکمیل سایت عمومی', 'sort_order' => 2],
            ['key' => 'catalog-quality', 'name' => 'کاتالوگ و کنترل کیفیت', 'sort_order' => 3],
            ['key' => 'final-release', 'name' => 'آماده‌سازی و تحویل', 'sort_order' => 4],
        ];

        foreach ($phases as $phase) {
            DB::table('project_progress_phases')->insertOrIgnore([
                ...$phase,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $activities = [
            ['release-readiness', 'baseline-production-checklist', 'بازبینی تنظیمات محیط Production و چک‌لیست انتشار', '2026-10-19', '2026-10-20', 'critical'],
            ['release-readiness', 'baseline-admin-access', 'تأیید مسیر امن ایجاد حساب مدیر و نقش دسترسی', '2026-10-19', '2026-10-20', 'critical'],
            ['public-content', 'baseline-inquiry-form', 'تکمیل فرم درخواست مشاوره و ذخیره درخواست‌ها', '2026-10-20', '2026-10-21', 'critical'],
            ['public-content', 'baseline-company-content', 'جایگزینی متن‌های نمونه با محتوای تأییدشده شرکت', '2026-10-24', '2026-10-26', 'high'],
            ['catalog-quality', 'baseline-category-nullability', 'رفع ناسازگاری اختیاری‌بودن دسته‌بندی محصول', '2026-10-21', '2026-10-24', 'high'],
            ['catalog-quality', 'baseline-catalog-tests', 'آزمون مسیرهای محصولات، دسته‌بندی‌ها و سطح دسترسی', '2026-10-24', '2026-10-26', 'high'],
            ['final-release', 'baseline-storage-migrations', 'بازبینی ذخیره‌سازی تصاویر و اجرای آزمایشی Migrationها', '2026-10-27', '2026-10-28', 'critical'],
            ['final-release', 'baseline-final-responsive-review', 'بازبینی نهایی نمایش موبایل، راست‌چین و محتوای سایت', '2026-10-28', '2026-10-28', 'high'],
        ];

        foreach ($activities as [$phaseKey, $referenceKey, $title, $startDate, $endDate, $priority]) {
            $phaseId = DB::table('project_progress_phases')->where('key', $phaseKey)->value('id');

            DB::table('project_progress_activities')->insertOrIgnore([
                'phase_id' => $phaseId,
                'reference_key' => $referenceKey,
                'title' => $title,
                'description' => 'برنامه اولیه تحویل؛ مدیر پروژه می‌تواند شرح، تاریخ و وضعیت را بازبینی کند.',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'not_started',
                'priority' => $priority,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('project_progress_activities')
            ->whereIn('reference_key', [
                'baseline-production-checklist',
                'baseline-admin-access',
                'baseline-inquiry-form',
                'baseline-company-content',
                'baseline-category-nullability',
                'baseline-catalog-tests',
                'baseline-storage-migrations',
                'baseline-final-responsive-review',
            ])
            ->delete();

        foreach (['release-readiness', 'public-content', 'catalog-quality', 'final-release'] as $phaseKey) {
            $phaseId = DB::table('project_progress_phases')->where('key', $phaseKey)->value('id');

            if ($phaseId && ! DB::table('project_progress_activities')->where('phase_id', $phaseId)->exists()) {
                DB::table('project_progress_phases')->where('id', $phaseId)->delete();
            }
        }
    }
};
