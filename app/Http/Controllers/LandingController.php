<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Event;
use App\Models\Blog;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $jobs = Job::all(); // Fetch jobs
        $events = Event::all(); // Fetch events
        $blogs = Blog::all(); //Fetch blog posts

        return view('landing', compact('jobs', 'events', 'blogs'));
    }
}
