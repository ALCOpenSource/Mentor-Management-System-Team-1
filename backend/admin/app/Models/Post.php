<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'slug',
        'image',
        'is_published',
        'published_at',
        'attachments',
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
        'image_url',
        'attachments_url',
        'is_published_at_diff_for_humans',
    ];

    protected $hidden = [
        'image_path',
    ];

    /**
     * Get user.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get discussions.
     */
    public function discussions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PostDiscussions::class);
    }
}
