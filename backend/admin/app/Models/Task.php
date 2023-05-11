<?php

namespace App\Models;

use App\Traits\HasReports;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    use HasReports;

    protected $fillable = [
        'title',
        'details',
        'start_date',
        'due_date',
        'is_completed',
        'created_by',
        'priority',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'due_date' => 'datetime',
        'is_completed' => 'boolean',
    ];

    protected $hidden = [
        'created_by',
    ];

    protected $appends = [
        'assignees',
        'start_date_human',
        'due_date_human',
        'duration',
    ];

    /**
     * Set created_by attribute.
     */
    protected static function booted()
    {
        static::creating(function ($task) {
            $task->created_by = auth()->id();
        });
    }

    /**
     * Get the assignments for the task.
     */
    public function assignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }

    /**
     * Assignees.
     */
    public function assignees()
    {
        return $this->hasManyThrough(User::class, TaskAssignment::class, 'task_id', 'id', 'id', 'user_id');
    }

    /**
     * Due date human readable.
     */
    public function getDueDateHumanAttribute()
    {
        return $this->due_date?->diffForHumans();
    }

    /**
     * Start date human readable.
     */
    public function getStartDateHumanAttribute()
    {
        return $this->start_date?->diffForHumans();
    }

    /**
     * Duration attribute.
     */
    public function getDurationAttribute()
    {
        // Get the duration by min, hours, days
        $duration = $this->due_date?->diff($this->start_date);

        // If duration is null return null
        if (! $duration) {
            return;
        }

        // Return duration
        if ($duration->d > 0) {
            return $duration->d.' days';
        } elseif ($duration->h > 0) {
            return $duration->h.' hours';
        } elseif ($duration->i > 0) {
            return $duration->i.' minutes';
        }

        return $duration->s.' seconds';
    }

    /**
     * Assignees attribute.
     */
    public function getAssigneesAttribute()
    {
        // Get all assignees group by role
        return $this->assignees()->get()->groupBy('role');
    }
}
