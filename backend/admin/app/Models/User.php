<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_login_at',
        'last_login_ip',
        'provider',
        'provider_id',
        'avatar',
        'role',
        'city',
        'state',
        'country',
        'zip_code',
        'address',
        'phone',
        'timezone',
        'about_me',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'last_login_at',
        'last_login_ip',
        'provider',
        'provider_id',
        'role',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the preferences for the user.
     */
    public function preferences(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Preference::class);
    }

    /**
     * Get the support tickets for the user.
     */
    public function supportTickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    /**
     * Get the user sessions for the user.
     */
    public function userSessions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserSessions::class);
    }

    /**
     * Get the user metadata for the user.
     */
    public function userMetadata(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserMetadata::class);
    }

    /**
     * Get the user's role.
     */
    public function role(): string
    {
        return $this->role;
    }
}
