<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSessions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
    ];

    protected $hidden = [
        'payload',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'payload' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
