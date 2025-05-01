<?php

namespace App\Http\Controllers\Employer\Interview;

use App\Http\Controllers\Controller;
use App\Models\Interviews\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
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

        $employerId = Auth::id();

        $interviews = Interview::where('employer_id', $employerId)
            ->whereMonth('interview_date', $request->month)
            ->whereYear('interview_date', $request->year)
            ->whereIn('status', ['pending', 'accepted'])
            ->with(['applicant', 'job'])
            ->orderBy('interview_date', 'asc')
            ->orderBy('interview_time', 'asc')
            ->get()
            ->map(function ($interview) {
                return [
                    'id' => $interview->id,
                    'interview_date' => $interview->interview_date->format('Y-m-d'),
                    'interview_time' => $interview->interview_time->format('g:i A'),
                    'meeting_link' => $interview->meeting_link,
                    'status' => $interview->status,
                    'applicant' => [
                        'name' => $interview->applicant->name,
                    ],
                    'job' => [
                        'title' => $interview->job->title,
                    ],
                ];
            });

        return response()->json($interviews);
    }
}
