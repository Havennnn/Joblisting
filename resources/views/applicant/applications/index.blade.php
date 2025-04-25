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
                                            ($application->status === 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'))
                                        }}">
                                            {{ ucfirst($application->status) }}
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
@endsection
