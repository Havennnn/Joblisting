<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Interviews\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    /**
     * Display the interview calendar
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('applicant.interviews.index');
    }

    /**
     * Get interviews for a specific month
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInterviews(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $interviews = Interview::where('applicant_id', Auth::id())
            ->whereMonth('interview_date', $request->month)
            ->whereYear('interview_date', $request->year)
            ->with('job')
            ->get()
            ->map(function ($interview) {
                return [
                    'id' => $interview->id,
                    'interview_date' => $interview->interview_date->format('Y-m-d'),
                    'interview_time' => $interview->interview_time->format('g:i A'),
                    'meeting_link' => $interview->meeting_link,
                    'job' => [
                        'title' => $interview->job->title,
                    ],
                ];
            });

        return response()->json($interviews);
    }
}
