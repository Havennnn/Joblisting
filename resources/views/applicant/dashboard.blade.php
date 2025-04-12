@extends('layouts.applicant')

@section('title', 'Applicant Dashboard')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <x-applicant.sidebar />

    <!-- Main Content -->
    <div class="flex-1 bg-gray-50">
        <div class="py-8 px-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>
            <p class="text-xl mb-8">Welcome {{ Auth::user()->name ?? 'User' }}</p>

            <!-- Dashboard Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Profile Completion Card -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-sm font-semibold uppercase">PROFILE COMPLETION</h2>
                    </div>
                    <div class="px-4 pb-4 flex items-center">
                        <div class="mr-4">
                            <div class="relative h-14 w-14">
                                <!-- Circular progress indicator -->
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <path
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none"
                                        stroke="#E6E6E6"
                                        stroke-width="3"
                                    />
                                    <path
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none"
                                        stroke="{{ $progressColor ?? '#00CC00' }}"
                                        stroke-width="3"
                                        stroke-dasharray="{{ $profileCompletionPercentage ?? 75 }}, 100"
                                    />
                                </svg>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                                    <span class="text-base font-bold">{{ $profileCompletionPercentage ?? 75 }}%</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm mb-1">{{ $profileCompletionMessage ?? "You're all set! Start applying now!" }}</p>
                            <a href="{{ $profileActionLink ?? '#' }}" class="text-blue-600 hover:text-blue-800 text-sm">View your profile</a>
                        </div>
                    </div>
                </div>

                <!-- Interested Jobs Card -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-sm font-semibold uppercase">INTERESTED JOBS</h2>
                    </div>
                    <div class="px-4 pb-4 flex items-center">
                        <div class="text-4xl font-bold ml-1 mr-5">25</div>
                        <div>
                            <p class="text-sm mb-1">Saved jobs you're interested in</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View your interested jobs</a>
                        </div>
                    </div>
                </div>

                <!-- Scheduled Interviews Card -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-sm font-semibold uppercase">SCHEDULED INTERVIEWS</h2>
                    </div>
                    <div class="px-4 pb-4 flex items-center">
                        <div class="text-4xl font-bold ml-1 mr-5">12</div>
                        <div>
                            <p class="text-sm mb-1">Job interviews that are scheduled</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View your scheduled interviews</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Applications Section -->
            <div id="recent-applications-container">
                <x-applicant.recent-applications :applications="$applications" />
            </div>

            <!-- Recommended Jobs Section -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to handle pagination links for recent applications
        function setupRecentApplicationsPagination() {
            const paginationLinks = document.querySelectorAll('#recent-applications-container .pagination a');

            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');

                    // Show loading state
                    const container = document.getElementById('recent-applications-container');
                    container.innerHTML = '<div class="text-center py-4"><svg class="animate-spin h-8 w-8 mx-auto text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><p class="mt-2 text-gray-600">Loading...</p></div>';

                    // Fetch new content
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                        setupRecentApplicationsPagination(); // Re-attach event listeners

                        // Update URL without reloading page
                        window.history.pushState({}, '', url);
                    })
                    .catch(error => {
                        console.error('Error fetching applications:', error);
                        container.innerHTML = '<div class="p-8 text-center text-red-600">Error loading data. Please try again.</div>';
                    });
                });
            });
        }

        // Initialize pagination for recent applications
        setupRecentApplicationsPagination();
    });
</script>
@endpush
@endsection
