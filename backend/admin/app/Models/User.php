<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class User extends Authenticatable
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
        'avatar',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone' => E164PhoneNumberCast::class,
    ];

    /**
     * User's first name attribute.
     *
     * @var array
     */
    protected $appends = [
        'first_name',
        'last_name',
        'avatar_url',
        'unread_messages_count',
        'unread_notifications_count',
        'member_since',
        'social_links',
        'website',
        'flag',
        'tags',
        'general_metadata',
        'is_online',
        'last_seen',
        'message_room_id',
        'country_name',
        'added_on',
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
     * Assigned support tickets for the user.
     */
    public function assignedSupportTickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SupportTicket::class, 'assigned_user_id');
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
     * Get the user messages intended for the user.
     */
    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the user messages sent by the user.
     */
    public function receivedMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Task reports for the user.
     */
    public function Reports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Report::class, 'created_by');
    }

    /**
     * Get task assigned to the user.
     */
    public function assignedTasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TaskAssignment::class);
    }

    /**
     * Get task created by the user.
     */
    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * User attachments.
     */
    public function attachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserAttachments::class);
    }

    /**
     * Get the user's role.
     */
    public function role(): string
    {
        return $this->role;
    }

    /**
     * Set the user's name.
     */
    public function setNameAttribute(string $name): void
    {
        $this->attributes['name'] = ucwords($name);
    }

    /**
     * Get the first name of the user.
     */
    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0] ?? '';
    }

    /**
     * Get the last name of the user.
     */
    public function getLastNameAttribute(): string
    {
        return explode(' ', $this->name)[1] ?? '';
    }

    /**
     * Return user avatar url.
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ?? 'https://ui-avatars.com/api/?'.http_build_query(['name' => $this->initials, ...getUIAvatarBackgroundAndColor($this->email)]);
    }

    /**
     * Get the user's unread messages count.
     */
    public function getUnreadMessagesCountAttribute(): int
    {
        return callStatic(Message::class, 'where', 'receiver_id', $this->id)->where('status', 'unread')->count();
    }

    /**
     * Get the user's unread notifications count.
     */
    public function getUnreadNotificationsCountAttribute(): int
    {
        return $this->unreadNotifications()->count();
    }

    /**
     * Get user initials.
     */
    public function getInitialsAttribute(): string
    {
        $name = explode(' ', $this->name);
        $first = $name[0][0] ?? '';
        $last = ($name[1] ?? $first)[0] ?? '';

        return strtoupper($first.$last);
    }

    /**
     * Get user member since attribute.
     */
    public function getMemberSinceAttribute(): string
    {
        return $this->created_at->format('M d, Y');
    }

    /**
     * Get social media links.
     */
    public function getSocialLinksAttribute(): array
    {
        return $this->getSocialMediaMetadata();
    }

    /**
     * Get user website.
     */
    public function getWebsiteAttribute(): array
    {
        return $this->getWebsiteMetadata();
    }

    /**
     * Get user tags.
     */
    public function getTagsAttribute(): array
    {
        return $this->getMetadata('tags', []);
    }

    /**
     * Get user flag.
     */
    public function getFlagAttribute(): string
    {
        return $this->country ? asset(sprintf('vendor/blade-flags/country-%s.svg', strtolower($this->country))) : '';
    }

    /**
     * Get country name.
     */
    public function getCountryNameAttribute(): string
    {
        if (! $this->country) {
            return '';
        }

        $cacheKey = sprintf('country-%s-%s', $this->id, $this->country);

        if (cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $country_name = callStatic(Country::class, 'where', 'code', $this->country)->first()?->name;

        cache()->put($cacheKey, $country_name);

        return $country_name;
    }

    /**
     * Get general metadata.
     */
    public function getGeneralMetadataAttribute(): array
    {
        return $this->getUserMetadata();
    }

    /**
     * Get is online attribute.
     */
    public function getIsOnlineAttribute(): bool
    {
        return $this->userSessions()->where('last_activity', '>=', now()->subMinutes(5))->exists();
    }

    /**
     * Get last seen attribute.
     */
    public function getLastSeenAttribute(): string
    {
        $lastSeen = $this->userSessions()->orderBy('last_activity', 'desc')->first();

        return $lastSeen ? $lastSeen->last_activity->diffForHumans() : '';
    }

    /**
     * Get user metadata.
     */
    public function getMetadata(string $key, mixed $default = null)
    {
        $metadata = $this->userMetadata()->where('key', $key)->first();

        if ($metadata) {
            return $metadata->value;
        }

        return $default;
    }

    /**
     * Get user social media metadata.
     */
    public function getSocialMediaMetadata(): array
    {
        $metadata = $this->userMetadata()->where('group', 'social')->get();

        $socialMedia = [];

        foreach ($metadata as $item) {
            $socialMedia[$item->key] = [
                'name' => $item->value,
                'url' => $item->options['url'] ?? '',
            ];
        }

        return $socialMedia;
    }

    /**
     * Get user website metadata.
     */
    public function getWebsiteMetadata(): array
    {
        $metadata = $this->userMetadata()->where('group', 'website')->get();

        $website = [];

        foreach ($metadata as $item) {
            $website[$item->key] = [
                'name' => $item->value,
                'url' => $item->options['url'] ?? '',
            ];
        }

        return $website;
    }

    /**
     * Get user general metadata.
     */
    public function getUserMetadata(): array
    {
        $metadata = $this->userMetadata()->where('group', 'general')->get();

        $userMetadata = [];

        foreach ($metadata as $item) {
            $userMetadata[$item->key] = [
                'type' => $item->type,
                'value' => $item->value,
                'options' => $item->options,
            ];
        }

        return $userMetadata;
    }

    /**
     * Set user metadata.
     */
    public function setMetadata(string $key, mixed $value, string $type = 'string', string $group = 'general', array $options = null): void
    {
        $metadata = $this->userMetadata()->where('key', $key)->first();

        if ($metadata) {
            $metadata->value = $value;
            $metadata->type = $type;
            $metadata->group = $group;
            $metadata->options = $options;
            $metadata->save();

            return;
        }

        $this->userMetadata()->create([
            'key' => $key,
            'value' => $value,
            'type' => $type,
            'group' => $group,
            'options' => $options,
        ]);
    }

    /**
     * Set Preference.
     */
    public function setPreference(string $key, mixed $value): void
    {
        $preference = $this->preferences()->where('key', $key)->first();

        if ($preference) {
            $preference->value = $value;
            $preference->save();

            return;
        }

        $this->preferences()->create([
            'key' => $key,
            'value' => $value,
        ]);
    }

    /**
     * Get Preference.
     */
    public function getPreference(string $key, mixed $default = null)
    {
        $preference = $this->preferences()->where('key', $key)->first();

        if ($preference) {
            return $preference->value;
        }

        return $default;
    }

    /**
     * Get all user preferences.
     */
    public function getPreferences(): array
    {
        $preferences = $this->preferences()->get();

        $userPreferences = [];

        foreach ($preferences as $preference) {
            $userPreferences[$preference->key] = $preference->value;
        }

        return $userPreferences;
    }

    /**
     * Has role.
     *
     * @param mixed $role
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            $role = explode('|', $role);
        }

        return in_array($this->role, $role);
    }

    /**
     * Get message room id attribute.
     */
    public function getMessageRoomIdAttribute(): string
    {
        return getRoomIdFromUserIds($this->id, auth()->id());
    }

    /**
     * Get added on attribute.
     */
    public function getAddedOnAttribute(): string
    {
        return $this->created_at->format('M, d Y');
    }

    /**
     * Public function addTag(string $tag): void.
     */
    public function addTag(string $tag): void
    {
        $tags = $this->tags;

        if (! in_array($tag, $tags)) {
            $tags[] = $tag;
        }

        $this->setMetadata('tags', $tags, 'array', 'tags', [
            'tags' => $tags,
        ]);
    }
}
