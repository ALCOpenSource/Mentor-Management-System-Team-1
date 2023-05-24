<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalRequests extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_type',
        'requested_by',
        'approved',
        'updated_by',
        'approved_at',
        'rejected_at',
        'reason',
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    protected $hidden = [
        'request_type',
    ];

    /**
     * Static::boot method to set requested_by to the current user.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->requested_by = auth()->user()->id;
        });
    }

    /**
     * Morph to the model requesting approval.
     */
    public function request()
    {
        return $this->morphTo();
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
