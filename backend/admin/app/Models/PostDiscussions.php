<?php

namespace App\Models;

use App\Traits\HasUuidAttachments;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostDiscussions extends Model
{
    use HasFactory;
    use HasUuidAttachments;
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'post_id',
        'user_id',
        'is_owner',
        'comment',
        'attachment',
    ];

    protected $casts = [
        'post_id' => 'integer',
        'user_id' => 'integer',
        'is_owner' => 'boolean',
    ];

    protected $appends = [
        'comment_preview',
        'is_owner',
        'date',
        'time',
        'human_time',
        'attachments',
    ];

    /**
     * Get post.
     */
    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get user.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
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
        return substr($this->comment, 0, 100);
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
