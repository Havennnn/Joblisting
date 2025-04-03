<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use Carbon\Carbon;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $JobPosts = JobPost::orderBy('created_at', 'DESC')->get();

        return view('JobPost.index', compact('JobPosts'));
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
        // Prepare data with default values for null fields
        $data = $request->all();
        
        // Set default values for date fields if they're null
        $data['starting_date'] = $data['starting_date'] ?? Carbon::now()->format('Y-m-d');
        $data['expiration_date'] = $data['expiration_date'] ?? Carbon::now()->addMonths(3)->format('Y-m-d');
        
        // Set default values for numeric fields if they're null
        $data['salary'] = $data['salary'] ?? 0;
        $data['vacancies'] = $data['vacancies'] ?? 1;
        
        // Create the job post with the prepared data
        JobPost::create($data);

        return redirect()->route('employer.JobPost')->with('success', 'Job added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $JobPost = JobPost::findOrFail($id);

        return view('JobPost.show', compact('JobPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $JobPost = JobPost::findOrFail($id);

        return view('JobPost.edit', compact('JobPost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $JobPost = JobPost::findOrFail($id);
        
        // Prepare data with default values for null fields
        $data = $request->all();
        
        // Set default values for date fields if they're null
        $data['starting_date'] = $data['starting_date'] ?? Carbon::now()->format('Y-m-d');
        $data['expiration_date'] = $data['expiration_date'] ?? Carbon::now()->addMonths(3)->format('Y-m-d');
        
        // Set default values for numeric fields if they're null
        $data['salary'] = $data['salary'] ?? 0;
        $data['vacancies'] = $data['vacancies'] ?? 1;
        
        // Update the job post with the prepared data
        $JobPost->update($data);

        return redirect()->route('employer.JobPost')->with('success', 'Job updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $JobPost = JobPost::findOrFail($id);

        $JobPost->delete();

        return redirect()->route('employer.JobPost')->with('success', 'Job deleted successfully');
    }
}

