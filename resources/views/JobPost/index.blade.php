@extends('layouts.employer')

@section('title', 'Job Management')

@section('content')
    <div class="flex">
        <!-- Sidebar -->
        <x-employer.sidebar />

        <!-- Main Content -->
        <div class="flex-1 bg-gray-50">
            <div class="rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Job Management</h1>
                    @if($completionPercentage >= 70)
                    <a href="{{ route('employer.JobPost.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Post New Job
                    </a>
                    @else
                    <button disabled
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-400 cursor-not-allowed">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Post New Job
                    </button>
                    @endif
                </div>

                <!-- Profile Completion Alert -->
                @if($completionPercentage < 100)
                <div class="bg-gray-50 rounded-lg border border-gray-200 mb-6 p-4">
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Profile Completion Status</h2>

                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ $completionPercentage }}% Complete</span>
                            <a href="{{ route('employer.profile.edit') }}" class="text-sm text-neksjob-blue hover:underline">Complete Profile</a>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-neksjob-blue h-2.5 rounded-full" style="width: {{ $completionPercentage }}%"></div>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600">
                        @if($completionPercentage < 70)
                            <span class="text-neksjob-pink font-medium">Your profile requires more information before you can post jobs.</span>
                            A complete profile helps attract better candidates and improves your company's visibility.
                        @else
                            Continue completing your profile to improve your company's visibility and attract better candidates.
                        @endif
                    </p>
                </div>
                @endif

                <!-- Success Message -->
                @if(session()->has('success'))
                <div class="rounded-lg bg-green-50 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Job Listings Table -->
                <div class="bg-white rounded-lg border border-gray-200">
                    <div class="border-b border-gray-200 p-4">
                        <h3 class="text-lg font-medium text-gray-900">Your Job Listings</h3>
                    </div>

                    @if(count($JobPosts) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicants</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unread</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($JobPosts as $JobPost)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $JobPost->title }}</div>
                                            <div class="text-xs text-gray-500">{{ $JobPost->industry }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($JobPost->tags == 'Urgent')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Urgent
                                            </span>
                                        @elseif($JobPost->tags == 'Featured')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Featured
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Regular
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $JobPost->applicants_count ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $JobPost->unread_count ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('employer.JobPost.show', $JobPost->id) }}" class="text-neksjob-blue hover:text-neksjob-blue-dark">View</a>
                                        <a href="{{ route('employer.JobPost.edit', $JobPost->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('employer.JobPost.destroy', $JobPost->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this job post?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @else
                    <div class="text-center py-10">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No job posts yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new job post.</p>
                        <div class="mt-6">
                            @if($completionPercentage >= 70)
                            <a href="{{ route('employer.JobPost.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Post New Job
                            </a>
                            @else
                            <a href="{{ route('employer.profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 6V4c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V8c.55 0 1-.45 1-1s-.45-1-1-1zm-2 2H4V4h6v4zm6 1v7c0 1.1-.9 2-2 2H7c-1.1 0-2-.9-2-2v-3h2v3h7V9h2z" clip-rule="evenodd" />
                                </svg>
                                Complete Profile First
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

