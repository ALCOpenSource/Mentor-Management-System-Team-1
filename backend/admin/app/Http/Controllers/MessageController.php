<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Get messages.
     */
    public function getMessage(Request $request)
    {
        $user = $request->user();

        // Get the first 20 messages
        $messages = $user->messages()->with(['sender', 'receiver'])->latest()->paginate(20);

        // Append number of unread messages
        $messages->unread = $user->messages()->where('status', 'unread')->count();

        return new ApiResource($messages);
    }

    /**
     * Get unread messages.
     */
    public function getUnreadMessage(Request $request)
    {
        $user = $request->user();

        // Get the first 20 messages
        $messages = $user->messages()->with(['sender', 'receiver'])->where('status', 'unread')->latest()->paginate(20);

        // Append number of unread messages
        $messages->unread = $user->messages()->where('status', 'unread')->count();

        return new ApiResource($messages);
    }

    /**
     * Send message.
     */
    public function sendMessage(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
            'message' => 'required|string|max:255',

            // multiple attachments
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,zip,rar|max:2048',
        ]);

        // Here we allow user to send message to themselves, so we won't validate if the receiver is the same as the sender
        $message = $user->messages()->create([
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'type' => 'text',
        ]);

        // Attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->attachments as $attachment) {
                $attachmentName = $message->id.'_attachment'.time().'.'.$attachment->getClientOriginalExtension();
                $attachment->storeAs('attachments', $attachmentName);
                $message->attachment()->create([
                    'attachment' => $attachmentName,
                    'attachment_type' => $attachment->getMimeType(),
                    'attachment_name' => $attachment->getClientOriginalName(),
                    'attachment_size' => $attachment->getSize(),
                    'attachment_extension' => $attachment->getClientOriginalExtension(),
                    'attachment_mime_type' => $attachment->getMimeType(),
                    'attachment_path' => storage_path('message/attachments/'.$attachmentName),
                ]);
            }
        }

        $message->save();

        // Send notification
        $message->receiver->notify(new NewMessageNotification($message));

        return new ApiResource($message);
    }

    /**
     * Delete message.
     *
     * @param mixed $uuid
     */
    public function deleteMessage(Request $request, $uuid)
    {
        $user = $request->user();

        $message = $user->messages()->where('uuid', $uuid)->first();

        if (! $message) {
            return response()->json([
                'message' => 'Message not found',
            ], 404);
        }

        // Delete attachment
        if ($message->attachment) {
            $attachmentPath = storage_path('message/attachments/'.$message->attachment_path);
            if (file_exists($attachmentPath)) {
                unlink($attachmentPath);
            }
        }

        $message->delete();

        return new ApiResource($message);
    }

    /**
     * Get message thread.
     *
     * @param mixed $receiver_id
     */
    public function getMessageThread(Request $request, $receiver_id)
    {
        $user = $request->user();

        // Get the first 20 messages
        $messages = $user->messages()
            ->with(['sender', 'receiver'])
            ->where('receiver_id', $receiver_id)
            ->latest()
            ->paginate(20);

        // Append number of unread messages
        $messages->unread = $user->messages()->where('status', 'unread')->count();

        return new ApiResource($messages);
    }

    /**
     * Get message threads.
     */
    public function getMessageThreads(Request $request)
    {
        $user = $request->user();

        // Get the first 20 messages
        $messages = $user->messages()
            ->with(['sender', 'receiver'])
            ->select([
                'id', 'sender_id', 'receiver_id', 'message',
                'type', 'status', 'created_at', 'updated_at',
                'sender.avatar_url as sender_avatar_url', 'sender.name as sender_name',
                'receiver.avatar_url as receiver_avatar_url', 'receiver.name as receiver_name',
                'sender.email as sender_email', 'receiver.email as receiver_email',
            ])->latest()
            ->paginate(20);

        // Append number of unread messages
        $messages->unread = $user->messages()->where('status', 'unread')->count();

        return new ApiResource($messages);
    }

    /**
     * Mark message as read.
     *
     * @param mixed $uuid
     */
    public function markMessageAsRead(Request $request, $uuid)
    {
        $user = $request->user();

        $message = $user->messages()->where('id', $uuid)->first();

        if (! $message) {
            return response()->json([
                'message' => 'Message not found',
            ], 404);
        }

        $message->status = 'read';
        $message->save();

        return new ApiResource($message);
    }

    /**
     * Mark message as unread.
     *
     * @param mixed $uuid
     */
    public function markMessageAsUnread(Request $request, $uuid)
    {
        $user = $request->user();

        $message = $user->messages()->where('id', $uuid)->first();

        if (! $message) {
            return response()->json([
                'message' => 'Message not found',
            ], 404);
        }

        $message->status = 'unread';
        $message->save();

        return new ApiResource($message);
    }

    /**
     * Delete all messages.
     *
     * @param mixed $receiver_id
     */
    public function deleteAllMessagesInThread(Request $request, $receiver_id)
    {
        $user = $request->user();

        $messages = $user->messages()->where('receiver_id', $receiver_id)->get();

        // Delete attachment
        foreach ($messages as $message) {
            if ($message->attachment) {
                $attachmentPath = storage_path('message/attachments/'.$message->attachment_path);
                if (file_exists($attachmentPath)) {
                    unlink($attachmentPath);
                }
            }
        }

        $messages->delete();

        return new ApiResource(['message' => 'All messages deleted']);
    }
}
