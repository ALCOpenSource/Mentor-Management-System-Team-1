<?php

namespace App\Http\Controllers;

use App\Events\MessageDeleted;
use App\Events\MessageDelivered;
use App\Events\MessageRead;
use App\Events\NewMessage;
use App\Http\Resources\ApiResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    protected function copyAttachments(array $attachments, Message $message)
    {
        foreach ($attachments as $attachment) {
            // Create a copy of the attachment
            $file_path = storage_path($attachment->path);

            // If file does not exist skip
            if (! file_exists($file_path)) {
                continue;
            }

            $file = new File($file_path);
            $message->storeAttachment($file, 'attachment', $message->room_id);
        }
    }

    protected function saveAttachments(array $attachments, Message $message)
    {
        foreach ($attachments as $attachment) {
            $message->storeAttachment($attachment, 'attachment', $message->room_id);
        }
    }

    /**
     * Send message.
     */
    public function sendMessage(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
            'message' => 'nullable|string|max:255',

            // multiple attachments
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,zip,rar,txt|max:2048',
        ]);

        // If both message and attachments are empty, return error
        if (empty($request->message) && empty($request->attachments)) {
            return new ApiResource([
                'message' => 'Message or attachment is required.',
                'status' => 422,
            ]);
        }

        // If receiver is the sender, return error
        if ($user->id == $request->receiver_id) {
            return new ApiResource([
                'message' => 'You cannot send message to yourself.',
                'status' => 422,
            ]);
        }

        // Create message
        $message = $user->messages()->create([
            'receiver_id' => (int) $request->receiver_id,
            'message' => $request->message,

            // If only attachments are sent, set the message type to attachment
            'type' => empty($request->message) ? 'attachment' : 'text',
        ]);

        // Attachments
        if ($request->hasFile('attachments')) {
            $this->saveAttachments($request->attachments, $message);
        }

        $message->save();

        // If sender is not the receiver, then send notification
        if ($message->sender_id != $message->receiver_id) {
            // Send notification to the receiver
            callStatic(NewMessage::class, 'dispatch', $message);

            // If receiver is online, then send the message to the receiver
            if ($message->receiver['is_online']) {
                $message->delivered_at = now();
                $message->save();

                callStatic(MessageDelivered::class, 'dispatch', $message);
            }
        }

        return new ApiResource(['data' => $message]);
    }

    /**
     * Get message thread.
     *
     * @param mixed $receiver_id
     * @param mixed $room_id
     */
    public function getMessageThread(Request $request, $room_id)
    {
        $user = $request->user();

        // Get the first 20 messages
        $messages = callStatic(Message::class, 'where', 'room_id', $room_id)
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->latest()
            ->paginate(20);

        // For each of the message if status = unread, and receiver_id = current user id, then send message delivered notification
        // to the sender
        foreach ($messages as $message) {
            if ('unread' == $message->status && $message->receiver_id == $user->id) {
                // Mark the message as read
                $message->read_at = now();
                $message->delivered_at = now();
                $message->status = 'read';
                $message->save();

                // Send notification to the sender that the message has been read
                callStatic(MessageRead::class, 'dispatch', $message);
            }
        }

        return new ApiResource($messages);
    }

    /**
     * Get message threads.
     */
    public function getMessageThreads(Request $request)
    {
        $user = $request->user();

        // Get page number
        $page = $request->page ?? 1;

        // Get the first 20 distinct room ids
        $room_ids = callStatic(DB::class, 'select', '
            SELECT distinct(m.room_id)
            FROM messages m
            WHERE m.sender_id = ? OR m.receiver_id = ?
            GROUP BY m.room_id
            ORDER BY created_at DESC
            LIMIT 20 OFFSET ?
        ', [
            $user->id,
            $user->id,
            ($page - 1) * 20,
        ]);

        // Get the room ids
        $room_ids = array_map(function ($room) {
            return $room->room_id;
        }, $room_ids);

        $messages = [];

        foreach ($room_ids as $room_id) {
            $messages[] = callStatic(Message::class, 'where', 'room_id', $room_id)
                ->latest()
                ->first();
        }

        // Sort messages by created_at
        usort($messages, function ($message_a, $message_b) {
            return $message_a->created_at <= $message_b->created_at;
        });

        // Create new pagination
        $messages = new LengthAwarePaginator($messages, count($messages), 20, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // Append extra data
        $messages->map(function ($message) {
            $message->unread = callStatic(Message::class, 'where', 'sender_id', $message->sender_id)
                ->where('status', 'unread')
                ->where('receiver_id', auth()->id())
                ->count();

            $message->receiver = callStatic(User::class, 'where', 'id', $message->receiver_id)
                ->first()
                ?->only(['id', 'name', 'email', 'avatar_url', 'flag']);

            $message->sender = callStatic(User::class, 'where', 'id', $message->sender_id)
                ->first()
                ?->only(['id', 'name', 'email', 'avatar_url', 'flag']);
        });

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

        $message = callStatic(Message::class, 'where', 'uuid', $uuid)
            ->where('receiver_id', $user->id)
            ->first();

        if (! $message) {
            return new ApiResource([
                'message' => 'Message not found',
                'status' => 404,
            ]);
        }

        $message->read_at = now();
        $message->delivered_at = now();
        $message->status = 'read';
        $message->save();

        callStatic(MessageRead::class, 'dispatch', $message);

        return new ApiResource(['data' => $message]);
    }

    /**
     * Mark thread as read.
     *
     * @param mixed $room_id
     */
    public function markThreadAsRead(Request $request, $room_id)
    {
        $user = $request->user();

        $messages = $user->messages()
            ->where('room_id', $room_id)
            ->where('status', 'unread')
            ->get();

        foreach ($messages as $message) {
            $message->read_at = now();
            $message->delivered_at = now();
            $message->status = 'read';
            $message->save();

            callStatic(MessageRead::class, 'dispatch', $message);
        }

        return new ApiResource(['message' => 'Messages marked as read']);
    }

    /**
     * Mark message as unread.
     *
     * @param mixed $uuid
     */
    public function markMessageAsUnread(Request $request, $uuid)
    {
        $user = $request->user();

        $message = callStatic(Message::class, 'where', 'uuid', $uuid)
            ->where('receiver_id', $user->id)
            ->first();

        if (! $message) {
            return new ApiResource([
                'message' => 'Message not found',
                'status' => 404,
            ]);
        }

        $message->read_at = null;
        $message->delivered_at = null;
        $message->status = 'unread';
        $message->save();

        return new ApiResource(['data' => $message]);
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
            return new ApiResource([
                'message' => 'Message not found.',
                'status' => 404,
            ]);
        }

        // Delete attachments
        foreach ($message->attachment as $attachment) {
            if (file_exists(storage_path($attachment->path))) {
                unlink(storage_path($attachment->path));
            }

            $attachment->delete();
        }

        // Delete message
        $message->delete();

        // Dispatch event
        callStatic(MessageDeleted::class, 'dispatch', $message);

        return new ApiResource(['data' => $message]);
    }

    /**
     * Delete all messages.
     *
     * @param mixed $receiver_id
     * @param mixed $room_id
     */
    public function deleteAllMessagesInThread(Request $request, $room_id)
    {
        $user = $request->user();

        $messages = $user->messages()->where('room_id', $room_id)->get();

        // Delete attachment
        foreach ($messages as $message) {
            // Delete attachments
            foreach ($message->attachment as $attachment) {
                if (file_exists(storage_path($attachment->path))) {
                    unlink(storage_path($attachment->path));
                }

                $attachment->delete();
            }

            // Delete message
            $message->delete();

            // Dispatch event
            callStatic(MessageDeleted::class, 'dispatch', $message);
        }

        return new ApiResource(['message' => 'All messages deleted']);
    }

    /**
     * Forward message.
     *
     * @param mixed $uuid
     */
    public function forwardMessage(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'uuid' => 'required|string|exists:messages,uuid',
            'receiver_id' => 'required|integer|exists:users,id',
        ]);

        // Get message
        $message = $user->messages()->where('uuid', $request->uuid)->first();

        // If receiver is the sender, return error
        if ($user->id == $request->receiver_id) {
            return new ApiResource([
                'message' => 'You cannot send message to yourself.',
                'status' => 422,
            ]);
        }

        // If receiver is the same as the original receiver return error
        if ($message->receiver_id == $request->receiver_id) {
            return new ApiResource([
                'message' => 'You can not forward a message to the same person',
                'status' => 422,
            ]);
        }

        // Create a copy of the message
        $forwardedMessage = $user->messages()->create([
            'receiver_id' => (int) $request->receiver_id,
            'message' => $message->message,
            'type' => 'text',
            'forwarded' => true,
        ]);

        // Copy attachments
        $this->copyAttachments($message->attachment()->get(), $message);

        // Save message
        $forwardedMessage->save();

        // Send notification
        callStatic(NewMessage::class, 'dispatch', $forwardedMessage);

        return new ApiResource(['data' => $forwardedMessage]);
    }

    /**
     * Broadcast message.
     */
    public function broadcastMessage(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'message' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,zip,rar,txt|max:2048',
            'receiver_ids' => 'nullable|array',
            'receiver_ids.*' => 'nullable|integer|exists:users,id',
        ]);

        // If both attachments and message is empty return error
        if (! $request->message && ! $request->hasFile('attachments')) {
            return new ApiResource([
                'message' => 'Message or attachment is required',
                'status' => 422,
            ]);
        }

        // If receiver ids are not provided broadcast to all users
        $receiverIds = $request->receiver_ids ?? User::where('id', '!=', $user->id)->pluck('id')->toArray();
        $receiverIds = array_unique($receiverIds);
        $request->merge(['receiver_ids' => $receiverIds]);
        $message = null;
        $broadcast_id = strHelper('uuid');

        foreach ($receiverIds as $receiver_id) {
            // If receiver is the sender
            if ($user->id == $request->receiver_id) {
                continue;
            }

            // Create a copy of the message
            $message = $user->messages()->create([
                'receiver_id' => $receiver_id,
                'message' => $request->message,
                'type' => 'broadcast',
                'broadcast_id' => $broadcast_id,
            ]);

            // Attachments
            if ($request->hasFile('attachments')) {
                $this->saveAttachments($request->attachments, $message);
            }

            $message->save();

            // Send notification
            callStatic(NewMessage::class, 'dispatch', $message);
        }

        // Remove receiver_id from the message
        $message->makeHidden(['receiver_id', 'sender_id', 'uuid', 'sender', 'receiver']);

        // Return the message
        return new ApiResource(['data' => $message]);
    }

    /**
     * Get all the broadcast messages sent by the user.
     */
    public function getBroadcastMessages(Request $request)
    {
        $user = $request->user();

        $messages = $user->messages()
            ->select('broadcast_id')
            ->distinct('broadcast_id')
            ->where('type', 'broadcast')
            ->paginate(20);

        // Create new Paginator
        $messages = new LengthAwarePaginator(
            $messages->map(function ($message) use ($user) {
                $message = callStatic(Message::class, 'where', 'broadcast_id', $message->broadcast_id)
                    ->where('sender_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                // Remove receiver_id from the message
                $message->makeHidden([
                    'receiver_id', 'sender_id', 'uuid', 'sender',
                    'receiver', 'room_id', 'forwarded', 'user',
                    'read_at', 'delivered_at', 'status',
                ]);

                // Check delivery status, will be true if at least one message is delivered
                $message->delivered = callStatic(Message::class, 'where', 'broadcast_id', $message->broadcast_id)
                    ->where('sender_id', $user->id)
                    ->whereNotNull('delivered_at')
                    ->count() > 0;

                // Check read status, will be true if all the messages are read
                $message->read = callStatic(Message::class, 'where', 'broadcast_id', $message->broadcast_id)
                    ->where('sender_id', $user->id)
                    ->whereNotNull('read_at')
                    ->count() === callStatic(Message::class, 'where', 'broadcast_id', $message->broadcast_id)->count();

                return $message;
            }),
            $messages->total(),
            $messages->perPage(),
            $messages->currentPage(),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return new ApiResource($messages);
    }
}
