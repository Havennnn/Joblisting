@extends('layouts.app')

@section('title', 'Applicant Dashboard')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <x-applicant.sidebar />

    <!-- Main Content -->
    <div class="flex-1 bg-gray-50">
        <!-- Header with Company and Job Post button -->
        <x-applicant.dashboard.header
            company="Nomad"
            :current-date-range="['Jul 19', 'Jul 25']"
        />

        <!-- Dashboard Stats Cards -->
        <div class="px-12 py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-applicant.dashboard.stat-card
                    type="candidates"
                    count="76"
                    label="New candidates to review"
                    color="bg-indigo-600"
                />

                <x-applicant.dashboard.stat-card
                    type="schedule"
                    count="3"
                    label="Schedule for today"
                    color="bg-emerald-500"
                />

                <x-applicant.dashboard.stat-card
                    type="messages"
                    count="24"
                    label="Messages received"
                    color="bg-blue-500"
                />
            </div>

            <!-- Job Statistics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Job Stats Main Section - Takes 2 columns -->
                <div class="lg:col-span-2">
                    <x-applicant.dashboard.job-statistics
                        :date-range="['Jul 19', 'Jul 25']"
                    />
                </div>

                <!-- Job Summary - Takes 1 column -->
                <div class="lg:col-span-1">
                    <x-applicant.dashboard.job-summary />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
