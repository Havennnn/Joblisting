@extends('layouts.employer')

@section('title', 'Application Details')

@section('content')
    <div class="flex">
        <!-- Sidebar -->
        <x-employer.sidebar />

        <!-- Main Content -->
        <div class="flex-1 bg-gray-50">
            <div class="py-8 px-12">
                <div class="mb-6">
                    <a href="{{ route('employer.applications.index') }}"
                        class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Applications
                    </a>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Profile Completion Alert -->
                @if (isset($completionPercentage) && $completionPercentage < 100)
                    <div class="mb-6 bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-400">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-yellow-800">Complete your profile</h3>
                                <div class="mt-1 text-sm text-yellow-700">
                                    Your company profile is {{ $completionPercentage }}% complete. Completing your profile
                                    helps attract more applicants.
                                </div>
                            </div>
                            <a href="{{ route('employer.profile.edit') }}"
                                class="rounded-md bg-yellow-100 px-3 py-1.5 text-sm font-semibold text-yellow-800 hover:bg-yellow-200">
                                Complete Now
                            </a>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $completionPercentage }}%"></div>
                        </div>
                    </div>
                @endif

                <div class="bg-white rounded-lg shadow-sm mb-6">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                    Application for {{ $application->job->title }}
                                </h1>
                                <p class="text-gray-500">
                                    Applied {{ $application->applied_at->diffForHumans() }} on
                                    {{ $application->applied_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <span
                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                {{ $application->status === 'pending'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : ($application->status === 'reviewing'
                                        ? 'bg-blue-100 text-blue-800'
                                        : ($application->status === 'accepted'
                                            ? 'bg-green-100 text-green-800'
                                            : ($application->status === 'to_be_interviewed'
                                                ? 'bg-purple-100 text-purple-800'
                                                : 'bg-red-100 text-red-800'))) }}">
                                    {{ $application->status === 'to_be_interviewed' ? 'To Be Interviewed' : ucfirst($application->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Applicant Information -->
                    <div class="md:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm h-full">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Applicant Information</h2>

                                <div class="mb-6">
                                    <h3 class="font-medium text-gray-700 mb-2">Personal Details</h3>
                                    <p class="mb-1"><span class="font-medium">Name:</span>
                                        {{ $application->applicant->name }}</p>
                                    <p class="mb-1"><span class="font-medium">Email:</span>
                                        {{ $application->applicant->email }}</p>
                                    @if ($application->applicant->applicantProfile)
                                        <p class="mb-1"><span class="font-medium">Phone:</span>
                                            {{ $application->applicant->applicantProfile->phone_number ?? 'Not provided' }}
                                        </p>
                                        <p class="mb-1"><span class="font-medium">Location:</span>
                                            {{ $application->applicant->applicantProfile->location ?? 'Not provided' }}</p>
                                    @endif
                                </div>

                                @if ($application->resume_path)
                                    <div class="mb-6">
                                        <h3 class="font-medium text-gray-700 mb-2">Resume</h3>
                                        <a href="{{ route('employer.applications.download-resume', $application->id) }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Download Resume
                                        </a>
                                    </div>
                                @endif

                                @if ($application->applicant->applicantProfile)
                                    <div>
                                        <h3 class="font-medium text-gray-700 mb-2">Skills & Experience</h3>
                                        @if ($application->applicant->applicantProfile->skills)
                                            <p class="mb-1"><span class="font-medium">Skills:</span>
                                                {{ $application->applicant->applicantProfile->skills }}</p>
                                        @endif
                                        @if ($application->applicant->applicantProfile->experience)
                                            <p class="mb-1"><span class="font-medium">Experience:</span>
                                                {{ $application->applicant->applicantProfile->experience }} years</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Job Details & Application Management -->
                    <div class="md:col-span-2">
                        <!-- Job Details -->
                        <div class="bg-white rounded-lg shadow-sm mb-6">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Job Details</h2>

                                <p class="mb-1"><span class="font-medium">Position:</span> {{ $application->job->title }}
                                </p>
                                <p class="mb-1"><span class="font-medium">Location:</span>
                                    {{ $application->job->location }}</p>
                                @if ($application->job->salary)
                                    <p class="mb-1"><span class="font-medium">Salary:</span>
                                        {{ $application->job->salary }}</p>
                                @endif
                                <p class="mb-1"><span class="font-medium">Job Type:</span>
                                    {{ $application->job->job_type }}</p>
                                <p class="mb-1"><span class="font-medium">Experience Required:</span>
                                    {{ $application->job->experience_required }} years</p>

                                <div class="mt-6">
                                    <h3 class="font-medium text-gray-700 mb-2">Job Description</h3>
                                    <div class="prose max-w-none border p-4 rounded-md bg-gray-50">
                                        {!! $application->job->job_description !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Application Management -->
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Application Management</h2>

                                <form action="{{ route('employer.applications.update-status', $application->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="status" id="status" value="{{ $application->status }}">

                                    <div class="mt-6 flex items-center justify-between">
                                        @if($application->status !== 'rejected')
                                        <button type="submit"
                                            onclick="document.getElementById('status').value = 'rejected'"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            Reject Application
                                        </button>
                                        @endif

                                        @if($application->status !== 'accepted' && $application->status !== 'to_be_interviewed')
                                        <a href="{{ route('employer.applications.schedule.form', $application->id) }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Schedule Interview
                                        </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
