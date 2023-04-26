<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTickets extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'assigned_user_id',
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    protected $hidden = [
        'user_id',
        'assigned_user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'message' => 'json',
    ];

    /**
     * Get the user that owns the support ticket.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assigned user to the support ticket.
     */
    public function assignedUser(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
