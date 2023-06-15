<?php

namespace App\Models;

use App\Traits\HasUuidAttachments;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use HasUuidAttachments;
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'body',
        'slug',
        'image',
        'is_published',
        'published_at',
        'attachment',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'attachments',
        'preview',
    ];

    /**
     * Get user.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get Human readable.
     */
    public function getIsPublishedHumanAttribute()
    {
        if ($this->is_published === true) {
            return 'Published';
        }

        return 'Not Published';
    }

    /**
     * Get discussions.
     */
    public function discussions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PostDiscussions::class);
    }

    /**
     * Get post preview.
     */
    public function getPreviewAttribute(): ?string
    {
        return $this->body ? mb_substr(strip_tags($this->body), 0, 100) : null;
    }
}
