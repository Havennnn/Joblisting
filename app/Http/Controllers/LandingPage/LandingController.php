<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use App\Models\Company;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the main landing page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $featured = []; // Empty array since we removed FeaturedItem
        $events = []; // Empty array since we removed Event
        $blogs = []; // Empty array since we removed Blog

        $recentJobs = JobPost::with(['company', 'employer'])
            ->latest()
            ->take(6)
            ->get();

        return view('web.landing.landing', compact('featured', 'events', 'recentJobs', 'blogs'));
    }
}
