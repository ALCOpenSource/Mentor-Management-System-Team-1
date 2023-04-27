<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostDiscussions extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'is_owner',
    ];

    protected $casts = [
        'post_id' => 'integer',
        'user_id' => 'integer',
        'is_owner' => 'boolean',
    ];

    protected $appends = [
        'comment_attachment_url',
        'comment_attachment_thumbnail_url',
        'comment_preview',
        'is_owner',
        'date',
        'time',
        'human_time',
    ];

    protected $hidden = [
        'comment_attachment_path',
        'comment_attachment_thumbnail_path',
    ];

    /**
     * Morph to attachment.
     */
    public function comment_attachment(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Attachments::class, 'attachment');
    }

    /**
     * Get post.
     */
    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    /**
     * Get user.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get comment attachment url.
     */
    public function getCommentAttachmentUrlAttribute(): ?string
    {
        if ($this->comment_attachment) {
            return route('post_comment_attachment', [
                'post' => $this->post_id,
                'post_discussion' => $this->id,
                'attachment' => $this->comment_attachment->id,
            ]);
        }

        return null;
    }

    /**
     * Get comment attachment thumbnail url.
     */
    public function getCommentAttachmentThumbnailUrlAttribute(): ?string
    {
        if ($this->comment_attachment) {
            return route('post_comment_attachment_thumbnail', [
                'post' => $this->post_id,
                'post_discussion' => $this->id,
                'attachment' => $this->comment_attachment->thumbnail,
            ]);
        }

        return null;
    }

    /**
     * Get comment preview.
     */
    public function getCommentPreviewAttribute(): ?string
    {
        if ('text' === $this->comment_type) {
            return $this->comment;
        }

        if ('image' === $this->comment_type) {
            return $this->comment_attachment_url;
        }

        return null;
    }

    /**
     * Get is owner.
     */
    public function getIsOwnerAttribute(): bool
    {
        return $this->user_id === auth()->id();
    }

    /**
     * Get date.
     */
    public function getDateAttribute(): string
    {
        return $this->created_at->format('d M Y');
    }

    /**
     * Get time.
     */
    public function getTimeAttribute(): string
    {
        return $this->created_at->format('H:i');
    }

    /**
     * Get human time.
     */
    public function getHumanTimeAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
