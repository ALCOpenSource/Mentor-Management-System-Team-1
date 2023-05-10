<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'created_by',
        'details',
        'type',
    ];

    protected $casts = [
        'task_id' => 'integer',
        'created_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        // 'created_by_user',
        // 'task'
    ];

    /**
     * Boot set created_by to the current user.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($report) {
            $report->created_by = auth()->user()->id;
        });
    }

    /**
     * Get the task that owns the report.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user that owns the report.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that owns the report.
     */
    public function getCreatedByUserAttribute()
    {
        return $this->createdBy()->first();
    }

    /**
     * Get the task that owns the report.
     */
    public function getTaskAttribute()
    {
        return $this->task()->first();
    }
}
