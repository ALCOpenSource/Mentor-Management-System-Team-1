<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get notifications.
     */
    public function getNotifications(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->paginate(10);

        return new ApiResource($notifications);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Request $request)
    {
        // Get list of notification ids
        $notificationIds = $request->input('notification_ids');

        // Mark as read
        $request->user()->notifications()->whereIn('id', $notificationIds)->update(['read_at' => now()]);

        return new ApiResource([
            'message' => 'Notifications marked as read',
        ]);
    }

    /**
     * Delete notification.
     *
     * @param mixed $id
     */
    public function deleteNotification(Request $request, $id)
    {
        $notification = $request->user()->notifications()->where('id', $id)->first();

        if (! $notification) {
            return new ApiResource([
                'message' => 'Notification not found',
                'status' => 404,
            ]);
        }

        $notification->delete();

        return new ApiResource([
            'message' => 'Notification deleted',
        ]);
    }
}
