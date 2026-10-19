<?php

namespace App\Modules\ProjectProgress\Models;

use App\Modules\ProjectProgress\Support\ProjectCalendar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectActivity extends Model
{
    public const STATUS_NOT_STARTED = 'not_started';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';

    public const PRIORITY_LOW = 'low';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_HIGH = 'high';
    public const PRIORITY_CRITICAL = 'critical';

    protected $table = 'project_progress_activities';

    protected $fillable = [
        'phase_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'priority',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function phase(): BelongsTo
    {
        return $this->belongsTo(ProjectPhase::class, 'phase_id');
    }

    public function getEffectiveStatusAttribute(): string
    {
        if (
            $this->status !== self::STATUS_COMPLETED
            && ProjectCalendar::isOverdue($this->end_date)
        ) {
            return 'overdue';
        }

        return $this->status;
    }
}
