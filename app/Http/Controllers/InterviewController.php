<?php

namespace App\Http\Controllers;

use App\Models\Jobs\JobPost;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index()
    {
        $jobs = JobPost::all();
        return view('interview', compact('jobs'));
    }
}
