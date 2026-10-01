<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Core\Services;

use App\Modules\Core\Models\FeatureFlag;
use App\Modules\Core\Services\FeatureFlagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class FeatureFlagServiceTest extends TestCase
{
    use RefreshDatabase;

    private FeatureFlagService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(FeatureFlagService::class);
        Cache::flush();
    }

    public function test_is_enabled_returns_true_when_active(): void
    {
        FeatureFlag::create([
            'key' => 'test_feature',
            'is_active' => true,
        ]);

        $this->assertTrue($this->service->isEnabled('test_feature'));
    }

    public function test_is_enabled_returns_false_when_inactive(): void
    {
        FeatureFlag::create([
            'key' => 'test_feature',
            'is_active' => false,
        ]);

        $this->assertFalse($this->service->isEnabled('test_feature'));
    }

    public function test_is_enabled_returns_false_when_missing_without_exception(): void
    {
        // اطمینان از اینکه کلید وجود ندارد
        $this->assertNull(FeatureFlag::where('key', 'non_existent_feature')->first());

        // باید false برگرداند، نه Exception
        $this->assertFalse($this->service->isEnabled('non_existent_feature'));
    }

    public function test_enable_sets_flag_and_invalidates_cache(): void
    {
        $this->service->enable('new_feature');

        $this->assertTrue($this->service->isEnabled('new_feature'));
        
        // بررسی دیتابیس
        $flag = FeatureFlag::where('key', 'new_feature')->first();
        $this->assertNotNull($flag);
        $this->assertTrue($flag->is_active);
    }

    public function test_disable_sets_flag_and_invalidates_cache(): void
    {
        // ابتدا فعال می‌کنیم
        $this->service->enable('toggle_feature');
        $this->assertTrue($this->service->isEnabled('toggle_feature'));

        // سپس غیرفعال می‌کنیم
        $this->service->disable('toggle_feature');
        $this->assertFalse($this->service->isEnabled('toggle_feature'));

        // بررسی دیتابیس
        $flag = FeatureFlag::where('key', 'toggle_feature')->first();
        $this->assertNotNull($flag);
        $this->assertFalse($flag->is_active);
    }

    public function test_cache_invalidation_on_enable(): void
    {
        // مقدار اولیه در کش
        $this->assertFalse($this->service->isEnabled('cache_test_feature'));

        // فعال‌سازی باید کش را invalidate کند
        $this->service->enable('cache_test_feature');
        
        // خواندن بعدی باید مقدار جدید را از دیتابیس بگیرد و true باشد
        $this->assertTrue($this->service->isEnabled('cache_test_feature'));
    }
}