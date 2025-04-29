@extends('layouts.applicant')

@section('title', 'My Applications')

@section('content')
<div class="flex">

        <x-applicant.sidebar />

        <div class="flex-1 bg-gray-50">
            <div class="py-8 px-12">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">My Applications</h1>
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Find More Jobs
                    </a>
                </div>

                <x-profile-completion-alert :percentage="$profileCompletionPercentage" userType="applicant" />

                @if(count($applications) > 0)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            @foreach($applications as $application)
                            <div class="p-6 hover:bg-gray-50">
                                <div class="flex flex-col md:flex-row justify-between">
                                    <div class="mb-4 md:mb-0">
                                        <h2 class="text-lg font-medium text-gray-900">{{ $application->job->title }}</h2>
                                        <p class="text-sm text-gray-600">{{ $application->job->employer->company_name }}</p>
                                        <div class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $application->job->location }}
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{
                                            $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                            ($application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' :
                                            ($application->status === 'accepted' ? 'bg-green-100 text-green-800' :
                                            ($application->status === 'to_be_interviewed' ? 'bg-purple-100 text-purple-800' :
                                            'bg-red-100 text-red-800')))
                                        }}">
                                            {{ $application->status === 'to_be_interviewed' ? 'To Be Interviewed' : ucfirst($application->status) }}
                                        </span>
                                        <time datetime="{{ $application->applied_at }}" class="text-sm text-gray-500 mt-2">
                                            Applied {{ $application->applied_at->diffForHumans() }}
                                        </time>
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <div class="flex space-x-4">
                                        <a href="{{ route('jobs.show', $application->job->id) }}" class="text-sm text-neksjob-blue hover:text-neksjob-blue-dark font-medium">
                                            View Job Details
                                        </a>
                                        @if($application->resume_path)
                                        <span class="text-sm text-gray-500">
                                            Resume included
                                        </span>
                                        @endif
                                    </div>

                                    @if($application->status === 'to_be_interviewed')
                                        @php
                                            $interview = $application->interview;
                                        @endphp

                                        @if($interview && ($application->interview_status === 'pending' || $application->interview_status === null))
                                            <div class="mt-4 border-t pt-4 border-gray-200">
                                                <div class="bg-blue-50 p-4 rounded-md mb-4">
                                                    <div class="flex">
                                                        <div class="flex-shrink-0">
                                                            <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                        <div class="ml-3 flex-1">
                                                            <h3 class="text-md font-medium text-blue-800">You've been invited for an interview!</h3>
                                                            @if($interview)
                                                                <div class="mt-3 text-sm text-blue-700 bg-white p-3 rounded-md border border-blue-200">
                                                                    <ul class="list-disc pl-5 space-y-2">
                                                                        @if($interview->interview_date && $interview->interview_time)
                                                                            <li>
                                                                                <span class="font-medium">Date:</span>
                                                                                {{ $interview->interview_date->format('l, F j, Y') }}
                                                                                at {{ $interview->interview_time->format('g:i A') }}
                                                                            </li>
                                                                        @endif
                                                                        @if($interview->location)
                                                                            <li>
                                                                                <span class="font-medium">Location:</span>
                                                                                <span class="inline-flex items-center">
                                                                                    <svg class="h-4 w-4 text-gray-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                                    </svg>
                                                                                    {{ $interview->location }}
                                                                                </span>
                                                                            </li>
                                                                        @endif
                                                                        @if($interview->meeting_link)
                                                                            <li>
                                                                                <span class="font-medium">Meeting Link:</span>
                                                                                <a href="{{ $interview->meeting_link }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 underline">
                                                                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                                                    </svg>
                                                                                    Join Meeting
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>

                                                                <div class="mt-4 mb-2 text-sm text-gray-600">
                                                                    Please confirm whether you would like to attend this interview:
                                                                </div>

                                                                <div class="mt-4 flex flex-col sm:flex-row sm:space-x-4 space-y-3 sm:space-y-0">
                                                                    <form action="{{ route('applicant.interviews.accept', $interview->id) }}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                            </svg>
                                                                            Accept Interview
                                                                        </button>
                                                                    </form>

                                                                    <button type="button" onclick="toggleDeclineForm('decline-form-{{ $interview->id }}')" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue transition-colors duration-200">
                                                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                        Decline Interview
                                                                    </button>
                                                                </div>

                                                                <div id="decline-form-{{ $interview->id }}" class="hidden mt-4 bg-gray-100 p-4 rounded-md border border-gray-300">
                                                                    <form action="{{ route('applicant.interviews.decline', $interview->id) }}" method="POST">
                                                                        @csrf
                                                                        <div>
                                                                            <label for="reason" class="block text-sm font-medium text-gray-700">Reason for declining (optional)</label>
                                                                            <textarea name="reason" id="reason" rows="3" placeholder="Please explain why you're unable to attend this interview..." class="mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-neksjob-blue focus:border-neksjob-blue"></textarea>
                                                                        </div>
                                                                        <div class="mt-4 flex justify-end">
                                                                            <button type="button" onclick="toggleDeclineForm('decline-form-{{ $interview->id }}')" class="mr-3 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                                                                                Cancel
                                                                            </button>
                                                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                                                <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                                </svg>
                                                                                Confirm Decline
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <div class="mt-3 text-sm text-blue-700 bg-white p-3 rounded-md border border-blue-200">
                                                                    <p>Interview details are being prepared. Please check back later.</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($application->interview_status === 'accepted')
                                            <div class="mt-4 border-t pt-4 border-gray-200">
                                                <div class="bg-green-50 p-4 rounded-md">
                                                    <div class="flex">
                                                        <div class="flex-shrink-0">
                                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <div class="ml-3">
                                                            <h3 class="text-md font-medium text-green-800">You've accepted this interview</h3>
                                                            @if($interview)
                                                                <div class="mt-3 text-sm text-green-700 bg-white p-3 rounded-md border border-green-200">
                                                                    <ul class="list-disc pl-5 space-y-2">
                                                                        @if($interview->interview_date && $interview->interview_time)
                                                                            <li>
                                                                                <span class="font-medium">Date:</span>
                                                                                {{ $interview->interview_date->format('l, F j, Y') }}
                                                                                at {{ $interview->interview_time->format('g:i A') }}
                                                                            </li>
                                                                        @endif
                                                                        @if($interview->location)
                                                                            <li>
                                                                                <span class="font-medium">Location:</span>
                                                                                <span class="inline-flex items-center">
                                                                                    <svg class="h-4 w-4 text-gray-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                                    </svg>
                                                                                    {{ $interview->location }}
                                                                                </span>
                                                                            </li>
                                                                        @endif
                                                                        @if($interview->meeting_link)
                                                                            <li>
                                                                                <span class="font-medium">Meeting Link:</span>
                                                                                <a href="{{ $interview->meeting_link }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-800 underline">
                                                                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                                                    </svg>
                                                                                    Join Meeting
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                                <div class="mt-3 text-sm text-green-700">
                                                                    <p>Make sure to be prepared and on time for your interview. Good luck!</p>
                                                                </div>
                                                            @else
                                                                <div class="mt-3 text-sm text-green-700 bg-white p-3 rounded-md border border-green-200">
                                                                    <p>Interview details are being prepared. Please check back later.</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($application->interview_status === 'declined')
                                            <div class="mt-4 border-t pt-4 border-gray-200">
                                                <div class="bg-red-50 p-4 rounded-md">
                                                    <div class="flex">
                                                        <div class="flex-shrink-0">
                                                            <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <div class="ml-3">
                                                            <h3 class="text-md font-medium text-red-800">You've declined this interview</h3>
                                                            @if($interview)
                                                                <div class="mt-3 text-sm text-red-700 bg-white p-3 rounded-md border border-red-200">
                                                                    <ul class="list-disc pl-5 space-y-2">
                                                                        @if($interview->interview_date && $interview->interview_time)
                                                                            <li>
                                                                                <span class="font-medium">Date:</span>
                                                                                {{ $interview->interview_date->format('l, F j, Y') }}
                                                                                at {{ $interview->interview_time->format('g:i A') }}
                                                                            </li>
                                                                        @endif
                                                                        @if($interview->location)
                                                                            <li>
                                                                                <span class="font-medium">Location:</span>
                                                                                <span class="inline-flex items-center">
                                                                                    <svg class="h-4 w-4 text-gray-500 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                                    </svg>
                                                                                    {{ $interview->location }}
                                                                                </span>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                                <div class="mt-3 text-sm text-red-700">
                                                                    <p>The employer has been notified. You may want to apply for other jobs.</p>
                                                                </div>
                                                            @else
                                                                <div class="mt-3 text-sm text-red-700 bg-white p-3 rounded-md border border-red-200">
                                                                    <p>Interview details are being prepared. Please check back later.</p>
                                                                </div>
                                                            @endif
                                                            <div class="mt-4">
                                                                <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                                                                    <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                                    </svg>
                                                                    Find More Jobs
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-6">
                        {{ $applications->links() }}
                    </div>
                @else
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by applying to your first job.</p>
                            <div class="mt-6">
                                @if(isset($profileCompletionPercentage) && $profileCompletionPercentage >= 100)
                                <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    Browse Jobs
                                </a>
                                @else
                                <a href="{{ route('applicant.profile') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    Complete Your Profile
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleDeclineForm(id) {
            const form = document.getElementById(id);
            form.classList.toggle('hidden');
        }
    </script>
@endsection
