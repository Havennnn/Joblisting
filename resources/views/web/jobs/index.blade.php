@extends('layouts.app')

@section('title', 'Find Jobs - NeksJob')

@section('content')
<div class="bg-gradient-to-r from-blue-50 to-indigo-50">
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 py-12">
        <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-4xl font-bold text-white mb-4">Find Your Next Career Opportunity</h1>
            <p class="text-xl text-white/90 max-w-2xl">Explore job listings tailored for your skills and experience</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-8 relative z-20">
        <div class="max-w-4xl mx-auto">
            <x-job-search.search-bar :route="'jobs.search'" />
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Filters</h2>

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
                        <button class="text-red-600 text-sm mt-2 hover:text-red-700 font-semibold">Show More</button>
                    </div>

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
                        <button class="text-red-600 text-sm mt-2 hover:text-red-700 font-semibold">Show More</button>
                    </div>

                    <div class="flex space-x-2">
                        <button class="flex-1 py-2 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Reset</button>
                        <button class="flex-1 py-2 px-4 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700">Apply</button>
                    </div>
                </div>
            </div>

            <div class="flex-grow">
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Browse Jobs</h2>
                            <p class="text-sm text-gray-500">
                                {{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} Jobs
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Sort by:</span>
                            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2">
                                <option>Most Relevant</option>
                                <option>Newest</option>
                                <option>Salary: High to Low</option>
                                <option>Salary: Low to High</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow border-l-4 border-red-600">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl w-12 h-12 flex items-center justify-center text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900 hover:text-red-600 transition-colors">
                                            <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a>
                                        </h3>
                                        <div class="mt-4 space-y-2">
                                            <div class="flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                                {{ $job->location }}
                                            </div>
                                            <div class="flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                PHP {{ number_format($job->salary, 0) }}
                                            </div>
                                            <div class="flex items-center text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $job->work_experience_level }} Experience
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right flex flex-col items-end">
                                    <span class="text-sm text-gray-500">{{ $job->created_at->format('M d, Y') }}</span>
                                    <span class="mt-2 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $job->tags == 'Urgent' ? 'bg-red-100 text-red-800' : ($job->tags == 'Featured' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $job->tags ?? 'New' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No jobs found</h3>
                            <p class="mt-1 text-sm text-gray-500">No job listings available at the moment. Please check back later.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 flex justify-center">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
