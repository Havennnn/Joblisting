@extends('layouts.employer')

@section('title', 'Employer Dashboard')

@section('content')
<div class="bg-gray-100">
    <!-- Dashboard header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Employer Dashboard</h1>
        </div>
    </header>

    <!-- Main content -->
    <main class="pt-6 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome section -->
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Welcome back, {{ auth()->user()->name }}!</h2>
                        <p class="mt-1 text-sm text-gray-500">Manage your company profile, job listings and applicants here.</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="mt-8">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Active Jobs -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Active Job Listings
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    0
                                </dd>
                                <dd class="mt-3">
                                    <span class="text-sm text-blue-600 hover:text-blue-500">
                                        <a href="#" class="flex items-center">
                                            Manage job listings
                                            <svg class="ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <!-- Profile completion -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Company Profile Completion
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    {{ $profileCompletionPercentage }}%
                                </dd>
                                <dd class="mt-2">
                                    <div class="relative pt-1">
                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                            <div style="width: {{ $profileCompletionPercentage }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $profileCompletionColor }}"></div>
                                        </div>
                                    </div>
                                </dd>
                                <dd class="mt-1 text-sm text-gray-600">
                                    {{ $profileCompletionMessage }}
                                </dd>
                                <dd class="mt-3">
                                    <span class="text-sm text-blue-600 hover:text-blue-500">
                                        <a href="{{ $profileActionLink }}" class="flex items-center">
                                            {{ $profileCompletionPercentage < 100 ? 'Complete your company profile' : 'View your company profile' }}
                                            <svg class="ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <!-- Applicants -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Applicants
                                </dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                    0
                                </dd>
                                <dd class="mt-3">
                                    <span class="text-sm text-blue-600 hover:text-blue-500">
                                        <a href="#" class="flex items-center">
                                            View all applicants
                                            <svg class="ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="mt-8">
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Recent Applications
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Applicants who have recently applied to your job listings
                        </p>
                    </div>
                    <div class="bg-white px-4 py-5 sm:p-6">
                        <p class="text-center text-gray-500 py-8">No recent applications yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
