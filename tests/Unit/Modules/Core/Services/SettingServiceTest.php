<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Core\Services;

use App\Modules\Core\Exceptions\InvalidSettingValueException;
use App\Modules\Core\Models\Setting;
use App\Modules\Core\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SettingServiceTest extends TestCase
{
    use RefreshDatabase;

    private SettingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(SettingService::class);
        Cache::flush();
    }

    public function test_set_and_get_string(): void
    {
        $this->service->set('test_string', 'hello world', 'string');
        $this->assertSame('hello world', $this->service->get('test_string'));
    }

    public function test_set_and_get_integer(): void
    {
        $this->service->set('test_int', 42, 'integer');
        $this->assertSame(42, $this->service->get('test_int'));
    }

    public function test_set_and_get_boolean(): void
    {
        $this->service->set('test_bool_true', true, 'boolean');
        $this->assertTrue($this->service->get('test_bool_true'));

        $this->service->set('test_bool_false', false, 'boolean');
        $this->assertFalse($this->service->get('test_bool_false'));
    }

    public function test_set_and_get_json(): void
    {
        $data = ['key' => 'value', 'number' => 123];
        $this->service->set('test_json', $data, 'json');
        $this->assertSame($data, $this->service->get('test_json'));
    }

    public function test_set_invalidates_cache(): void
    {
        $this->service->set('cache_test', 'old', 'string');
        $this->assertSame('old', $this->service->get('cache_test'));

        $this->service->set('cache_test', 'new', 'string');
        $this->assertSame('new', $this->service->get('cache_test'));
    }

    public function test_forget_deletes_and_invalidates_cache(): void
    {
        $this->service->set('forget_test', 'value', 'string');
        $this->service->forget('forget_test');

        $this->assertNull(Setting::where('key', 'forget_test')->first());
        $this->assertSame('default', $this->service->get('forget_test', 'default'));
    }

    public function test_get_non_existent_returns_default_without_caching_invalid_state(): void
    {
        $result1 = $this->service->get('non_existent', 'my_default');
        $this->assertSame('my_default', $result1);

        // Second call should still return default, not a cached null/false
        $result2 = $this->service->get('non_existent', 'my_default');
        $this->assertSame('my_default', $result2);
    }

    public function test_set_with_invalid_type_throws_exception(): void
    {
        $this->expectException(InvalidSettingValueException::class);
        $this->service->set('bad_type', 'value', 'invalid_type');
    }

    public function test_set_string_with_non_string_throws_exception(): void
    {
        $this->expectException(InvalidSettingValueException::class);
        $this->service->set('bad_string', 123, 'string');
    }

    public function test_set_integer_with_non_integer_throws_exception(): void
    {
        $this->expectException(InvalidSettingValueException::class);
        $this->service->set('bad_int', '123', 'integer'); // String is not int
    }

    public function test_set_boolean_with_non_boolean_throws_exception(): void
    {
        $this->expectException(InvalidSettingValueException::class);
        $this->service->set('bad_bool', 'true', 'boolean'); // String is not bool
    }

    public function test_read_invalid_integer_throws_exception(): void
    {
        Setting::create([
            'key' => 'bad_int_read',
            'value' => '1.5', // Not a valid canonical integer
            'type' => 'integer',
        ]);

        $this->expectException(InvalidSettingValueException::class);
        $this->service->get('bad_int_read');
    }

    public function test_read_invalid_boolean_throws_exception(): void
    {
        Setting::create([
            'key' => 'bad_bool_read',
            'value' => 'abc',
            'type' => 'boolean',
        ]);

        $this->expectException(InvalidSettingValueException::class);
        $this->service->get('bad_bool_read');
    }

    public function test_read_invalid_json_throws_exception(): void
    {
        Setting::create([
            'key' => 'bad_json_read',
            'value' => '{invalid json}',
            'type' => 'json',
        ]);

        $this->expectException(InvalidSettingValueException::class);
        $this->service->get('bad_json_read');
    }
}