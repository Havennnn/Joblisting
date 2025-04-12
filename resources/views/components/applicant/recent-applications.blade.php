@props(['applications' => []])

<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">My Applications</h2>
        <a href="{{ route('applicant.applications.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all applications</a>
    </div>

    @if(count($applications) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jobs</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Applied</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($applications as $application)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900">{{ $application->job->title }}</span>
                                    <span class="text-sm text-gray-500">{{ $application->job->employer->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $application->applied_at ? $application->applied_at->format('M d, Y') : $application->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-blue-100 text-blue-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'interview' => 'bg-purple-100 text-purple-800',
                                        'hired' => 'bg-green-100 text-green-800',
                                        'default' => 'bg-gray-100 text-gray-800'
                                    ];

                                    $status = strtolower($application->status);
                                    $statusClass = $statusClasses[$status] ?? $statusClasses['default'];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($applications instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">
            {{ $applications->links('components.applicant.pagination', ['paginator' => $applications]) }}
        </div>
        @endif
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
            <p class="mt-1 text-sm text-gray-500">Start applying for jobs to see them here.</p>
            <div class="mt-6">
                <a href="{{ route('applicant.jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    View Jobs
                </a>
            </div>
        </div>
    @endif
</div>
