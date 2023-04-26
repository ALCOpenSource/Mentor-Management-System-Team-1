<?php

namespace App\Http\Controllers;

use App\Models\Attachments;

class PostDiscussionsController extends Controller
{
    protected $fillable = [
        'post_id',
        'user_id',
        'is_owner',
        'comment',
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
    public function getCommentAttachmentUrlAttribute(): string
    {
        if ($this->comment_attachment) {
            return $this->comment_attachment->first()->path;
        }

        return '';
    }

    /**
     * Get comment attachment thumbnail url.
     */
    public function getCommentAttachmentThumbnailUrlAttribute(): string
    {
        if ($this->comment_attachment) {
            return $this->comment_attachment->first()->thumbnail_path;
        }

        return '';
    }
}
