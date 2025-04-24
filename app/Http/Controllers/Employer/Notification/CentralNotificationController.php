<?php

namespace App\Http\Controllers\Employer\Notification;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Central controller for handling all notification-related operations for employers
 */
class CentralNotificationController extends Controller
{
    /**
     * Display a listing of the employer's notifications.
     *
     * @param ProfileCompletionService $completionService
     * @return \Illuminate\View\View
     */
    public function index(ProfileCompletionService $completionService)
    {
        $user = Auth::user();
        $profileCompletionPercentage = $completionService->calculateEmployerCompletion($user);
        $notifications = $user->notifications()->paginate(10);

        return view('employer.notifications.index', [
            'notifications' => $notifications,
            'profileCompletionPercentage' => $profileCompletionPercentage
        ]);
    }

    /**
     * Mark specific notification as read
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if (!$notification) {
            return back()->with('error', 'Notification not found.');
        }

        $notification->markAsRead();
        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Delete the specified notification
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if (!$notification) {
            return back()->with('error', 'Notification not found.');
        }

        $notification->delete();
        return back()->with('success', 'Notification deleted successfully.');
    }
}
