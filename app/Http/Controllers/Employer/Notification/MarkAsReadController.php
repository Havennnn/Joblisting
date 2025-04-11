<?php

namespace App\Http\Controllers\Employer\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkAsReadController extends Controller
{
    /**
     * Mark a specific notification as read
     */
    public function __invoke($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return true;
        }

        return false;
    }
}
