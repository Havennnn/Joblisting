@extends('layouts.employer')

@section('title', 'Job Details')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <x-employer.sidebar />

    <!-- Main Content -->
    <div class="flex-1 bg-gray-50">
        <div class="py-8 px-12">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Job Details</h1>
                <a href="{{ route('employer.JobPost') }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-900">
                    <svg class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Jobs
                </a>
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
                        <!-- Company Information -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mr-4">
                                    @if($JobPost->employer->company_logo_path)
                                        <img src="{{ asset('storage/' . $JobPost->employer->company_logo_path) }}" alt="Company Logo" class="h-16 w-16 rounded-lg object-cover">
                                    @else
                                        <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M3 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $JobPost->employer->company_name }}</h3>
                                    <p class="mt-1 text-sm text-gray-600">{{ $JobPost->employer->industry }}</p>
                                    <p class="mt-1 text-sm text-gray-600">{{ $JobPost->employer->location }}</p>
                                    @if($JobPost->employer->website)
                                        <a href="{{ $JobPost->employer->website }}" target="_blank" class="mt-2 text-sm text-blue-600 hover:text-blue-800 inline-flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd" />
                                            </svg>
                                            Visit Website
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Job Description</h3>
                            <div class="mt-2 text-sm text-gray-600 space-y-4">
                                {{ $JobPost->job_description }}
                            </div>
                        </div>

                        <!-- Applications Received -->
                        @if(isset($JobPost->applications) && count($JobPost->applications) > 0)
                        <div class="mt-8 bg-gray-50 rounded-lg p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Applications Received</h3>
                                <a href="{{ route('employer.applications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                    View All Applications
                                </a>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Applicant
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Applied Date
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($JobPost->applications as $application)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $application->applicant->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $application->applicant->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $application->applied_at->format('M d, Y') }}</div>
                                                    <div class="text-sm text-gray-500">{{ $application->applied_at->format('h:i A') }}</div>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                          ($application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' :
                                                          ($application->status === 'accepted' ? 'bg-green-100 text-green-800' :
                                                          'bg-red-100 text-red-800')) }}">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('employer.applications.show', $application->id) }}"
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
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
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Post Information</h3>
                                <dl class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Posted:</dt>
                                        <dd class="text-gray-900">{{ $JobPost->created_at->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Last Updated:</dt>
                                        <dd class="text-gray-900">{{ $JobPost->updated_at->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Auto-Delete On:</dt>
                                        <dd class="text-gray-900">{{ \Carbon\Carbon::parse($JobPost->auto_delete_at)->format('M d, Y') }}</dd>
                                    </div>
                                </dl>
                                <div class="mt-4 bg-yellow-50 p-3 rounded-md">
                                    <p class="text-xs text-yellow-700">
                                        <span class="font-medium">Note:</span> This job post will be automatically removed after 7 days from creation or last update.
                                    </p>
                                </div>
                            </div>

                            <!-- Applications Stats -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Application Stats</h3>
                                <dl class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Total Applications:</dt>
                                        <dd class="text-gray-900 font-medium">{{ isset($JobPost->applications) ? $JobPost->applications->count() : 0 }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">New Applications:</dt>
                                        <dd class="text-gray-900">
                                            {{ isset($JobPost->applications) ? $JobPost->applications->where('status', 'pending')->count() : 0 }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Under Review:</dt>
                                        <dd class="text-gray-900">
                                            {{ isset($JobPost->applications) ? $JobPost->applications->where('status', 'reviewing')->count() : 0 }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Accepted:</dt>
                                        <dd class="text-green-600 font-medium">
                                            {{ isset($JobPost->applications) ? $JobPost->applications->where('status', 'accepted')->count() : 0 }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-500">Rejected:</dt>
                                        <dd class="text-red-600 font-medium">
                                            {{ isset($JobPost->applications) ? $JobPost->applications->where('status', 'rejected')->count() : 0 }}
                                        </dd>
                                    </div>
                                    @if(isset($JobPost->applications) && $JobPost->applications->count() > 0)
                                    <div class="mt-4 pt-3 border-t border-gray-200">
                                        <a href="{{ route('employer.applications.job', ['jobId' => $JobPost->id]) }}" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-blue-700 bg-blue-100 border border-transparent rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            View All Applications
                                        </a>
                                    </div>
                                    @endif
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
        </div>
    </div>
</div>
@endsection
