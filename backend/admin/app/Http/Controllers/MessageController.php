<?php

namespace App\Http\Controllers;

use App\Events\MessageDeleted;
use App\Events\MessageDelivered;
use App\Events\MessageRead;
use App\Events\NewMessage;
use App\Helpers\AppConstants;
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
            event(new NewMessage($message));

            // If receiver is online, then send the message to the receiver
            if ($message->receiver['is_online']) {
                $message->delivered_at = now();
                $message->save();

                event(new MessageDelivered($message));
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

        // Reverse the messages
        $messages = new LengthAwarePaginator(
            $messages->reverse()->values(),
            $messages->total(),
            $messages->perPage(),
            $messages->currentPage(),
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

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
                event(new MessageRead($message));
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
            AND ((m.broadcast = 0 OR m.broadcast IS NULL) AND m.sender_id != ?)
            GROUP BY m.room_id
            ORDER BY created_at ASC
            LIMIT 20 OFFSET ?
        ', [
            $user->id,
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

        event(new MessageRead($message));

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

            event(new MessageRead($message));
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
            // If broadcast message and user is not the sender skip deleting attachment
            if ($message->broadcast && $message->sender_id != $user->id) {
                continue;
            }

            if (file_exists(storage_path($attachment->path))) {
                unlink(storage_path($attachment->path));
            }

            $attachment->delete();
        }

        // If broadcast message and current user is sender delete all other messages in the broadcast
        if ($message->broadcast && $message->sender_id == $user->id) {
            $user->messages()
                ->whereNotNull('broadcast_id')
                ->where('broadcast_id', $message->broadcast_id)
                ->where('uuid', '!=', $message->uuid)
                ->delete();
        }

        // Delete message
        $message->delete();

        // Dispatch event
        event(new MessageDeleted($message));

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
            $this->deleteMessage($request, $message->uuid);
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
        event(new NewMessage($forwardedMessage));

        return new ApiResource(['data' => $forwardedMessage]);
    }

    /**
     * Broadcast message.
     *
     * @param mixed $user
     * @param mixed $request
     * @param mixed $receiver_id
     * @param mixed $broadcast_id
     *
     * @return Message $message
     */
    protected function sendBroadcast($user, $request, $receiver_id, $broadcast_id)
    {
        static $skip = false;
        static $attachments = null;

        // If receiver is the sender, skip
        if ($user->id == $request->receiver_id) {
            return;
        }

        // Create a copy of the message
        $message = $user->messages()->create([
            'receiver_id' => $receiver_id,
            'message' => $request->message,
            'type' => 'broadcast',
            'broadcast_id' => $broadcast_id,
        ]);

        // Attachments
        if ($request->hasFile('attachments') && ! $attachments) {
            $this->saveAttachments($request->attachments, $message);

            // Save attachments for reuse
            $attachments = $message->attachment()->get();
            $skip = true;
        }

        if ($attachments && ! $skip) {
            foreach ($attachments as $attachment) {
                $message->attachment()->create([
                    'name' => $attachment->name,
                    'path' => $attachment->path,
                    'size' => $attachment->size,
                    'extension' => $attachment->extension,
                    'mime_type' => $attachment->mime_type,
                    'type' => $attachment->type,
                ]);
            }
        }

        // Send notification
        event(new NewMessage($message));

        return $message;
    }

    /**
     * Broadcast message.
     *
     * @param mixed|null $user_role
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
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|string|in:'.implode(',', [AppConstants::ROLE_ADMIN, AppConstants::ROLE_MENTOR, AppConstants::ROLE_MENTOR_MANAGER]),
        ]);

        // If both attachments and message is empty return error
        if (! $request->message && ! $request->hasFile('attachments')) {
            return new ApiResource([
                'message' => 'Message or attachment is required',
                'status' => 422,
            ]);
        }

        // If receiver ids are not provided broadcast to all users
        $receiverIds = $request->receiver_ids ?? [];
        $receiverIds2 = User::where('id', '!=', $user->id)
            ->select('id')
            ->when($request->roles, function ($query) use ($request) {
                $query->whereIn('role', $request->roles);
            })
            ->pluck('id')
            ->toArray();

        $receiverIds = array_unique(array_merge($receiverIds2, $receiverIds));

        // Remove current user id from receiver ids
        $receiverIds = array_diff($receiverIds, [$user->id]);

        // If receiver ids are empty return error
        if (0 == count($receiverIds)) {
            return new ApiResource([
                'message' => 'No receiver found',
                'status' => 422,
            ]);
        }

        $request->merge(['receiver_ids' => $receiverIds]);
        $message = null;
        $broadcast_id = strHelper('uuid');

        foreach ($receiverIds as $receiver_id) {
            $message = $this->sendBroadcast($user, $request, $receiver_id, $broadcast_id);
        }

        // Remove receiver_id from the message
        $message->makeHidden(['receiver_id', 'sender_id', 'uuid', 'sender', 'receiver', 'user']);

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
            ->latest()
            ->paginate(20);

        $temp = $messages->reverse()->values();

        // Create new Paginator
        $messages = new LengthAwarePaginator(
            $temp->map(function ($message) use ($user) {
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
