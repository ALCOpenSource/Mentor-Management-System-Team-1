<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'path',
        'size',
        'extension',
        'mime_type',
        'type',
        'thumbnail_path',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    protected $appends = [
        'url',
        'thumbnail_url',
    ];

    protected $hidden = [
        'id',
        'path',
        'thumbnail_path',
    ];

    /**
     * Morph to attachment.
     */
    public function attachment(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get url.
     */
    public function getUrlAttribute(): string
    {
        return route('attachments.show', $this->uuid);
    }

    /**
     * Get thumbnail url.
     */
    public function getThumbnailUrlAttribute(): string
    {
        return url($this->thumbnail_path);
    }

    /**
     * Sets the uuid attribute.
     *
     * @param mixed $value
     */
    public function setUuidAttribute($value): void
    {
        $this->attributes['uuid'] = $value;
    }
}
