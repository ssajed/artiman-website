<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents a feature flag stored in the database.
 *
 * This model is intentionally kept simple and free of business logic.
 * All caching and validation logic resides in FeatureFlagService.
 *
 * Feature flags are strictly boolean in Phase 2B.
 * No multi-state, rollout, targeting, or A/B testing is supported.
 *
 * @property int $id
 * @property string $key
 * @property bool $is_active
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class FeatureFlag extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'core_feature_flags';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'is_active',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
}