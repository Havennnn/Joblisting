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
            <!-- Filter Sidebar Component -->
            <x-job-search.jobs-filter />

            <div class="flex-grow">
                <!-- Job Listing Header Component -->
                <x-job-search.jobs-header
                    :title="'Browse Jobs'"
                    :startItem="$jobs->firstItem() ?? 0"
                    :endItem="$jobs->lastItem() ?? 0"
                    :total="$jobs->total()"
                />

                <div class="space-y-5">
                    @forelse($jobs as $job)
                        <!-- Job Card Component -->
                        <x-job-search.job-card :job="$job" />
                    @empty
                        <!-- Empty State Component -->
                        <x-job-search.empty-state
                            title="No jobs found"
                            message="No job listings are available at the moment. Please check back later or refine your search criteria."
                            action="Clear Filters"
                            :actionUrl="route('jobs.index')"
                        />
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
