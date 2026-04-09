<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Return latest notifications for the authenticated user (JSON).
     */
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([], 401);
        }

        $notifications = $user->notifications()->latest()->take(20)->get();
        return response()->json($notifications);
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }
}
