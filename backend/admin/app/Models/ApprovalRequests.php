<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalRequests extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_type',
        'requested_by',
        'approved',
        'updated_by',
        'approved_at',
        'rejected_at',
        'reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approved' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'request_type',
    ];

    /**
     * Static::boot method to set requested_by to the current user.
     *
     * @return void
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function request()
    {
        return $this->morphTo();
    }

    /**
     * Morph to the model approving the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * Morph to the model approving the request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
