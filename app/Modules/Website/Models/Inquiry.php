<?php

namespace App\Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Inquiry extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'website_inquiries';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'industry',
        'flow_rate',
        'inlet_temp',
        'outlet_temp',
        'wet_bulb',
        'install_conditions',
        'tower_type',
        'description',
        'status',
    ];

    /**
     * Scope to filter by status.
     */
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get only new inquiries.
     */
    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope to order by most recent.
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * Check if inquiry is new.
     */
    public function isNew(): bool
    {
        return $this->status === 'new';
    }
}