@extends('layouts.applicant')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-64 mb-6 md:mb-0 md:mr-8">
            <x-applicant.sidebar />
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            @if(isset($profileCompletionPercentage) && $profileCompletionPercentage < 100)
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Your profile is {{ $profileCompletionPercentage }}% complete.
                            <a href="{{ route('applicant.profile') }}" class="font-medium underline text-blue-700 hover:text-blue-600">
                                Complete your profile
                            </a> to increase your chances of getting hired.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">My Applications</h1>
            </div>

            <div id="applications-container">
                @include('applicant.applications.partials.application-list')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to handle pagination links
        function setupPaginationLinks() {
            const paginationLinks = document.querySelectorAll('#applications-container .pagination a');

            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const url = this.getAttribute('href');

                    // Fetch the new page
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('applications-container').innerHTML = html;
                        setupPaginationLinks(); // Re-setup links for new content
                    })
                    .catch(error => {
                        console.error('Error fetching applications:', error);
                    });
                });
            });
        }

        // Initial setup
        setupPaginationLinks();
    });
</script>
@endpush
