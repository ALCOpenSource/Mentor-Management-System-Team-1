<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_by',
        'details',
        'type',
        'report_id',
    ];

    protected $casts = [
        'task_id' => 'integer',
        'created_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Hidden
    protected $hidden = [
        'report_type',
    ];

    protected $appends = [
        // 'created_by_user',
        // 'report'
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
     * Morphs.
     */
    public function report()
    {
        return $this->morphTo();
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
    public function getReportAttribute()
    {
        return $this->report()->first();
    }
}
