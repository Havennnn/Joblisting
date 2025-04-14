@props(['applications'])

<div class="bg-white rounded-lg shadow-sm p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">My Applications</h2>
        <a href="{{ route('applicant.applications') }}" class="text-blue-600 hover:text-blue-800">View All</a>
    </div>

    <!-- Applications Table -->
    <div class="overflow-x-auto">
        @if(count($applications) > 0)
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="py-4 px-3 text-left font-medium text-gray-500 w-2/5">Jobs</th>
                        <th class="py-4 px-3 text-center font-medium text-gray-500">Applied</th>
                        <th class="py-4 px-3 text-center font-medium text-gray-500">Interview</th>
                        <th class="py-4 px-3 text-center font-medium text-gray-500">Hired</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                        <tr class="border-b">
                            <td class="py-4 px-3">
                                <div class="flex items-center">
                                    <div class="bg-red-600 text-white p-2 rounded-full mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $application->job->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $application->applied_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-3 text-center">
                                <div class="flex justify-center">
                                    <div class="bg-green-500 rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-3 text-center">
                                @if($application->status === 'reviewing' || $application->status === 'accepted')
                                <div class="flex justify-center">
                                    <div class="bg-green-500 rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                @else
                                <div class="flex justify-center">
                                    <div class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full inline-block font-medium">
                                        Waiting
                                    </div>
                                </div>
                                @endif
                            </td>
                            <td class="py-4 px-3 text-center">
                                @if($application->status === 'accepted')
                                <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full inline-block font-medium">
                                    Hired
                                </div>
                                @elseif($application->status === 'rejected')
                                <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full inline-block font-medium">
                                    Rejected
                                </div>
                                @else
                                <div class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full inline-block font-medium">
                                    Waiting
                                </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-10">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by applying to your first job.</p>
                <div class="mt-6">
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#2271b1] hover:bg-[#135e96] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2271b1]">
                        Browse Jobs
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
