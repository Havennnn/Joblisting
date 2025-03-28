<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        return view('interview', compact('jobs'));
    }
}
