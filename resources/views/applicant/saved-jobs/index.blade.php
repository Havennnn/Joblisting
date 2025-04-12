@extends('layouts.applicant')

@section('title', 'Saved Jobs')

@section('content')
    <div class="flex">
        <!-- Sidebar -->
        <x-applicant.sidebar />

        <!-- Main Content -->
        <div class="flex-1 py-8 px-12">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Saved Jobs</h1>
                </div>

                @if($savedJobs->isEmpty())
                    <div class="bg-gray-50 p-6 rounded-lg text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">You haven't saved any jobs yet.</h3>
                        <p class="text-gray-600 mb-6">Save jobs to come back to them later and keep track of positions you're interested in.</p>
                        <a href="{{ route('jobs.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-neksjob-blue hover:bg-blue-700">
                            Browse Jobs
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($savedJobs as $savedJob)
                            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="bg-neksjob-pink rounded-full w-12 h-12 flex items-center justify-center text-white">
                                            @if($savedJob->job->employer && $savedJob->job->employer->company_logo_path)
                                                <img src="{{ asset('storage/' . $savedJob->job->employer->company_logo_path) }}"
                                                     alt="{{ $savedJob->job->employer->company_name }}"
                                                     class="h-12 w-12 rounded-full object-cover">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900 hover:text-neksjob-blue">
                                                <a href="{{ route('jobs.show', $savedJob->job->id) }}">{{ $savedJob->job->title }}</a>
                                            </h3>
                                            <p class="text-gray-700">{{ $savedJob->job->employer->company_name ?? 'Company' }}</p>
                                            <div class="mt-4 space-y-2">
                                                <div class="flex items-center text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    </svg>
                                                    {{ $savedJob->job->location }}
                                                </div>
                                                <div class="flex items-center text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    PHP {{ number_format($savedJob->job->salary, 0) }}
                                                </div>
                                                <div class="flex items-center text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $savedJob->job->work_experience_level }} Experience
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <span class="text-sm text-gray-500">Saved {{ $savedJob->created_at->diffForHumans() }}</span>
                                        <button
                                            class="unsave-job-btn text-gray-600 hover:text-red-500"
                                            data-job-id="{{ $savedJob->job->id }}"
                                            title="Remove from saved jobs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $savedJobs->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle unsave job button clicks
        document.querySelectorAll('.unsave-job-btn').forEach(button => {
            button.addEventListener('click', function() {
                const jobId = this.dataset.jobId;

                fetch(`/applicant/saved-jobs/${jobId}/unsave`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Remove the job card from the UI
                        this.closest('.bg-white.border').remove();

                        // Check if there are no more saved jobs
                        if (document.querySelectorAll('.bg-white.border').length === 0) {
                            // Reload the page to show the empty state
                            window.location.reload();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endpush
@endsection
