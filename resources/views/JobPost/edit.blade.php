@extends('layouts.employer')

@section('title', 'Edit Job Post')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">Edit Job Post</h1>
                <a href="{{ route('employer.JobPost') }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900">
                    <svg class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Jobs
                </a>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Status card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-8">
            <div class="p-6 sm:p-8">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-full bg-amber-50 flex items-center justify-center">
                            <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Edit Job: {{ $JobPost->title }}</h2>
                        <p class="mt-1 text-sm text-gray-600">Update the job posting details to better match your requirements.</p>
                    </div>
                    </div>
                </div>
            </div>

        <!-- Form card -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <form action="{{ route('employer.JobPost.update', $JobPost->id) }}" method="POST" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')

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
                                    <p class="mt-1 text-sm text-gray-500">Update the fundamental details of the position.</p>
                    </div>
                </div>

                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                                    <div class="mt-1">
                                        <input type="text" name="title" id="title" required value="{{ $JobPost->title }}"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                    </div>
                    </div>

                                <div>
                                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                                    <div class="mt-1">
                                        <select name="industry" id="industry" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                            <option value="">Select Industry</option>
                                            <option value="Technology and IT" {{ $JobPost->industry == 'Technology and IT' ? 'selected' : '' }}>Technology and IT</option>
                                            <option value="Healthcare" {{ $JobPost->industry == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                            <option value="Finance" {{ $JobPost->industry == 'Finance' ? 'selected' : '' }}>Finance</option>
                                            <option value="Education" {{ $JobPost->industry == 'Education' ? 'selected' : '' }}>Education</option>
                                            <option value="Manufacturing" {{ $JobPost->industry == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                        </select>
                    </div>
                </div>

                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                    <div class="mt-1">
                                        <select name="role" id="role" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                            <option value="">Select Role</option>
                                            <option value="Software Developer/Engineer" {{ $JobPost->role == 'Software Developer/Engineer' ? 'selected' : '' }}>Software Developer/Engineer</option>
                                            <option value="Product Manager" {{ $JobPost->role == 'Product Manager' ? 'selected' : '' }}>Product Manager</option>
                                            <option value="Data Scientist" {{ $JobPost->role == 'Data Scientist' ? 'selected' : '' }}>Data Scientist</option>
                                            <option value="UX Designer" {{ $JobPost->role == 'UX Designer' ? 'selected' : '' }}>UX Designer</option>
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
                                    <p class="mt-1 text-sm text-gray-500">Update the description and requirements.</p>
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
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">{{ $JobPost->job_description }}</textarea>
                                    </div>
                    </div>

                                <div>
                                    <label for="qualifications" class="block text-sm font-medium text-gray-700">
                                        Qualifications
                                        <span class="text-sm text-gray-500">(List required skills and experience)</span>
                                    </label>
                                    <div class="mt-1">
                                        <textarea name="qualifications" id="qualifications" rows="5" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">{{ $JobPost->qualifications }}</textarea>
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
                                    <p class="mt-1 text-sm text-gray-500">Update the minimum requirements for candidates.</p>
                                </div>
                    </div>

                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label for="educational_level" class="block text-sm font-medium text-gray-700">Educational Level</label>
                                    <div class="mt-1">
                                        <select name="educational_level" id="educational_level" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                            <option value="">Select Education Level</option>
                                            <option value="High School" {{ $JobPost->educational_level == 'High School' ? 'selected' : '' }}>High School</option>
                                            <option value="Associate" {{ $JobPost->educational_level == 'Associate' ? 'selected' : '' }}>Associate Degree</option>
                                            <option value="Bachelor" {{ $JobPost->educational_level == 'Bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                            <option value="Master" {{ $JobPost->educational_level == 'Master' ? 'selected' : '' }}>Master's Degree</option>
                                            <option value="Doctorate" {{ $JobPost->educational_level == 'Doctorate' ? 'selected' : '' }}>Doctorate</option>
                        </select>
                    </div>
                </div>

                                <div>
                                    <label for="work_experience_level" class="block text-sm font-medium text-gray-700">Experience Level</label>
                                    <div class="mt-1">
                                        <select name="work_experience_level" id="work_experience_level" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                            <option value="">Select Experience Level</option>
                                            <option value="Entry-Level" {{ $JobPost->work_experience_level == 'Entry-Level' ? 'selected' : '' }}>Entry Level (0-2 years)</option>
                                            <option value="Mid-Level" {{ $JobPost->work_experience_level == 'Mid-Level' ? 'selected' : '' }}>Mid Level (3-5 years)</option>
                                            <option value="Senior-Level" {{ $JobPost->work_experience_level == 'Senior-Level' ? 'selected' : '' }}>Senior Level (5+ years)</option>
                                            <option value="Executive" {{ $JobPost->work_experience_level == 'Executive' ? 'selected' : '' }}>Executive (10+ years)</option>
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
                                    <p class="mt-1 text-sm text-gray-500">Update the terms of employment.</p>
                                </div>
                    </div>

                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Employment Type</label>
                                    <div class="mt-1">
                                        <select name="type" id="type" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                            <option value="">Select Type</option>
                                            <option value="Full-time" {{ $JobPost->type == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                            <option value="Part-time" {{ $JobPost->type == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                            <option value="Contract" {{ $JobPost->type == 'Contract' ? 'selected' : '' }}>Contract</option>
                                            <option value="Temporary" {{ $JobPost->type == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                                            <option value="Internship" {{ $JobPost->type == 'Internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                                    </div>
                    </div>

                                <div>
                                    <label for="shift" class="block text-sm font-medium text-gray-700">Work Shift</label>
                                    <div class="mt-1">
                                        <select name="shift" id="shift" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                            <option value="">Select Shift</option>
                                            <option value="Day shift" {{ $JobPost->shift == 'Day shift' ? 'selected' : '' }}>Day Shift</option>
                                            <option value="Night shift" {{ $JobPost->shift == 'Night shift' ? 'selected' : '' }}>Night Shift</option>
                                            <option value="Rotating shift" {{ $JobPost->shift == 'Rotating shift' ? 'selected' : '' }}>Rotating Shift</option>
                                            <option value="Flexible" {{ $JobPost->shift == 'Flexible' ? 'selected' : '' }}>Flexible Hours</option>
                        </select>
                    </div>
                </div>

                                <div>
                                    <label for="work_setup" class="block text-sm font-medium text-gray-700">Work Setup</label>
                                    <div class="mt-1">
                                        <select name="work_setup" id="work_setup" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                            <option value="">Select Setup</option>
                                            <option value="On-Site" {{ $JobPost->work_setup == 'On-Site' ? 'selected' : '' }}>On-Site</option>
                                            <option value="Remote" {{ $JobPost->work_setup == 'Remote' ? 'selected' : '' }}>Remote</option>
                                            <option value="Hybrid" {{ $JobPost->work_setup == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
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
                                    <p class="mt-1 text-sm text-gray-500">Update the remaining details about the position.</p>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                    <div class="mt-1">
                                        <input type="text" name="location" id="location" required value="{{ $JobPost->location }}"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                    </div>
                    </div>

                                <div>
                                    <label for="salary" class="block text-sm font-medium text-gray-700">Monthly Salary Range</label>
                                    <div class="mt-1 relative rounded-lg shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">₱</span>
                                        </div>
                                        <input type="number" name="salary" id="salary" step="1000" min="0" value="{{ $JobPost->salary }}"
                                            class="block w-full rounded-lg border-gray-300 pl-7 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm">/month</span>
                                        </div>
                    </div>
                </div>

                                <div>
                                    <label for="starting_date" class="block text-sm font-medium text-gray-700">Starting Date</label>
                                    <div class="mt-1">
                                        <input type="date" name="starting_date" id="starting_date" value="{{ $JobPost->starting_date }}"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">When should the candidate start working?</p>
                                </div>

                                <div>
                                    <label for="expiration_date" class="block text-sm font-medium text-gray-700">Application Deadline</label>
                                    <div class="mt-1">
                                        <input type="date" name="expiration_date" id="expiration_date" value="{{ $JobPost->expiration_date }}"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">When should the job posting expire?</p>
                                </div>

                                <div>
                                    <label for="vacancies" class="block text-sm font-medium text-gray-700">Number of Vacancies</label>
                                    <div class="mt-1">
                                        <input type="number" name="vacancies" id="vacancies" min="1" required value="{{ $JobPost->vacancies }}"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                    </div>
                    </div>

                                <div>
                                    <label for="tags" class="block text-sm font-medium text-gray-700">Job Status</label>
                                    <div class="mt-1">
                                        <select name="tags" id="tags" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-neksjob-blue focus:ring-neksjob-blue sm:text-sm">
                                            <option value="">Select Status</option>
                                            <option value="Urgent" {{ $JobPost->tags == 'Urgent' ? 'selected' : '' }}>Urgent Hiring</option>
                                            <option value="Featured" {{ $JobPost->tags == 'Featured' ? 'selected' : '' }}>Featured</option>
                                            <option value="Regular" {{ $JobPost->tags == 'Regular' ? 'selected' : '' }}>Regular</option>
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
                        Update Job
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
