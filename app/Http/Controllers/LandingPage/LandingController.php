<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\Jobs\JobPost;
use App\Models\Content\Event;
use App\Models\Content\Blog;
use App\Models\Content\FeaturedItem;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
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
}
