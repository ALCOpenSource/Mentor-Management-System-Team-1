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
        $notificationIds = $request->notification_ids;

        // Mark as read
        $request->user()->notifications()->whereIn('id', $notificationIds)->update(['read_at' => now()]);

        return new ApiResource([
            'message' => 'Notifications marked as read',
        ]);
    }

    /**
     * Delete notification.
     *
     * @param mixed $notification_id
     */
    public function deleteNotification(Request $request, $notification_id)
    {
        $notification = $request->user()->notifications()->where('id', $notification_id)->first();

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

    /**
     * Delete all notifications.
     */
    public function deleteAllNotifications(Request $request)
    {
        $request->user()->notifications()->delete();

        return new ApiResource([
            'message' => 'All notifications deleted',
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return new ApiResource([
            'message' => 'All notifications marked as read',
        ]);
    }

    /**
     * Get unread notifications count.
     */
    public function getUnreadNotificationsCount(Request $request)
    {
        $unreadNotificationsCount = $request->user()->unreadNotifications()->count();

        return new ApiResource([
            'unread_notifications_count' => $unreadNotificationsCount,
        ]);
    }
}
