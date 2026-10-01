<?php

declare(strict_types=1);

namespace App\Modules\Core\Services;

use App\Modules\Core\Exceptions\InvalidSettingValueException;
use App\Modules\Core\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    private const CACHE_TTL = 3600;
    private const CACHE_PREFIX = 'core.setting.';

    private const VALID_TYPES = ['string', 'integer', 'boolean', 'json'];

    public function __construct(
        private Setting $model
    ) {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $setting = Cache::remember(
            $this->getCacheKey($key),
            self::CACHE_TTL,
            function () use ($key) {
                return $this->model->where('key', $key)->first();
            }
        );

        if (!$setting) {
            return $default;
        }

        return $this->deserialize($setting);
    }

    public function set(string $key, mixed $value, string $type, ?string $description = null): void
    {
        $this->validateType($type);
        $serializedValue = $this->serialize($key, $value, $type);

        $this->model->updateOrCreate(
            ['key' => $key],
            [
                'value' => $serializedValue,
                'type' => $type,
                'description' => $description,
            ]
        );

        $this->invalidateCache($key);
    }

    public function forget(string $key): void
    {
        $this->model->where('key', $key)->delete();
        $this->invalidateCache($key);
    }

    private function serialize(string $key, mixed $value, string $type): string
    {
        return match ($type) {
            'string' => $this->serializeString($key, $value),
            'integer' => $this->serializeInteger($key, $value),
            'boolean' => $this->serializeBoolean($key, $value),
            'json' => $this->serializeJson($key, $value),
            default => throw new InvalidSettingValueException($key, $type, 'Invalid type'),
        };
    }

    private function deserialize(Setting $setting): mixed
    {
        return match ($setting->type) {
            'string' => $setting->value,
            'integer' => $this->deserializeInteger($setting),
            'boolean' => $this->deserializeBoolean($setting),
            'json' => $this->deserializeJson($setting),
            default => throw new InvalidSettingValueException($setting->key, $setting->type, 'Invalid type in database'),
        };
    }

    private function serializeString(string $key, mixed $value): string
    {
        if (!is_string($value)) {
            throw new InvalidSettingValueException($key, 'string', 'Value must be a string');
        }
        return $value;
    }

    private function serializeInteger(string $key, mixed $value): string
    {
        if (!is_int($value)) {
            throw new InvalidSettingValueException($key, 'integer', 'Value must be an integer');
        }
        return (string) $value;
    }

    private function serializeBoolean(string $key, mixed $value): string
    {
        if (!is_bool($value)) {
            throw new InvalidSettingValueException($key, 'boolean', 'Value must be a boolean');
        }
        return $value ? '1' : '0';
    }

    private function serializeJson(string $key, mixed $value): string
    {
        try {
            return json_encode($value, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new InvalidSettingValueException($key, 'json', 'Value must be JSON-encodable: ' . $e->getMessage());
        }
    }

    private function deserializeInteger(Setting $setting): int
    {
        $filtered = filter_var($setting->value, FILTER_VALIDATE_INT);
        
        if ($filtered === false) {
            throw new InvalidSettingValueException($setting->key, 'integer', 'Value is not a valid integer');
        }
        
        return $filtered;
    }

    private function deserializeBoolean(Setting $setting): bool
    {
        if ($setting->value === '1') {
            return true;
        }
        if ($setting->value === '0') {
            return false;
        }
        throw new InvalidSettingValueException($setting->key, 'boolean', 'Value must be "1" or "0"');
    }

    private function deserializeJson(Setting $setting): mixed
    {
        try {
            return json_decode($setting->value, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new InvalidSettingValueException($setting->key, 'json', 'Value is not valid JSON: ' . $e->getMessage());
        }
    }

    private function validateType(string $type): void
    {
        if (!in_array($type, self::VALID_TYPES, true)) {
            throw new InvalidSettingValueException('unknown', $type, 'Type must be one of: ' . implode(', ', self::VALID_TYPES));
        }
    }

    private function getCacheKey(string $key): string
    {
        return self::CACHE_PREFIX . $key;
    }

    private function invalidateCache(string $key): void
    {
        Cache::forget($this->getCacheKey($key));
    }
}