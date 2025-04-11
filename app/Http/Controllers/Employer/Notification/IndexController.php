<?php

namespace App\Http\Controllers\Employer\Notification;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\ProfileCompletionService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $profileCompletionService;

    public function __construct(ProfileCompletionService $profileCompletionService)
    {
        $this->profileCompletionService = $profileCompletionService;
    }

    /**
     * Display a listing of the employer's notifications
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke()
    {
        $user = Auth::user();
        $completionPercentage = $this->profileCompletionService->calculateEmployerCompletion($user);

        // Get all notifications
        $notifications = $user->notifications()->paginate(10);

        return view('employer.notifications.index', compact('notifications', 'completionPercentage'));
    }
}
