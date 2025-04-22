@extends('layouts.employer')

@section('title', 'Employer Dashboard')

@section('content')
<div class="flex">
    <x-employer.sidebar />

    <div class="flex-1 bg-gray-50">
        <x-employer.dashboard.header
            :company-name="$companyName ?? Auth::user()->name"
            :current-date-range="$dateRange ?? [date('M d'), date('M d', strtotime('+7 days'))]"
        />

        <div class="px-12 py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-employer.dashboard.stat-card
                    type="jobs"
                    :count="$activeJobs ?? 0"
                    label="Active job listings"
                    color="bg-emerald-500"
                />

                <x-employer.dashboard.stat-card
                    type="applications"
                    :count="$applicationStats['totalApplications'] ?? 0"
                    label="Total applications"
                    color="bg-indigo-600"
                />

                <x-employer.dashboard.stat-card
                    type="new"
                    :count="$applicationStats['newApplications'] ?? 0"
                    label="New applications today"
                    color="bg-blue-500"
                />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2">
                    <x-employer.dashboard.job-statistics
                        :date-range="$dateRange ?? [date('M d'), date('M d', strtotime('+7 days'))]"
                        :job-stats="$jobStats ?? [
                            'jobViews' => ['total' => 0, 'percentageChange' => 0, 'trend' => 'up'],
                            'applications' => ['total' => 0, 'percentageChange' => 0, 'trend' => 'up']
                        ]"
                    />
                </div>

                <div class="lg:col-span-1">
                    <x-employer.dashboard.application-summary
                        :application-stats="$applicationStats ?? [
                            'activeJobs' => 0,
                            'totalApplications' => 0,
                            'pendingApplications' => 0,
                            'reviewingApplications' => 0,
                            'acceptedApplications' => 0,
                            'rejectedApplications' => 0,
                            'newApplications' => 0,
                            'pendingPercentage' => 0,
                            'reviewingPercentage' => 0,
                            'acceptedPercentage' => 0,
                            'rejectedPercentage' => 0
                        ]"
                    />
                </div>
            </div>

            <div class="bg-white shadow-sm p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Recent Applications</h2>
                    <a href="{{ route('employer.applications.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center text-sm font-medium">
                        <span>View All</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 ml-1">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="py-4 px-3 text-left font-medium text-gray-500 w-2/5">Applicant</th>
                                <th class="py-4 px-3 text-left font-medium text-gray-500">Position</th>
                                <th class="py-4 px-3 text-center font-medium text-gray-500">Applied</th>
                                <th class="py-4 px-3 text-center font-medium text-gray-500">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentApplications) && count($recentApplications) > 0)
                                @foreach($recentApplications as $application)
                                <tr class="border-b">
                                    <td class="py-4 px-3">
                                        <div class="flex items-center">
                                            <div class="bg-indigo-600 text-white p-2 rounded-full mr-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">{{ $application->applicant->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $application->applicant->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-3">
                                        <p class="font-medium">{{ $application->job->title }}</p>
                                    </td>
                                    <td class="py-4 px-3 text-center">
                                        <p class="text-sm text-gray-500">{{ $application->created_at->format('M d, Y') }}</p>
                                    </td>
                                    <td class="py-4 px-3 text-center">
                                        <div class="px-3 py-1 rounded-full inline-block font-medium
                                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                            ($application->status === 'reviewing' ? 'bg-indigo-100 text-indigo-800' :
                                            ($application->status === 'accepted' ? 'bg-green-100 text-green-800' :
                                            'bg-red-100 text-red-600')) }}">
                                            {{ ucfirst($application->status) }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-500">
                                        No applications received yet.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
