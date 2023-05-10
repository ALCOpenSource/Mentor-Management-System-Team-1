<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

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
     * Get the reports for the task.
     */
    public function reports()
    {
        return $this->hasMany(TaskReport::class);
    }

    /**
     * Get the assignments for the task.
     */
    public function assignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }

    /**
     * Get the creator of the task.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the assignees of the task.
     */
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_assignments');
    }

    /**
     * Scopes for filtering tasks.
     */
    public function scopeTodo()
    {
        return $this->where('status', 'todo');
    }

    /**
     * Scopes for filtering tasks.
     */
    public function scopeInProgress()
    {
        return $this->where('status', 'in_progress');
    }

    /**
     * Scopes for filtering tasks.
     */
    public function scopeCompleted()
    {
        return $this->where('status', 'completed');
    }

    /**
     * Scopes for filtering tasks.
     */
    public function scopeCriticalPriority()
    {
        return $this->where('priority', 'critical');
    }

    /**
     * Scopes for filtering tasks.
     */
    public function scopeHighPriority()
    {
        return $this->where('priority', 'high');
    }

    /**
     * Scopes for filtering tasks.
     */
    public function scopeMediumPriority()
    {
        return $this->where('priority', 'medium');
    }

    /**
     * Scopes for filtering tasks.
     */
    public function scopeLowPriority()
    {
        return $this->where('priority', 'low');
    }

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
