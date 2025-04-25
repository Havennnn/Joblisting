@extends('layouts.app')

@section('title', $job->title . ' - NextJob')

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
@vite('resources/js/pages/jobDetails.js')
<script>
    // Define these functions directly in case the external script doesn't load
    function openApplicationModal() {
        document.getElementById('applicationModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeApplicationModal() {
        document.getElementById('applicationModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Global variable for CSRF token to be used by toggleBookmark
    window.csrfToken = '{{ csrf_token() }}';

    function toggleBookmark(jobId) {
        if (typeof window.jobDetails !== 'undefined' && typeof window.jobDetails.toggleBookmark === 'function') {
            window.jobDetails.toggleBookmark(jobId, window.csrfToken);
        } else {
            // Fallback implementation if external script doesn't load
            const bookmark = document.getElementById('bookmark-' + jobId);
            const bookmarkText = document.getElementById('bookmark-text-' + jobId);

            if (!bookmark) return;

            const isSaved = bookmark.classList.contains('text-yellow-500');

            // Send request to server
            fetch(isSaved ? `/applicant/saved-jobs/${jobId}/unsave` : `/applicant/saved-jobs/${jobId}/save`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update UI based on server response
                if (data.saved) {
                    bookmark.classList.remove('text-gray-500');
                    bookmark.classList.add('text-yellow-500', 'fill-yellow-500');
                    if (bookmarkText) bookmarkText.textContent = 'Saved';
                } else {
                    bookmark.classList.remove('text-yellow-500', 'fill-yellow-500');
                    bookmark.classList.add('text-gray-500');
                    if (bookmarkText) bookmarkText.textContent = 'Save Job';
                }
            });

            // Update UI immediately for better UX
            if (isSaved) {
                bookmark.classList.remove('text-yellow-500', 'fill-yellow-500');
                bookmark.classList.add('text-gray-500');
                if (bookmarkText) bookmarkText.textContent = 'Save Job';
            } else {
                bookmark.classList.remove('text-gray-500');
                bookmark.classList.add('text-yellow-500', 'fill-yellow-500');
                if (bookmarkText) bookmarkText.textContent = 'Saved';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const jobId = '{{ $job->id }}';
        const csrfToken = '{{ csrf_token() }}';

        if (typeof jobDetails !== 'undefined') {
            jobDetails.init(jobId, csrfToken);
        }

        // Set up modal overlay event listener
        const modalOverlay = document.getElementById('modalOverlay');
        if (modalOverlay) {
            modalOverlay.addEventListener('click', closeApplicationModal);
        }
    });
</script>
@endpush

@section('content')
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 min-h-screen">
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 py-16">
        <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $job->title }}</h1>
                    <p class="text-white/80">{{ $job->employer->company_name }}</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Jobs
                    </a>
                    @auth
                        @if(auth()->user()->isApplicant())
                            <button onclick="toggleBookmark('{{ $job->id }}')" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                <svg id="bookmark-{{ $job->id }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                <span id="bookmark-text-{{ $job->id }}">Save Job</span>
                            </button>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-8 relative z-20">
        <div class="bg-white shadow-sm overflow-hidden border border-gray-200">
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <x-company-details :company="$job->company" :employer="$job->employer" />

                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">Job Description</h2>
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium {{ $job->tags == 'Urgent' ? 'bg-red-100 text-red-800' : ($job->tags == 'Featured' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ $job->tags ?? 'Recent' }}
                            </span>
                        </div>
                        <div class="prose max-w-none text-gray-600 bg-white p-5 border border-gray-100">
                            <p>{{ $job->job_description }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-5 border border-gray-200 shadow-sm">
                        <h3 class="font-medium text-gray-900 mb-3 pb-2 border-b">Job Details</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Location:</span>
                                <span class="text-gray-900 font-medium">{{ $job->location }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Job Type:</span>
                                <span class="text-gray-900 font-medium">{{ $job->type }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Work Setup:</span>
                                <span class="text-gray-900 font-medium">{{ $job->work_setup }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Industry:</span>
                                <span class="text-gray-900 font-medium">{{ $job->industry }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Role:</span>
                                <span class="text-gray-900 font-medium">{{ $job->role }}</span>
                            </div>
                            @if($job->salary > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Salary:</span>
                                <span class="text-gray-900 font-medium">₱{{ number_format($job->salary, 2) }} per month</span>
                            </div>
                            @endif
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Vacancies:</span>
                                <span class="text-gray-900 font-medium">{{ $job->vacancies }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Experience:</span>
                                <span class="text-gray-900 font-medium">{{ $job->work_experience_level }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Education:</span>
                                <span class="text-gray-900 font-medium">{{ $job->educational_level }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Shift:</span>
                                <span class="text-gray-900 font-medium">{{ $job->shift }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-5 border border-gray-200 shadow-sm">
                        <h3 class="font-medium text-gray-900 mb-3 pb-2 border-b">Job Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Posted On:</span>
                                <span class="text-gray-900 font-medium">{{ $job->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Available Until:</span>
                                <span class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($job->auto_delete_at)->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="apply" class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Apply for this position</h2>

                @auth
                    @if(auth()->user()->isApplicant())
                        @php
                            $applicant = auth()->user();
                            $profile = $applicant->applicantProfile;
                            $completionPercentage = $profileCompletionPercentage;

                            $hasApplied = \App\Models\Jobs\JobApplication::where('job_id', $job->id)
                                ->where('applicant_id', $applicant->id)
                                ->exists();
                        @endphp

                        @if($hasApplied)
                            <div class="bg-green-50 p-4 mb-4 border border-green-100">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Application Submitted</h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>You have already applied for this position.</p>
                                            <div class="mt-3">
                                                <a href="{{ route('applicant.applications') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                    View My Applications
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($completionPercentage < 100)
                            <x-profile-completion-alert :percentage="$completionPercentage" userType="applicant" />
                        @else
                            <button type="button" onclick="openApplicationModal()" class="inline-flex items-center px-5 py-3 border border-transparent text-sm font-medium shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Apply Now
                            </button>

                            <div id="applicationModal" class="fixed inset-0 overflow-y-auto hidden z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div id="modalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                    <div class="inline-block align-bottom bg-white text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                        Confirm Application
                                                    </h3>
                                                    <div class="mt-4">
                                                        <p class="text-sm text-gray-500 mb-4">
                                                            You are about to apply for <span class="font-semibold">{{ $job->title }}</span> at <span class="font-semibold">{{ $job->employer->company_name }}</span>. The following information from your profile will be shared:
                                                        </p>

                                                        <div class="bg-gray-50 p-3 mb-3 border border-gray-100">
                                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Personal Information</h4>
                                                            <ul class="text-sm text-gray-600 space-y-1">
                                                                <li><span class="font-medium">Name:</span> {{ $applicant->name }}</li>
                                                                <li><span class="font-medium">Email:</span> {{ $applicant->email }}</li>
                                                                <li><span class="font-medium">Phone:</span> {{ $profile->phone_number }}</li>
                                                                <li><span class="font-medium">Location:</span> {{ $profile->location }}</li>
                                                            </ul>
                                                        </div>

                                                        <div class="bg-gray-50 p-3 mb-3 border border-gray-100">
                                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Professional Information</h4>
                                                            <ul class="text-sm text-gray-600 space-y-1">
                                                                <li><span class="font-medium">Field:</span> {{ $profile->field }}</li>
                                                                <li><span class="font-medium">Experience:</span> {{ $profile->years_experience }} years</li>
                                                                <li><span class="font-medium">Skills:</span> {{ $profile->skills }}</li>
                                                            </ul>
                                                        </div>

                                                        <div class="bg-gray-50 p-3 border border-gray-100">
                                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Resume</h4>
                                                            @if($profile->resume_path)
                                                                <p class="text-sm text-gray-600">Your uploaded resume will be included with your application.</p>
                                                            @else
                                                                <p class="text-sm text-red-600">Warning: You haven't uploaded a resume. It's recommended to <a href="{{ route('applicant.profile.edit') }}" class="underline">add a resume</a> before applying.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <form action="{{ route('applicant.apply.job', $job->id) }}" method="POST" id="apply-form">
                                                @csrf
                                                <input type="hidden" name="job_id" value="{{ $job->id }}">
                                                <div class="flex sm:flex-row-reverse">
                                                    <button type="submit" class="inline-flex justify-center border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                        Submit Application
                                                    </button>
                                                    <button type="button" onclick="closeApplicationModal()" class="mt-3 w-full inline-flex justify-center border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @elseif(auth()->user()->isEmployer())
                        <div class="bg-blue-50 p-4 border border-blue-100">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Employer Account</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>You are currently logged in as an employer. To apply for jobs, please log in with an applicant account.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="bg-white p-6 shadow-sm text-center">
                        <div class="p-2 bg-blue-100 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Ready to apply?</h3>
                        <p class="text-gray-600 mb-6">Sign in or create an account to apply for this job.</p>
                        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('applicant.login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                Sign In
                            </a>
                            <a href="{{ route('applicant.register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium text-blue-600 bg-white hover:bg-gray-50 transition-colors">
                                Create Account
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
