<?php

namespace App\Http\Controllers\Employer\JobListing;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DestroyController extends Controller
{
    /**
     * Remove the specified job post from storage.
     */
    public function __invoke(string $id)
    {
        $employer = Auth::user()->employer;
        $JobPost = JobPost::where('employer_id', $employer->id)
                          ->findOrFail($id);

        $JobPost->delete();

        return redirect()->route('employer.JobPost')->with('success', 'Job deleted successfully');
    }
}
