@extends('layouts.app')

@section('title', 'Find Jobs - NeksJob')

@section('content')
<div class="bg-white">
    <!-- Search Bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-b border-gray-200">
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('jobs.search') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" name="title" placeholder="Job Title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                </div>
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a3 3 0 1 0-3-3c0 1.677 1.345 3 3 3Zm0 0c-5 0-9 3.582-9 8h18c0-4.418-4-8-9-8Z"/>
                        </svg>
                    </div>
                    <input type="text" name="location" placeholder="City" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                </div>
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 2a8 8 0 100 16 8 8 0 000-16z"/>
                        </svg>
                    </div>
                    <input type="text" name="industry" placeholder="Industry" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5">
                </div>
                <button type="submit" class="text-white bg-neksjob-blue hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5">Search</button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="w-full md:w-64 flex-shrink-0">
                <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Filters</h2>

                <!-- Location Filter -->
                <div class="mb-6">
                    <h3 class="text-md font-medium text-gray-900 mb-3">Location</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input id="makati" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="makati" class="ml-2 text-sm font-medium text-gray-700">Makati</label>
                        </div>
                        <div class="flex items-center">
                            <input id="pasig" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="pasig" class="ml-2 text-sm font-medium text-gray-700">Pasig</label>
                        </div>
                        <div class="flex items-center">
                            <input id="quezon" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="quezon" class="ml-2 text-sm font-medium text-gray-700">Quezon</label>
                        </div>
                        <div class="flex items-center">
                            <input id="manila" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="manila" class="ml-2 text-sm font-medium text-gray-700">Manila</label>
                        </div>
                        <div class="flex items-center">
                            <input id="pampanga" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="pampanga" class="ml-2 text-sm font-medium text-gray-700">Pampanga</label>
                        </div>
                        <div class="flex items-center">
                            <input id="davao" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="davao" class="ml-2 text-sm font-medium text-gray-700">Davao</label>
                        </div>
                    </div>
                    <button class="text-neksjob-blue text-sm mt-2">Show More</button>
                </div>

                <!-- Specialization Filter -->
                <div class="mb-6">
                    <h3 class="text-md font-medium text-gray-900 mb-3">Specialization</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input id="call-center" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="call-center" class="ml-2 text-sm font-medium text-gray-700">Call Center & Customer Service Representative</label>
                        </div>
                        <div class="flex items-center">
                            <input id="accounting" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="accounting" class="ml-2 text-sm font-medium text-gray-700">Accounting</label>
                        </div>
                        <div class="flex items-center">
                            <input id="info-comm" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="info-comm" class="ml-2 text-sm font-medium text-gray-700">Information & Communication</label>
                        </div>
                        <div class="flex items-center">
                            <input id="sales" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="sales" class="ml-2 text-sm font-medium text-gray-700">Sales</label>
                        </div>
                        <div class="flex items-center">
                            <input id="engineering" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="engineering" class="ml-2 text-sm font-medium text-gray-700">Engineering</label>
                        </div>
                        <div class="flex items-center">
                            <input id="education" type="checkbox" class="w-4 h-4 text-neksjob-blue bg-gray-100 border-gray-300 rounded">
                            <label for="education" class="ml-2 text-sm font-medium text-gray-700">Education & Training</label>
                        </div>
                    </div>
                    <button class="text-neksjob-blue text-sm mt-2">Show More</button>
                </div>

                <div class="flex space-x-2">
                    <button class="flex-1 py-2 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Reset</button>
                    <button class="flex-1 py-2 px-4 bg-neksjob-blue border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">Apply</button>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="flex-grow">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Browse Jobs</h2>
                    <p class="text-sm text-gray-500">
                        {{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} Jobs
                    </p>
                </div>

                <div class="space-y-6">
                    @forelse($jobs as $job)
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    <div class="bg-neksjob-pink rounded-full w-12 h-12 flex items-center justify-center text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900 hover:text-neksjob-blue">
                                            <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a>
                                        </h3>
                                        <div class="mt-4 space-y-2">
                                            <div class="flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                                {{ $job->location }}
                                            </div>
                                            <div class="flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                PHP {{ number_format($job->salary, 0) }}
                                            </div>
                                            <div class="flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $job->work_experience_level }} Experience
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm text-gray-500">{{ $job->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-gray-200 rounded-lg p-6 text-center">
                            <p class="text-gray-500">No job listings available at the moment. Please check back later.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
