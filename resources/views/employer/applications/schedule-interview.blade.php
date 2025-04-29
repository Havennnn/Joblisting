@extends('layouts.employer')

@section('title', 'Schedule Interview')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <x-employer.sidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col bg-gray-50">
        <div class="w-full max-w-5xl mx-auto px-4 py-8">
            <div class="mb-6">
                <a href="{{ route('employer.applications.show', $application->id) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Application
                </a>
            </div>

            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Schedule Interview</h1>
                <div class="mb-4">
                    <p class="text-lg">Scheduling interview with <span class="font-medium">{{ $application->applicant->name }}</span> for <span class="font-medium">{{ $application->job->title }}</span></p>
                </div>

                @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('employer.applications.schedule', $application->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="interview_date" class="block text-sm font-medium text-gray-700 mb-1">Interview Date</label>
                            <input type="date" name="interview_date" id="interview_date" min="{{ date('Y-m-d') }}" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" name="location" id="location"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Enter address or meeting place (optional)">
                        </div>

                        <div>
                            <label for="meeting_link" class="block text-sm font-medium text-gray-700 mb-1">Meeting Link</label>
                            <input type="url" name="meeting_link" id="meeting_link"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Enter Zoom, Google Meet, or other video conferencing link (optional)">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('employer.applications.show', $application->id) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Schedule Interview
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
