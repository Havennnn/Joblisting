<?php

namespace App\Http\Controllers\Employer\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetNotificationsController extends Controller
{
    /**
     * Get paginated list of notifications for the current user
     */
    public function __invoke()
    {
        $user = Auth::user();

        // Get all notifications with pagination
        return $user->notifications()->paginate(10);
    }
}
