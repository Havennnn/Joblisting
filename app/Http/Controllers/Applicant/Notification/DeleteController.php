<?php

namespace App\Http\Controllers\Applicant\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
        }

        return redirect()->back()->with('success', 'Notification deleted');
    }
}
