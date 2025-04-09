@extends('layouts.landing')

@section('title', $job->title . ' - NeksJob')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <!-- Job Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                    <p class="mt-1 text-lg text-gray-600">{{ $job->employer->company_name ?? 'Company' }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="#apply" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Apply Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Job Details -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column - Main Details -->
            <div class="md:col-span-2">
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Job Description</h2>
                    <div class="prose max-w-none text-gray-600">
                        <p>{{ $job->job_description }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Qualifications</h2>
                    <div class="prose max-w-none text-gray-600">
                        <p>{{ $job->qualifications }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Additional Info -->
            <div class="space-y-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-medium text-gray-900 mb-3">Job Details</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Location:</span>
                            <span class="text-gray-900 font-medium">{{ $job->location }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Job Type:</span>
                            <span class="text-gray-900 font-medium">{{ $job->type }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Work Setup:</span>
                            <span class="text-gray-900 font-medium">{{ $job->work_setup }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Industry:</span>
                            <span class="text-gray-900 font-medium">{{ $job->industry }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Role:</span>
                            <span class="text-gray-900 font-medium">{{ $job->role }}</span>
                        </div>
                        @if($job->salary > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Salary:</span>
                            <span class="text-gray-900 font-medium">${{ number_format($job->salary, 2) }} per year</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Vacancies:</span>
                            <span class="text-gray-900 font-medium">{{ $job->vacancies }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Experience:</span>
                            <span class="text-gray-900 font-medium">{{ $job->work_experience_level }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Education:</span>
                            <span class="text-gray-900 font-medium">{{ $job->educational_level }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Shift:</span>
                            <span class="text-gray-900 font-medium">{{ $job->shift }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-medium text-gray-900 mb-3">Job Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Posted On:</span>
                            <span class="text-gray-900 font-medium">{{ $job->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Start Date:</span>
                            <span class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($job->starting_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Expires On:</span>
                            <span class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($job->expiration_date)->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Section -->
        <div id="apply" class="p-6 bg-gray-50 border-t border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Apply for this position</h2>
            @auth
                @if(auth()->user()->isApplicant())
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}">

                    <div>
                        <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-1">Cover Letter</label>
                        <textarea id="cover_letter" name="cover_letter" rows="4" class="shadow-sm block w-full focus:ring-blue-500 focus:border-blue-500 sm:text-sm border-gray-300 rounded-md"></textarea>
                    </div>

                    <div>
                        <label for="resume" class="block text-sm font-medium text-gray-700 mb-1">Resume/CV</label>
                        <input type="file" id="resume" name="resume" class="shadow-sm block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit Application
                        </button>
                    </div>
                </form>
                @else
                <div class="text-center py-4">
                    <p class="text-gray-600 mb-4">You need an applicant account to apply for this job.</p>
                    <a href="{{ route('applicant.login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sign in as Jobseeker
                    </a>
                </div>
                @endif
            @else
            <div class="text-center py-4">
                <p class="text-gray-600 mb-4">Please sign in to apply for this job.</p>
                <a href="{{ route('applicant.login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Sign in as Jobseeker
                </a>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection
