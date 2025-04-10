<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Get all notifications
        $notifications = $user->notifications()->paginate(10);

        return view('applicant.notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark all notifications as read
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read');
    }

    /**
     * Delete a notification
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
        }

        return redirect()->back()->with('success', 'Notification deleted');
    }
}
