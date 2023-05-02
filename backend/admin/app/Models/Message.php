<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'status',
        'type',
        'uuid',
        'attachment',
    ];

    protected $casts = [
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
    ];

    protected $appends = [
        'preview',
        'is_sender',
        'is_receiver',
        'room_id',
        'date',
        'time',
    ];

    /**
     * Morph to attachment.
     */
    public function attachment(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Attachments::class, 'attachment');
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
     * Set uuid attribute.
     *
     * @param mixed $value
     */
    public function setUuidAttribute($value): void
    {
        $value = strHelper('uuid', $value ?? '');
    }

    /**
     * Set message.
     */
    public function setMessageAttribute(string $value): void
    {
        $value = linkify($value);
    }

    /**
     * Get attachment url.
     */
    public function getAttachmentUrlAttribute(): ?string
    {
        if ($this->attachment) {
            return route('messages.attachment', ['message' => $this->id, 'filename' => $this->attachment->name]);
        }

        return null;
    }

    /**
     * Get preview.
     */
    public function getPreviewAttribute(): string
    {
        return $this->sender_id === auth()->id() ? sprintf('You: %s', substr($this->message, 0, 20)) : substr($this->message, 0, 20);
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
     * Get room id.
     */
    public function getRoomIdAttribute(): string
    {
        $sender_id = $this->sender_id;
        $receiver_id = $this->receiver_id;

        return md5(sprintf('%s-%s', $receiver_id, $sender_id));
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
}
