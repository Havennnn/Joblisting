<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LandingPage\JobController;
use App\Models\JobPost;
use App\Models\Event;
use App\Models\Blog;
use App\Models\FeaturedItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    protected $jobController;

    public function __construct(JobController $jobController)
    {
        $this->jobController = $jobController;
    }

    /**
     * Display the main landing page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $featured = FeaturedItem::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        $events = Event::where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->take(4)
            ->get();

        $jobs = JobPost::with('employer')
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();

        $blogs = Blog::where('is_published', true)
            ->orderBy('created_at', 'DESC')
            ->take(3)
            ->get();

        return view('landing.landing', compact('featured', 'events', 'jobs', 'blogs'));
    }

    /**
     * Display the jobs list page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function jobs(): View
    {
        return $this->jobController->index();
    }

    /**
     * Display a specific job details
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function jobDetails($id): View
    {
        return $this->jobController->show($id);
    }
}
