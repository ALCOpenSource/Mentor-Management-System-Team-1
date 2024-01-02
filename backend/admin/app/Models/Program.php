<?php

namespace App\Models;

use App\Traits\HasUuidAttachments;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory;
    use HasUuidAttachments;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'deleted_by',
    ];

    protected $appends = [
        // 'attachments',
        'assigned_users',
    ];

    /**
     * Set created by to current user.
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });
    }

    /**
     * Get program creator.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get program deleter.
     */
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Get program criteria.
     */
    public function criteria()
    {
        return $this->hasMany(ProgramCriteria::class);
    }

    /**
     * Get program users.
     */
    public function users()
    {
        return $this->hasMany(ProgramUser::class);
    }

    /**
     * Program approval requests.
     */
    public function approvalRequest()
    {
        return $this->morphOne(ApprovalRequest::class, 'request');
    }

    /**
     * Get program avatar.
     */
    public function avatar()
    {
        return $this->morphOne(Attachment::class, 'attachable')->where('type', 'avatar');
    }

    /**
     * Get avatar URL.
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? $this->avatar->url : null;
    }

    /**
     * Get users assigned to program, group by role.
     */
    public function getAssignedUsersAttribute()
    {
        return $this->users()->with('user')->groupBy('role')->get();
    }
}
