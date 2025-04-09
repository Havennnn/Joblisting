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
                <!-- Company Information -->
                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mr-4">
                            @if($job->employer->company_logo_path)
                                <img src="{{ asset('storage/' . $job->employer->company_logo_path) }}" alt="Company Logo" class="h-16 w-16 rounded-lg object-cover">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M3 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $job->employer->company_name }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $job->employer->industry }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $job->employer->location }}</p>
                            @if($job->employer->website)
                                <a href="{{ $job->employer->website }}" target="_blank" class="mt-2 text-sm text-blue-600 hover:text-blue-800 inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd" />
                                    </svg>
                                    Visit Website
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Job Description</h2>
                    <div class="prose max-w-none text-gray-600">
                        <p>{{ $job->job_description }}</p>
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
                            <span class="text-gray-900 font-medium">₱{{ number_format($job->salary, 2) }} per month</span>
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
                    <h3 class="font-medium text-gray-900 mb-3">Job Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Posted On:</span>
                            <span class="text-gray-900 font-medium">{{ $job->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Available Until:</span>
                            <span class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($job->auto_delete_at)->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $job->tags == 'Urgent' ? 'bg-red-100 text-red-800' : ($job->tags == 'Featured' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $job->tags }}
                        </span>
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
