<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Event;
use App\Models\Blog;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // We'll simplify here since the models might not exist yet
        $jobs = []; // Job::all(); // Fetch jobs
        $events = []; // Event::all(); // Fetch events
        $blogs = []; // Blog::all(); //Fetch blog posts

        return view('landing.landing', compact('jobs', 'events', 'blogs'));
    }
}
