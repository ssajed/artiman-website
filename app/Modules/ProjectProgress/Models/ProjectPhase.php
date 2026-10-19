<?php

namespace App\Modules\ProjectProgress\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectPhase extends Model
{
    protected $table = 'project_progress_phases';

    protected $fillable = [
        'key',
        'name',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function activities(): HasMany
    {
        return $this->hasMany(ProjectActivity::class, 'phase_id');
    }

    public function getProgressPercentAttribute(): int
    {
        if ($this->activities->isEmpty()) {
            return 0;
        }

        $points = $this->activities->sum(fn (ProjectActivity $activity) => match ($activity->status) {
            ProjectActivity::STATUS_COMPLETED => 100,
            ProjectActivity::STATUS_IN_PROGRESS => 50,
            default => 0,
        });

        return (int) round($points / $this->activities->count());
    }
}
