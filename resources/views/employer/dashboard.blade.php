@extends('layouts.employer')

@section('title', 'Employer Dashboard')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <x-employer.sidebar />

    <!-- Main Content -->
    <div class="flex-1 bg-gray-50">
        <div class="py-8 px-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>
            <p class="text-xl mb-8">Welcome {{ Auth::user()->name ?? 'User' }}</p>

            <!-- Dashboard Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Active Job Posts Card -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-sm font-semibold uppercase">ACTIVE JOB POSTS</h2>
                    </div>
                    <div class="px-4 pb-4 flex items-center">
                        <div class="text-4xl font-bold ml-1 mr-5">{{ $activeJobPosts }}</div>
                        <div>
                            <p class="text-sm mb-1">Currently active job listings</p>
                            <a href="{{ route('employer.JobPost') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all job posts</a>
                        </div>
                    </div>
                </div>

                <!-- Total Applicants Card -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-sm font-semibold uppercase">TOTAL APPLICANTS</h2>
                    </div>
                    <div class="px-4 pb-4 flex items-center">
                        <div class="text-4xl font-bold ml-1 mr-5">{{ $totalApplications ?? 0 }}</div>
                        <div>
                            <p class="text-sm mb-1">Total applications received</p>
                            <a href="{{ route('employer.applications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all applications</a>
                        </div>
                    </div>
                </div>

                <!-- Scheduled Interviews Card -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-sm font-semibold uppercase">SCHEDULED INTERVIEWS</h2>
                    </div>
                    <div class="px-4 pb-4 flex items-center">
                        <div class="text-4xl font-bold ml-1 mr-5">24</div>
                        <div>
                            <p class="text-sm mb-1">Upcoming interviews</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View scheduled interviews</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Applications Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Recent Applications</h2>
                    <a href="{{ route('employer.applications.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>

                <!-- Applications Table -->
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
                                            <div class="bg-red-600 text-white p-2 rounded-full mr-4">
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
                                        <p class="text-sm text-gray-500">{{ $application->applied_at->format('M d, Y') }}</p>
                                    </td>
                                    <td class="py-4 px-3 text-center">
                                        <div class="px-3 py-1 rounded-full inline-block font-medium
                                            {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                               ($application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' :
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
