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
        </div>
    </div>
</div>
@endsection
