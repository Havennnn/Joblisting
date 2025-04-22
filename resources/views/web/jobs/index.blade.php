@extends('layouts.app')

@section('title', 'Find Jobs - NextJob')

@section('content')
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 min-h-screen">
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 py-16">
        <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold text-white mb-4">Find Your Next Career Opportunity</h1>
                <p class="text-xl text-white/90 max-w-2xl">Discover job listings tailored to your skills and experience</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        <div class="max-w-4xl mx-auto">
            <x-job-search.search-bar :route="'jobs.search'" />
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-72 md:flex-shrink-0" x-data="{ open: false }">
                <div class="md:hidden flex justify-between items-center bg-white shadow-sm p-4 mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                    <button @click="open = !open" class="bg-gray-100 p-2 hover:bg-gray-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" x-bind:class="open ? 'rotate-180 transform' : ''" />
                        </svg>
                    </button>
                </div>

                <div class="bg-white shadow-sm overflow-hidden transition-all duration-300 mb-6"
                     :class="{'max-h-0 md:max-h-full': !open, 'max-h-[1000px]': open, 'mb-0': !open && window.innerWidth < 768}">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-6 hidden md:block">Filters</h2>

                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-3">Location</h3>
                            <div class="space-y-2.5">
                                <div class="flex items-center">
                                    <input id="makati" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="makati" class="ml-2 text-sm text-gray-700">Makati</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="pasig" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="pasig" class="ml-2 text-sm text-gray-700">Pasig</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="quezon" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="quezon" class="ml-2 text-sm text-gray-700">Quezon City</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="manila" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="manila" class="ml-2 text-sm text-gray-700">Manila</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="taguig" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="taguig" class="ml-2 text-sm text-gray-700">Taguig</label>
                                </div>
                            </div>
                            <button class="text-blue-600 text-sm mt-3 hover:text-blue-800 font-medium flex items-center">
                                Show More
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-3">Job Type</h3>
                            <div class="space-y-2.5">
                                <div class="flex items-center">
                                    <input id="full-time" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="full-time" class="ml-2 text-sm text-gray-700">Full Time</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="part-time" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="part-time" class="ml-2 text-sm text-gray-700">Part Time</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="contract" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="contract" class="ml-2 text-sm text-gray-700">Contract</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="internship" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="internship" class="ml-2 text-sm text-gray-700">Internship</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-3">Specialization</h3>
                            <div class="space-y-2.5">
                                <div class="flex items-center">
                                    <input id="call-center" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="call-center" class="ml-2 text-sm text-gray-700">Call Center & Customer Service</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="accounting" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="accounting" class="ml-2 text-sm text-gray-700">Accounting</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="info-comm" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="info-comm" class="ml-2 text-sm text-gray-700">Information & Communication</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="sales" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="sales" class="ml-2 text-sm text-gray-700">Sales</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="engineering" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="engineering" class="ml-2 text-sm text-gray-700">Engineering</label>
                                </div>
                            </div>
                            <button class="text-blue-600 text-sm mt-3 hover:text-blue-800 font-medium flex items-center">
                                Show More
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-md font-medium text-gray-900 mb-3">Experience Level</h3>
                            <div class="space-y-2.5">
                                <div class="flex items-center">
                                    <input id="entry-level" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="entry-level" class="ml-2 text-sm text-gray-700">Entry Level</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="mid-level" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="mid-level" class="ml-2 text-sm text-gray-700">Mid Level</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="senior-level" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="senior-level" class="ml-2 text-sm text-gray-700">Senior Level</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="manager" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="manager" class="ml-2 text-sm text-gray-700">Manager</label>
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-3">
                            <button class="flex-1 py-2.5 px-4 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Reset
                            </button>
                            <button class="flex-1 py-2.5 px-4 bg-[#2563EB] border border-transparent text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-md">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-grow">
                <div class="bg-white shadow-sm p-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Browse Jobs</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} Jobs
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-600">Sort by:</span>
                            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 p-2.5 pr-8 appearance-none cursor-pointer">
                                <option>Most Relevant</option>
                                <option>Newest</option>
                                <option>Salary: High to Low</option>
                                <option>Salary: Low to High</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    @forelse($jobs as $job)
                        <div class="bg-white shadow-sm hover:shadow-md transition-shadow overflow-hidden border-l-4 border-blue-600">
                            <div class="p-6">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($job->employer && $job->employer->company_logo_path)
                                                <img src="{{ asset('storage/' . $job->employer->company_logo_path) }}" alt="Company Logo" class="h-14 w-14 object-cover border border-gray-200">
                                            @else
                                                <div class="h-14 w-14 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                                <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a>
                                            </h3>
                                            <p class="text-gray-700 text-sm mt-1">{{ $job->employer->company_name ?? 'Company' }}</p>

                                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                <div class="flex items-center text-gray-500 text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    </svg>
                                                    {{ $job->location }}
                                                </div>
                                                <div class="flex items-center text-gray-500 text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    ₱{{ number_format($job->salary, 0) }}
                                                </div>
                                                <div class="flex items-center text-gray-500 text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $job->work_experience_level }} Experience
                                                </div>
                                                <div class="flex items-center text-gray-500 text-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $job->type }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-row sm:flex-col justify-between sm:items-end sm:text-right">
                                        <span class="text-sm text-gray-500">{{ $job->created_at->format('M d, Y') }}</span>
                                        <span class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $job->tags == 'Urgent' ? 'bg-red-100 text-red-800' : ($job->tags == 'Featured' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $job->tags ?? 'New' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex justify-end">
                                <a href="{{ route('jobs.show', $job->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white shadow-sm p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No jobs found</h3>
                            <p class="mt-2 text-sm text-gray-500">No job listings are available at the moment. Please check back later or refine your search criteria.</p>
                            <div class="mt-6">
                                <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Clear Filters
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    <x-applicant.pagination :paginator="$jobs" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
