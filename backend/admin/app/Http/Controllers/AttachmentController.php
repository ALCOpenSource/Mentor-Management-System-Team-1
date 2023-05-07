<?php

namespace App\Http\Controllers;

use App\Models\Attachment;

class AttachmentController extends Controller
{
    /**
     * Get Attachment.
     *
     * @param mixed $uuid
     */
    public function getAttachment($uuid)
    {
        $attachment = callStatic(Attachment::class, 'where', 'uuid', $uuid)->firstOrFail();

        // Check if file exists
        if (! file_exists(storage_path($attachment->path))) {
            abort(404);
        }

        return response()->file(storage_path($attachment->path), [
            'Content-Type' => $attachment->mime_type,
            'Content-Disposition' => 'inline; filename="'.$attachment->name.'"',
        ]);
    }

    /**
     * Downloads attachment.
     *
     * @param mixed $uuid
     */
    public function downloadAttachment($uuid)
    {
        $attachment = callStatic(Attachment::class, 'where', 'uuid', $uuid)->firstOrFail();

        // Check if file exists
        if (! file_exists(storage_path($attachment->path))) {
            abort(404);
        }

        return response()->download(storage_path($attachment->path), $attachment->name, [
            'Content-Type' => $attachment->mime_type,
            'Content-Disposition' => 'attachment; filename="'.$attachment->name.'"',
        ]);
    }

    /**
     * Get attachment thumbnail.
     *
     * @param mixed $uuid
     */
    public function getAttachmentThumbnail($uuid)
    {
        $attachment = callStatic(Attachment::class, 'where', 'uuid', $uuid)->firstOrFail();

        return response()->file($attachment->thumbnail_path, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="'.$attachment->name.'-thumbnail.png"',
        ]);
    }
}
