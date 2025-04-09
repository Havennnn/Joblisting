@extends('layouts.landing')

@section('title', 'Browse Jobs - NeksJob')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Browse Available Jobs</h1>
        <p class="mt-2 text-lg text-gray-600">Find the perfect job opportunity that matches your skills and career goals.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jobs as $job)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $job->title }}</h2>
                    <p class="text-sm text-gray-600 mb-3">{{ $job->employer->company_name ?? 'Company' }}</p>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $job->location }}
                    </div>

                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $job->type }}</span>
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $job->work_setup }}</span>
                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $job->industry }}</span>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-1">Job Description</h3>
                        <p class="text-sm text-gray-600 line-clamp-3">{{ $job->job_description }}</p>
                    </div>

                    @if($job->salary > 0)
                    <div class="text-sm font-medium text-gray-900 mb-4">
                        ${{ number_format($job->salary, 2) }} per year
                    </div>
                    @endif

                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs text-gray-500">Posted: {{ $job->created_at->diffForHumans() }}</span>
                        <a href="{{ route('jobs.show', $job->id) }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                            View Details
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">No job listings available at the moment. Please check back later.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
