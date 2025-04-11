<?php

namespace App\Http\Controllers\Applicant\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class DeleteController extends Controller
{
    /**
     * Delete a notification
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke($id)
    {
        $user = Auth::user();
        $notification = DatabaseNotification::find($id);

        if ($notification && $notification->notifiable_id == $user->id) {
            $notification->delete();
        }

        return redirect()->back()->with('success', 'Notification deleted');
    }
}
