<?php

namespace App\Traits;

use App\Models\Attachment;

trait HasUuidAttachments
{
    /**
     * Morph to attachment.
     */
    public function attachment()
    {
        return $this->morphMany(Attachment::class, 'attachment');
    }

    public function getAttachments()
    {
        return $this->attachment()->get()->map(function ($attachment) {
            return [
                'uuid' => $attachment->uuid,
                'name' => $attachment->name,
                'url' => $attachment->url,
                'download_url' => $attachment->download_url,
                'size' => $attachment->size,
                'extension' => $attachment->extension,
                'mime_type' => $attachment->mime_type,
                'type' => $attachment->type,
                'thumbnail_path' => $attachment->thumbnail_url,
            ];
        })->toArray();
    }

    /**
     * Get attachments.
     */
    public function getAttachmentsAttribute()
    {
        return $this->getAttachments();
    }

    /**
     * Public function to store attachment.
     *
     * @param mixed $file
     * @param mixed $type
     * @param mixed $prefix
     */
    public function storeAttachment($file, $type = 'attachment', $prefix = '')
    {
        $prefix = empty($prefix) ? '' : $prefix.'-';

        $attachment_name = sprintf('%s-%s.%s', uniqid($prefix), time(), $file->getClientOriginalExtension());
        $model_name = strtolower(class_basename($this));
        $path = "app/{$model_name}/attachments/{$attachment_name}";
        $file->storeAs("{$model_name}/attachments", $attachment_name);

        $attachment = $this->attachment()->create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => $file->getSize(),
            'extension' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getMimeType(),
            'type' => $type,
        ]);

        return $attachment;
    }

    public function getAttachmentPath($uuid)
    {
        $attachment = $this->attachment()->where('uuid', $uuid)->first();

        if ($attachment) {
            return storage_path($attachment->path);
        }
    }

    /**
     * Delete attachment.
     *
     * @param mixed $uuid
     */
    public function deleteAttachment($uuid)
    {
        $attachment = $this->attachment()->where('uuid', $uuid)->first();

        if (! $attachment) {
            return false;
        }

        // Delete attachment from storage.
        $attachment_path = storage_path($attachment->path);
        if (file_exists($attachment_path)) {
            unlink($attachment_path);
        }

        $attachment->delete();
    }
}
