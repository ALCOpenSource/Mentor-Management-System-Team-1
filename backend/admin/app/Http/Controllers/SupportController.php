<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use App\Http\Resources\ApiResource;
use App\Models\SupportTickets;
use App\Models\User;
use App\Notifications\NewSupportTicketCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SupportController extends Controller
{
    /**
     * Gets the support tickets.
     *
     * @param mixed $previous_messages
     * @param mixed $message
     * @param mixed $role
     * @param mixed $user_id
     * @param mixed $support
     * @param mixed $attachment
     */
    protected function getSupportMessage($support, $message, $role, $user_id, $attachment)
    {
        $temp = [];

        if ($support->message) {
            $temp = $support->message;
        }

        $message_type = 'text';

        if ($attachment) {
            $support->storeAttachment($attachment, 'attachment', $support->uuid);
        }

        $temp[] = [
            'message' => $message,
            'datetime' => now()->toDateTimeString(),
            'date' => now()->toDateString(),
            'time' => now()->toTimeString(),
            'role' => $role,
            'user_id' => $user_id,
            'type' => $message_type,
        ];

        return $temp;
    }

    /**
     * Get support.
     */
    public function createSupport(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string|max:600',
            'attachment' => 'nullable|file|max:10240|mime:jpg,jpeg,png,webm,txt,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
        ]);

        // If message is empty and attachment is empty return error
        if (! $request->message && ! $request->attachment) {
            return new ApiResource(['data' => null, 'message' => 'Message or attachment is required.', 'status' => 422]);
        }

        $support = new SupportTickets();
        $support->name = $request->name;
        $support->email = $request->email;
        $support->subject = $request->subject;
        $support->message = $this->getSupportMessage($support, $request->message, 'user', $request->user()->id, $request->attachment);

        $support->status = 'pending';
        $support->user_id = $request->user()->id;
        $support->save();

        // Create notification that will be sent to admin and support team
        // Get all admins and support team
        $admins = callStatic(User::class, 'where', function ($query) {
            $query->where('role', AppConstants::ROLE_ADMIN)
                ->orWhere('role', AppConstants::ROLE_ASSISTANT);
        })->get();

        // Send notification to all admins and support team
        foreach ($admins as $admin) {
            $admin->notify(new NewSupportTicketCreatedNotification($support));
        }

        return new ApiResource(['data' => $support, 'message' => 'Support ticket created successfully.', 'status' => 201]);
    }

    /**
     * Update support.
     *
     * @param mixed $support_id
     */
    public function updateSupport(Request $request, $support_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string|max:600',
            'attachment' => 'nullable|file|max:10240|mime:jpg,jpeg,png,webm,txt,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts',
        ]);

        // If message is empty and attachment is empty return error
        if (! $request->message && ! $request->attachment) {
            return new ApiResource(['data' => null, 'message' => 'Message or attachment is required.', 'status' => 422]);
        }

        $support = callStatic(SupportTickets::class, 'where', function ($query) {
            $query->where('user_id', auth()->user()->id)
                ->orWhere('assigned_user_id', auth()->user()->id);
        })->where('id', $support_id)->first();

        if (! $support) {
            return new ApiResource(['data' => null, 'message' => 'Support ticket not found.', 'status' => 404]);
        }

        $support->name = $request->name;
        $support->email = $request->email;
        $support->subject = $request->subject;
        $support->message = $this->getSupportMessage($support, $request->message, 'user', $request->user()->id, $request->attachment);
        $support->status = 'pending';
        $support->user_id = $request->user()->id;
        $support->save();

        return new ApiResource(['data' => $support]);
    }

    /**
     * Get all support.
     */
    public function getSupport()
    {
        $support = callStatic(SupportTickets::class, 'where', function ($query) {
            $query->where('user_id', auth()->user()->id)
                ->orWhere('assigned_user_id', auth()->user()->id);
        })->get();

        return new ApiResource($support);
    }

    /**
     * Get specific support.
     *
     * @param mixed $support_id
     */
    public function getSpecificSupport(Request $request, $support_id)
    {
        $support = callStatic(SupportTickets::class, 'where', function ($query) {
            $query->where('user_id', auth()->user()->id)
                ->orWhere('assigned_user_id', auth()->user()->id);
        })->where('id', $support_id)->first();

        // Only an assistant or admin, or the user that created the ticket can close a support ticket.
        if ($support->user_id != auth()->user()->id || ! $request->user()->hasRole([AppConstants::ROLE_ADMIN, AppConstants::ROLE_ASSISTANT])) {
            return new ApiResource(['error' => 'You are not authorized to close a support ticket.', 'status' => 403]);
        }

        return new ApiResource(['data' => $support]);
    }

    /**
     * Delete support.
     *
     * @param mixed $support_id
     */
    public function deleteSupport(Request $request, $support_id)
    {
        $support = callStatic(SupportTickets::class, 'where', 'user_id', $request->user()->id)->where('id', $support_id)->first();

        if (! $support) {
            return new ApiResource(['data' => null, 'message' => 'Support ticket not found.', 'status' => 404]);
        }

        $support->delete();

        return new ApiResource(['data' => $support, 'message' => 'Support ticket deleted']);
    }

    /**
     * Close support.
     *
     * @param mixed $support_id
     */
    public function closeSupport(Request $request, $support_id)
    {
        $support = callStatic(SupportTickets::class, 'find', $support_id);

        if (! $support) {
            return new ApiResource(['data' => null, 'message' => 'Support ticket not found.', 'status' => 404]);
        }

        // Only an assistant or admin, or the user that created the ticket can close a support ticket.
        if ($support->user_id != auth()->user()->id || ! $request->user()->hasRole([AppConstants::ROLE_ADMIN, AppConstants::ROLE_ASSISTANT])) {
            return new ApiResource(['error' => 'You are not authorized to close a support ticket.', 'status' => 403]);
        }

        $support->status = 'closed';
        $support->save();

        return new ApiResource(['data' => $support, 'message' => 'Support ticket closed']);
    }

    /**
     * Open support.
     *
     * @param mixed $support_id
     */
    public function openSupport(Request $request, $support_id)
    {
        $support = callStatic(SupportTickets::class, 'find', $support_id);

        if (! $support) {
            return new ApiResource(['data' => null, 'message' => 'Support ticket not found.', 'status' => 404]);
        }

        // Only an assistant or admin, or the user that created the ticket can close a support ticket.
        if ($support->user_id != auth()->user()->id || ! $request->user()->hasRole([AppConstants::ROLE_ADMIN, AppConstants::ROLE_ASSISTANT])) {
            return new ApiResource(['error' => 'You are not authorized to close a support ticket.', 'status' => 403]);
        }

        $support->status = 'open';
        $support->save();

        return new ApiResource(['data' => $support, 'message' => 'Support ticket opened']);
    }

    /**
     * Delete all support.
     */
    public function deleteAllSupport(Request $request)
    {
        $support_tickets = callStatic(SupportTickets::class, 'where', 'user_id', $request->user()->id)->get();

        foreach ($support_tickets as $support_ticket) {
            $support_ticket->delete();
        }

        return new ApiResource(['data' => $support_tickets, 'message' => 'All support tickets deleted']);
    }

    /**
     * Accept support and assign yourself the ticket.
     *
     * @param mixed $support_id
     */
    public function acceptSupport(Request $request, $support_id)
    {
        $support = callStatic(SupportTickets::class, 'find', $support_id);

        if (! $support) {
            return new ApiResource(['data' => null, 'message' => 'Support ticket not found.', 'status' => 404]);
        }

        // Only an assistant or admin, or the user that created the ticket can close a support ticket.
        if ($support->user_id == auth()->user()->id || ! $request->user()->hasRole([AppConstants::ROLE_ADMIN, AppConstants::ROLE_ASSISTANT])) {
            return new ApiResource(['error' => 'You are not authorized to accept a support ticket.', 'status' => 403]);
        }

        $support->assigned_user_id = $request->user()->id;
        $support->save();

        return new ApiResource(['data' => $support, 'message' => 'Support ticket accepted']);
    }

    /**
     * Get support image.
     *
     * @param mixed $fileName
     */
    public function getSupportImage($fileName)
    {
        $path = storage_path('app/public/support/'.$fileName);

        if (! callStatic(File::class, 'exists', $path)) {
            abort(404);
        }

        $file = callStatic(File::class, 'get', $path);
        $type = callStatic(File::class, 'mimeType', $path);

        return response()->make($file, 200, [
            'Content-Type' => $type,
            'Content-Disposition' => 'inline; filename="'.$fileName.'"',
        ]);
    }

    /**
     * Assign support to another user.
     *
     * @param mixed $support_id
     */
    public function assignSupport(Request $request, $support_id)
    {
        $support = callStatic(SupportTickets::class, 'find', $support_id);

        if (! $support) {
            return new ApiResource(['data' => null, 'message' => 'Support ticket not found.', 'status' => 404]);
        }

        // Only an assistant or admin, or the user that was assigned  the ticket can close a support ticket.
        if ($support->assigned_user_id !== auth()->user()->id || ! $request->user()->hasRole([AppConstants::ROLE_ADMIN])) {
            return new ApiResource(['error' => 'You are not authorized to close a support ticket.', 'status' => 403]);
        }

        // Check if the user exists.
        $user = callStatic(User::class, 'find', $request->assigned_user_id);

        if (! $user) {
            return new ApiResource(['data' => null, 'message' => 'User not found.', 'status' => 404]);
        }

        $support->assigned_user_id = $request->assigned_user_id;
        $support->save();

        return new ApiResource(['data' => $support, 'message' => 'Support ticket assigned']);
    }
}
