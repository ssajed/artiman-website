<?php

declare(strict_types=1);

namespace App\Modules\Core\Services;

use App\Modules\Core\Models\FeatureFlag;
use Illuminate\Support\Facades\Cache;

class FeatureFlagService
{
    private const CACHE_TTL = 3600;
    private const CACHE_PREFIX = 'core.feature_flag.';

    public function __construct(
        private FeatureFlag $model
    ) {
    }

    public function isEnabled(string $key): bool
    {
        return Cache::remember(
            $this->getCacheKey($key),
            self::CACHE_TTL,
            function () use ($key) {
                $flag = $this->model->where('key', $key)->first();
                return $flag?->is_active ?? false;
            }
        );
    }

    public function enable(string $key): void
    {
        $this->model->updateOrCreate(
            ['key' => $key],
            ['is_active' => true]
        );

        $this->invalidateCache($key);
    }

    public function disable(string $key): void
    {
        $this->model->updateOrCreate(
            ['key' => $key],
            ['is_active' => false]
        );

        $this->invalidateCache($key);
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