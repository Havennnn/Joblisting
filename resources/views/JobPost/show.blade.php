@extends('layouts.employer')

@section('title', 'Job Details')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Dashboard header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Job Details</h1>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Welcome card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="mt-1 text-sm text-gray-600">View and manage your job posting details.</p>
            </div>
        </div>

        <!-- Job details card -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
            <!-- Job header -->
            <div class="px-6 py-8 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $JobPost->title }}</h2>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $JobPost->industry }} | {{ $JobPost->role }}
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            {{ $JobPost->tags }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Job content -->
            <div class="px-6 py-6 grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Main content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Job Description</h3>
                        <div class="mt-2 text-sm text-gray-600 space-y-4">
                            {{ $JobPost->job_description }}
                        </div>
                    </div>

                    <!-- Qualifications -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Qualifications</h3>
                        <div class="mt-2 text-sm text-gray-600 space-y-4">
                            {{ $JobPost->qualifications }}
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="space-y-6">
                        <!-- Job Overview -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Job Overview</h3>
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Location:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->location }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Salary:</dt>
                                    <dd class="text-gray-900">₱{{ number_format($JobPost->salary, 2) }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Employment Type:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->type }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Work Setup:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->work_setup }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Shift:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->shift }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Vacancies:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->vacancies }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Requirements -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Requirements</h3>
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Experience Level:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->work_experience_level }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Education:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->educational_level }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Dates -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Important Dates</h3>
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Start Date:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->starting_date }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Application Deadline:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->expiration_date }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Posted:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->created_at->format('M d, Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500">Last Updated:</dt>
                                    <dd class="text-gray-900">{{ $JobPost->updated_at->format('M d, Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('employer.JobPost') }}" 
                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Back to List
                    </a>
                    <a href="{{ route('employer.JobPost.edit', $JobPost->id) }}" 
                        class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-yellow-600 shadow-sm ring-1 ring-inset ring-yellow-300 hover:bg-yellow-50">
                        Edit Job
                    </a>
                    <form action="{{ route('employer.JobPost.destroy', $JobPost->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this job post?')"
                            class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-red-600 shadow-sm ring-1 ring-inset ring-red-300 hover:bg-red-50">
                            Delete Job
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
