<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $JobPost = JobPost::orderBy('created_at', 'DESC')->get();

        return view('JobPost.index', compact('JobPost'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('JobPost.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        JobPost::create($request->all());

        return redirect()->route('jobposts')->with('success', 'Job added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobpost = Jobpost::findOrFail($id);

        return view('jobposts.show', compact('jobpost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobpost = JobPost::findOrFail($id);

        return view('jobposts.edit', compact('jobpost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jobpost = JobPost::findOrFail($id);

        $jobpost->update($request->all());

        return redirect()->route('jobposts')->with('success', 'Job updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobpost = JobPost::findOrFail($id);

        $jobpost->delete();

        return redirect()->route('jobposts')->with('success', 'Job deleted successfully');
    }
}

