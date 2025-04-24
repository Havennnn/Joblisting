@extends('layouts.employer')

@section('title', 'Job Management')

@section('content')

    <div class="flex">
        <!-- Sidebar -->
        <x-employer.sidebar />

        <!-- Main Content -->
        <div class="flex-1 bg-gray-50">
            <div class="shadow-sm py-8 px-12">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Job Management</h1>
                    @if(($completionPercentage ?? 0) >= 70)
                    <a href="{{ route('employer.JobPost.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue transition-colors duration-150">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Post New Job
                    </a>
                    @else
                    <button disabled
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium text-white bg-gray-400 cursor-not-allowed">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Post New Job
                    </button>
                    @endif
                </div>

                <!-- Profile Completion Alert -->
                <x-profile-completion-alert :percentage="$completionPercentage ?? 0" userType="employer" />

                <!-- Job Listings Table -->
                <div class="bg-white border border-gray-200 shadow-sm">
                    <div class="border-b border-gray-200 p-4">
                        <h3 class="text-lg font-medium text-gray-900">Your Job Listings</h3>
                    </div>

                    <div id="job-posts-container">
                        @include('employer.job-posts.partials.job-list', ['JobPosts' => $JobPosts])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @vite(['resources/js/pages/employerJobPosts.js'])
@endpush

