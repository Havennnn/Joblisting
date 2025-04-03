@extends('layouts.employer')

@section('title', 'Job Management')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">Job Management</h1>
                <a href="{{ route('employer.JobPost.create') }}" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Post New Job
                </a>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Welcome card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-8">
            <div class="p-6 sm:p-8">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h2>
                        <p class="mt-1 text-sm text-gray-600">Manage your job listings and track applicants from one central dashboard.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session()->has('success'))
        <div class="rounded-lg bg-green-50 p-4 mb-8">
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
        <div class="bg-white shadow-sm rounded-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-3 py-2">
                <h3 class="text-sm font-medium text-gray-900">Your Job Listings</h3>
            </div>
            
            @if(count($JobPosts) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Applicants</th>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unread</th>
                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($JobPosts as $JobPost)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $JobPost->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $JobPost->industry }}</div>
                                </div>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                @if($JobPost->tags == 'Urgent')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Urgent
                                    </span>
                                @elseif($JobPost->tags == 'Featured')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Featured
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        Regular
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500">
                                {{ $JobPost->applicants_count ?? 0 }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500">
                                {{ $JobPost->unread_count ?? 0 }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-xs font-medium space-x-2">
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
            <div class="text-center py-4">
                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-1 text-sm font-medium text-gray-900">No job posts yet</h3>
                <p class="text-xs text-gray-500">Get started by creating a new job post.</p>
            </div>
            @endif
        </div>
    </main>
</div>
@endsection

