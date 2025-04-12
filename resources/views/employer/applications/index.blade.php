@extends('layouts.employer')

@section('title', 'Manage Applications')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <x-employer.sidebar />

    <!-- Main Content -->
    <div class="flex-1 bg-gray-50">
        <div class="py-8 px-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Applications</h1>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Profile Completion Alert -->
            @if(isset($completionPercentage) && $completionPercentage < 100)
                <div class="mb-6 bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-400">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-yellow-800">Complete your profile</h3>
                            <div class="mt-1 text-sm text-yellow-700">
                                Your company profile is {{ $completionPercentage }}% complete. Completing your profile helps attract more applicants.
                            </div>
                        </div>
                        <a href="{{ route('employer.profile.edit') }}" class="rounded-md bg-yellow-100 px-3 py-1.5 text-sm font-semibold text-yellow-800 hover:bg-yellow-200">
                            Complete Now
                        </a>
                    </div>
                    <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $completionPercentage }}%"></div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    @if(count($applications) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="border-b">
                                        <th class="py-4 px-3 text-left font-medium text-gray-500">Applicant</th>
                                        <th class="py-4 px-3 text-left font-medium text-gray-500">Job</th>
                                        <th class="py-4 px-3 text-left font-medium text-gray-500">Applied Date</th>
                                        <th class="py-4 px-3 text-center font-medium text-gray-500">Status</th>
                                        <th class="py-4 px-3 text-left font-medium text-gray-500">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr class="border-b {{ $application->viewed_at ? '' : 'bg-blue-50' }}">
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
                                                <p class="text-sm text-gray-500">{{ $application->job->location }}</p>
                                            </td>
                                            <td class="py-4 px-3">
                                                <p class="font-medium">{{ $application->applied_at->format('M d, Y') }}</p>
                                                <p class="text-sm text-gray-500">{{ $application->applied_at->format('h:i A') }}</p>
                                            </td>
                                            <td class="py-4 px-3 text-center">
                                                <div class="px-3 py-1 rounded-full inline-block font-medium
                                                    {{ $application->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                      ($application->status === 'reviewing' ? 'bg-blue-100 text-blue-800' :
                                                      ($application->status === 'accepted' ? 'bg-green-100 text-green-800' :
                                                      'bg-red-100 text-red-800')) }}">
                                                    {{ ucfirst($application->status) }}
                                                </div>
                                                @if(!$application->viewed_at)
                                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        New
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-3 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('employer.applications.show', $application->id) }}"
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-center">
                            {{ $applications->links() }}
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1M19 20a2 2 0 002-2V8a2 2 0 00-2-2h-5M9 12h3m-3 4h9"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                You haven't received any job applications yet.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
