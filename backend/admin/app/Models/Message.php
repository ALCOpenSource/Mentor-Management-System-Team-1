<?php

namespace App\Models;

use App\Traits\HasUuidAttachments;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    use HasUuidAttachments;
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'sender_id',
        'receiver_id',
        'message',
        'status',
        'type',
        'attachment',
        'read_at',
        'broadcast_id',
        'room_id',
        'delivered_at',
        'soft_deleted_sender',
        'soft_deleted_receiver',
        'forwarded',
    ];

    protected $casts = [
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'read_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    protected $hidden = [
        'soft_deleted_sender',
        'soft_deleted_receiver',
    ];

    protected $appends = [
        'preview',
        'is_sender',
        'is_receiver',
        'datetime',
        'date',
        'time',
        'attachments',
        'human_date',
        'sender',
        'receiver',
        'user',
        'delivered',
        'read',
        'is_broadcast',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->room_id = $model->getRoomId();
        });
    }

    /**
     * Get sender.
     */
    public function sender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get receiver.
     */
    public function receiver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Set receiver id.
     */
    public function setReceiverIdAttribute(int $value): void
    {
        $this->attributes['receiver_id'] = $value;
    }

    /**
     * Set message.
     *
     * @param ?string $value
     */
    public function setMessageAttribute(?string $value): void
    {
        // If message is empty set message as null don't encrypt it.
        if (empty($value)) {
            $this->attributes['message'] = null;

            return;
        }

        $this->attributes['message'] = encrypt(linkify($value));
    }

    /**
     * Get message.
     */
    public function getMessageAttribute(): string
    {
        // If user is sender and soft deleted message, return "This message was deleted."
        if ($this->is_sender && $this->soft_deleted_sender) {
            return 'This message was deleted.';
        }

        // If user is receiver and soft deleted message, return "This message was deleted."
        if ($this->is_receiver && $this->soft_deleted_receiver) {
            return 'This message was deleted.';
        }

        try {
            return decrypt($this->attributes['message']);
        } catch (\Exception) {
            return $this->attributes['message'] ?? '';
        }
    }

    /**
     * Get preview.
     */
    public function getPreviewAttribute(): string
    {
        // If message is empty, return empty string.
        if (empty($this->message)) {
            return '';
        }

        $message = stripHtmlAndLinks($this->message);
        $message = substr($message, 0, 20);
        $message = strlen($this->message) > 20 ? sprintf('%s...', $message) : $message;

        return $this->sender_id === auth()->id() ? sprintf('You: %s', $message) : sprintf('%s: %s', $this->sender['name'], $message);
    }

    /**
     * Get is sender.
     */
    public function getIsSenderAttribute(): bool
    {
        return $this->sender_id === auth()->id();
    }

    /**
     * Get is receiver.
     */
    public function getIsReceiverAttribute(): bool
    {
        return $this->receiver_id === auth()->id();
    }

    /**
     * Get datetime.
     */
    public function getDatetimeAttribute(): string
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    /**
     * Get date.
     */
    public function getDateAttribute(): string
    {
        return $this->created_at->format('Y-m-d');
    }

    /**
     * Get time.
     */
    public function getTimeAttribute(): string
    {
        return $this->created_at->format('H:i');
    }

    /**
     * Get human date. (5 minutes ago), (30m), (1 Hr), (2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 Hr),
     * (today at 10:00), (yesterday at 10:00), (10/10/2020 at 10:00).
     */
    public function getHumanDateAttribute(): string
    {
        $now = now()->clone();
        $created_at = $this->created_at;

        if ($created_at->diffInMinutes($now) < 1) {
            return __('Just now');
        } elseif ($created_at->diffInMinutes($now) < 60) {
            return sprintf(__('%s minutes ago'), $created_at->diffInMinutes($now));
        } elseif ($created_at->diffInHours($now) < 24) {
            return sprintf(__('%s Hr ago'), $created_at->diffInHours($now));
        } elseif ($created_at->isToday()) {
            return sprintf(__('Today at %s'), $created_at->format('H:i'));
        } elseif ($created_at->isYesterday()) {
            return sprintf(__('Yesterday at %s'), $created_at->format('H:i'));
        }

        return sprintf(__('%s at %s'), $created_at->format('d/m/Y'), $created_at->format('H:i'));
    }

    /**
     * Set room id.
     */
    public function getRoomId(): string
    {
        return getRoomIdFromUserIds($this->sender_id, $this->receiver_id);
    }

    /**
     * Get sender attributes.
     */
    public function getSenderAttribute(): array
    {
        $sender = $this->sender()->first();

        if (! $sender) {
            return [];
        }

        return [
            'id' => $sender->id,
            'name' => $sender->name,
            'avatar_url' => $sender->avatar_url,
            'email' => $sender->email,
            'is_online' => $sender->is_online,
            'last_seen' => $sender->last_seen,
            'flag' => $sender->flag,
        ];
    }

    /**
     * Get receiver attributes.
     */
    public function getReceiverAttribute(): array
    {
        $receiver = $this->receiver()->first();

        if (! $receiver) {
            return [];
        }

        return [
            'id' => $receiver->id,
            'name' => $receiver->name,
            'avatar_url' => $receiver->avatar_url,
            'email' => $receiver->email,
            'is_online' => $receiver->is_online,
            'last_seen' => $receiver->last_seen,
            'flag' => $receiver->flag,
        ];
    }

    /**
     * Get user attributes.
     */
    public function getUserAttribute(): array
    {
        // If currently logged in user is sender, return receiver attributes.
        return $this->is_sender ? $this->receiver : $this->sender;
    }

    /**
     * Get delivered attribute.
     */
    public function getDeliveredAttribute(): bool
    {
        return $this->is_sender ? true : null !== $this->delivered_at;
    }

    /**
     * Get read attribute.
     */
    public function getReadAttribute(): bool
    {
        return $this->is_sender ? true : null !== $this->read_at;
    }

    /**
     * Get attachments.
     */
    public function getAttachmentsAttribute()
    {
        // If soft deleted message, return empty array.
        if ($this->is_sender && $this->soft_deleted_sender) {
            return [];
        }

        // If soft deleted message, return empty array.
        if ($this->is_receiver && $this->soft_deleted_receiver) {
            return [];
        }

        // Return the trait method.
        return $this->getAttachments();
    }

    /**
     * Is broadcast attribute.
     */
    public function getIsBroadcastAttribute(): bool
    {
        return null !== $this->broadcast_id;
    }
}
