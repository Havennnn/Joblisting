<?php

namespace App\Http\Controllers\Employer\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;

class ActiveJobPostsController extends Controller
{
    /**
     * Get active job posts count for the dashboard
     */
    public function __invoke()
    {
        $employer = Auth::user()->employer;

        // Get the count of active job posts for the employer
        $activeJobPosts = JobPost::where('employer_id', $employer->id)
                                ->where('auto_delete_at', '>', now())
                                ->count();

        return $activeJobPosts;
    }
}
