@extends('layouts.employer')

@section('title', 'Post New Job')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <x-employer.sidebar />

    <!-- Main Content -->
    <div class="flex-1 bg-gray-50">
        <div class="py-8 px-12">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Post New Job</h1>
                <a href="{{ route('employer.JobPost') }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900">
                    <svg class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Jobs
                </a>
            </div>

            <!-- Welcome card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-8">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-neksjob-blue bg-opacity-10 flex items-center justify-center">
                                <svg class="h-6 w-6 text-neksjob-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h2>
                            <p class="mt-1 text-sm text-gray-600">Create a compelling job posting to attract the perfect candidates.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form card -->
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                <form action="{{ route('employer.JobPost.store') }}" method="POST" class="divide-y divide-gray-200">
                    @csrf

                    <div class="p-6 sm:p-8">
                        <!-- Basic Information -->
                        <div class="space-y-8">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                                        <p class="mt-1 text-sm text-gray-500">Start with the fundamental details of the position.</p>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                                        <div class="mt-1">
                                            <input type="text" name="title" id="title" required placeholder="e.g. Senior Software Engineer"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm placeholder-gray-400">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                                        <div class="mt-1">
                                            <select name="industry" id="industry" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                                <option value="">Select Industry</option>
                                                <option value="Technology and IT">Technology and IT</option>
                                                <option value="Healthcare">Healthcare</option>
                                                <option value="Finance">Finance</option>
                                                <option value="Education">Education</option>
                                                <option value="Manufacturing">Manufacturing</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                        <div class="mt-1">
                                            <select name="role" id="role" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                                <option value="">Select Role</option>
                                                <option value="Software Developer/Engineer">Software Developer/Engineer</option>
                                                <option value="Product Manager">Product Manager</option>
                                                <option value="Data Scientist">Data Scientist</option>
                                                <option value="UX Designer">UX Designer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Details -->
                            <div class="pt-8">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-lg bg-purple-50 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Job Details</h3>
                                        <p class="mt-1 text-sm text-gray-500">Provide a detailed description of the role and requirements.</p>
                                    </div>
                                </div>

                                <div class="mt-6 space-y-6">
                                    <div>
                                        <label for="job_description" class="block text-sm font-medium text-gray-700">
                                            Job Description
                                            <span class="text-sm text-gray-500">(Be specific and include key responsibilities)</span>
                                        </label>
                                        <div class="mt-1">
                                            <textarea name="job_description" id="job_description" rows="5" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm"
                                                placeholder="Describe the main responsibilities, objectives, and expectations for this position..."></textarea>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="qualifications" class="block text-sm font-medium text-gray-700">
                                            Qualifications
                                            <span class="text-sm text-gray-500">(List required skills and experience)</span>
                                        </label>
                                        <div class="mt-1">
                                            <textarea name="qualifications" id="qualifications" rows="5" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm"
                                                placeholder="List the required qualifications, skills, certifications, and experience..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Requirements -->
                            <div class="pt-8">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-lg bg-green-50 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Requirements</h3>
                                        <p class="mt-1 text-sm text-gray-500">Set the minimum requirements for candidates.</p>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                    <div>
                                        <label for="educational_level" class="block text-sm font-medium text-gray-700">Educational Level</label>
                                        <div class="mt-1">
                                            <select name="educational_level" id="educational_level" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                                <option value="">Select Education Level</option>
                                                <option value="High School">High School</option>
                                                <option value="Associate">Associate Degree</option>
                                                <option value="Bachelor">Bachelor's Degree</option>
                                                <option value="Master">Master's Degree</option>
                                                <option value="Doctorate">Doctorate</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="work_experience_level" class="block text-sm font-medium text-gray-700">Experience Level</label>
                                        <div class="mt-1">
                                            <select name="work_experience_level" id="work_experience_level" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                                <option value="">Select Experience Level</option>
                                                <option value="Entry-Level">Entry Level (0-2 years)</option>
                                                <option value="Mid-Level">Mid Level (3-5 years)</option>
                                                <option value="Senior-Level">Senior Level (5+ years)</option>
                                                <option value="Executive">Executive (10+ years)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Details -->
                            <div class="pt-8">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-lg bg-yellow-50 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Employment Details</h3>
                                        <p class="mt-1 text-sm text-gray-500">Specify the terms of employment.</p>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                                    <div>
                                        <label for="type" class="block text-sm font-medium text-gray-700">Employment Type</label>
                                        <div class="mt-1">
                                            <select name="type" id="type" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                                <option value="">Select Type</option>
                                                <option value="Full-time">Full-time</option>
                                                <option value="Part-time">Part-time</option>
                                                <option value="Contract">Contract</option>
                                                <option value="Temporary">Temporary</option>
                                                <option value="Internship">Internship</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="shift" class="block text-sm font-medium text-gray-700">Work Shift</label>
                                        <div class="mt-1">
                                            <select name="shift" id="shift" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                                <option value="">Select Shift</option>
                                                <option value="Day shift">Day Shift</option>
                                                <option value="Night shift">Night Shift</option>
                                                <option value="Rotating shift">Rotating Shift</option>
                                                <option value="Flexible">Flexible Hours</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="work_setup" class="block text-sm font-medium text-gray-700">Work Setup</label>
                                        <div class="mt-1">
                                            <select name="work_setup" id="work_setup" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                                <option value="">Select Setup</option>
                                                <option value="On-Site">On-Site</option>
                                                <option value="Remote">Remote</option>
                                                <option value="Hybrid">Hybrid</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="pt-8">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-lg bg-pink-50 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-pink-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Additional Information</h3>
                                        <p class="mt-1 text-sm text-gray-500">Complete the remaining details about the position.</p>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                    <div>
                                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                        <div class="mt-1">
                                            <input type="text" name="location" id="location" required placeholder="e.g. Manila, Philippines"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm placeholder-gray-400">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="salary" class="block text-sm font-medium text-gray-700">Monthly Salary Range</label>
                                        <div class="mt-1 relative rounded-lg shadow-sm">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <span class="text-gray-500 sm:text-sm">₱</span>
                                            </div>
                                            <input type="number" name="salary" id="salary" step="1000" min="0"
                                                class="block w-full rounded-lg border-gray-300 pl-7 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm"
                                                placeholder="e.g. 50000">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <span class="text-gray-500 sm:text-sm">/month</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="starting_date" class="block text-sm font-medium text-gray-700">Starting Date</label>
                                        <div class="mt-1">
                                            <input type="date" name="starting_date" id="starting_date"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">When should the candidate start working?</p>
                                    </div>

                                    <div>
                                        <label for="expiration_date" class="block text-sm font-medium text-gray-700">Application Deadline</label>
                                        <div class="mt-1">
                                            <input type="date" name="expiration_date" id="expiration_date"
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">When should the job posting expire?</p>
                                    </div>

                                    <div>
                                        <label for="vacancies" class="block text-sm font-medium text-gray-700">Number of Vacancies</label>
                                        <div class="mt-1">
                                            <input type="number" name="vacancies" id="vacancies" min="1" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm"
                                                placeholder="e.g. 2">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="tags" class="block text-sm font-medium text-gray-700">Job Status</label>
                                        <div class="mt-1">
                                            <select name="tags" id="tags" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                                <option value="">Select Status</option>
                                                <option value="Urgent">Urgent Hiring</option>
                                                <option value="Featured">Featured</option>
                                                <option value="Regular">Regular</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form actions -->
                    <div class="px-6 py-4 bg-gray-50 flex items-center justify-end space-x-3">
                        <a href="{{ route('employer.JobPost') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                            <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Post Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
