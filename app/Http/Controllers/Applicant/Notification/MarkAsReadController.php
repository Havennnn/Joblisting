<?php

namespace App\Http\Controllers\Applicant\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class MarkAsReadController extends Controller
{
    /**
     * Mark a notification as read
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back()->with('success', 'Notification marked as read');
    }
}
