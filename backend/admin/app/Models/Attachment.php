<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Attachment extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

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
        'download_url',
        'thumbnail_url',
    ];

    protected $hidden = [
        'path',
        'thumbnail_path',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) strHelper('uuid');
            $model->type = getFileType($model->mime_type);
        });
    }

    /**
     * Morph to attachment.
     */
    public function my_attachment(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get url.
     */
    public function getUrlAttribute(): ?string
    {
        // Get attachment instance
        $attachment_instance = $this->attachment;

        if ($attachment_instance instanceof Message &&
            ($attachment_instance->sender_id !== auth()->id() && $attachment_instance->receiver_id !== auth()->id())) {
            return null;
        }

        return callStatic(
            URL::class,
            'temporarySignedRoute',
            'attachment.show',
            now()->addDay(),
            [
                'uuid' => $this->uuid,
            ]
        );
    }

    /**
     * Get download url.
     */
    public function getDownloadUrlAttribute(): ?string
    {
        // Get attachment instance
        $attachment_instance = $this->attachment;

        if ($attachment_instance instanceof Message &&
            ($attachment_instance->sender_id !== auth()->id() && $attachment_instance->receiver_id !== auth()->id())) {
            return null;
        }

        return callStatic(
            URL::class,
            'temporarySignedRoute',
            'attachment.download',
            now()->addDay(),
            [
                'uuid' => $this->uuid,
            ]
        );
    }

    /**
     * Get thumbnail url.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ('image' === $this->type && $this->thumbnail_path) {
            return route('attachment.thumbnail', $this->uuid);
        }

        return null;
    }
}
