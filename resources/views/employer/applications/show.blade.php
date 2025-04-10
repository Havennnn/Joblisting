@extends('layouts.employer')

@section('title', 'Application Details')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('employer.applications.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Applications
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">
                            Application for {{ $application->job->title }}
                        </h1>
                        <p class="text-sm text-gray-500">
                            Applied {{ $application->applied_at->diffForHumans() }} on {{ $application->applied_at->format('M d, Y \a\t h:i A') }}
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                              ($application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' :
                              ($application->status === 'accepted' ? 'bg-green-100 text-green-800' :
                              'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Applicant Information -->
            <div class="md:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Applicant Information</h2>

                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Personal Details</h3>
                            <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Name:</span> {{ $application->applicant->name }}</p>
                            <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Email:</span> {{ $application->applicant->email }}</p>
                            @if($application->applicant->applicantProfile)
                                <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Phone:</span> {{ $application->applicant->applicantProfile->phone_number ?? 'Not provided' }}</p>
                                <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Location:</span> {{ $application->applicant->applicantProfile->location ?? 'Not provided' }}</p>
                            @endif
                        </div>

                        @if($application->resume_path)
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Resume</h3>
                                <a href="{{ Storage::url($application->resume_path) }}" target="_blank"
                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Download Resume
                                </a>
                            </div>
                        @endif

                        @if($application->applicant->applicantProfile)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Skills & Experience</h3>
                                @if($application->applicant->applicantProfile->skills)
                                    <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Skills:</span> {{ $application->applicant->applicantProfile->skills }}</p>
                                @endif
                                @if($application->applicant->applicantProfile->experience)
                                    <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Experience:</span> {{ $application->applicant->applicantProfile->experience }} years</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Job Details & Application Management -->
            <div class="md:col-span-2">
                <!-- Job Details -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Job Details</h2>

                        <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Position:</span> {{ $application->job->title }}</p>
                        <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Location:</span> {{ $application->job->location }}</p>
                        @if($application->job->salary)
                            <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Salary:</span> {{ $application->job->salary }}</p>
                        @endif
                        <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Job Type:</span> {{ $application->job->job_type }}</p>
                        <p class="text-sm text-gray-900 mb-1"><span class="font-medium">Experience Required:</span> {{ $application->job->experience_required }} years</p>

                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Job Description</h3>
                            <div class="text-sm text-gray-900 prose max-w-none">
                                {!! $application->job->job_description !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Application Management -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Application Management</h2>

                        <form action="{{ route('employer.applications.update-status', $application->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewing" {{ $application->status === 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                    <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                <textarea id="notes" name="notes" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $application->notes }}</textarea>
                                <p class="mt-2 text-sm text-gray-500">
                                    These notes are for your reference only and are not shared with the applicant.
                                </p>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
