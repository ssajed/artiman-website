<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Represents a global runtime setting stored in the database.
 *
 * This model is intentionally kept simple and free of business logic.
 * All serialization, deserialization, validation, and caching logic
 * resides in SettingService.
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property string $type
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Setting extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'core_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];
}