<?php

namespace App\Http\Controllers\Applicant\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class IndexController extends Controller
{

    /**
     * Display a listing of the user's notifications
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        $user = Auth::user();

        // Get all notifications
        $notifications = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('applicant.notifications.index', compact('notifications'));
    }
}
