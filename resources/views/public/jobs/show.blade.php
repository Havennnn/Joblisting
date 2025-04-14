@extends('layouts.app')

@section('title', $job->title . ' - NeksJob')

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.toggleBookmark = function(jobId) {
            const bookmark = document.getElementById('bookmark-' + jobId);
            const isSaved = bookmark.classList.contains('text-yellow-500');

            const url = isSaved
                ? `/applicant/saved-jobs/${jobId}/unsave`
                : `/applicant/saved-jobs/${jobId}/save`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.saved) {
                    bookmark.classList.remove('text-gray-500');
                    bookmark.classList.add('text-yellow-500', 'fill-yellow-500');
                } else {
                    bookmark.classList.remove('text-yellow-500', 'fill-yellow-500');
                    bookmark.classList.add('text-gray-500');
                }
                console.log('Bookmark toggled:', data.saved);
            })
            .catch(error => {
                console.error('Error toggling bookmark:', error);
            });
        }

        // Check initial bookmark status
        const jobId = '{{ $job->id }}';
        fetch(`/applicant/saved-jobs/${jobId}/check`)
            .then(response => response.json())
            .then(data => {
                const bookmark = document.getElementById('bookmark-' + jobId);
                if (bookmark && data.saved) {
                    bookmark.classList.remove('text-gray-500');
                    bookmark.classList.add('text-yellow-500', 'fill-yellow-500');
                }
                console.log('Initial bookmark state:', data.saved);
            });
    });
</script>
@endpush

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <!-- Job Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                    @auth
                        @if(auth()->user()->isApplicant())
                            <div class="ml-3 cursor-pointer">
                                <button onclick="toggleBookmark('{{ $job->id }}')" type="button" class="focus:outline-none">
                                    <svg id="bookmark-{{ $job->id }}" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 hover:text-yellow-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                        <svg class="h-5 w-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Jobs
                    </a>
                </div>
            </div>
        </div>

        <!-- Job Details -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column - Main Details -->
            <div class="md:col-span-2">
                <!-- Company Information -->
                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mr-4">
                            @if($job->employer->company_logo_path)
                                <img src="{{ asset('storage/' . $job->employer->company_logo_path) }}" alt="Company Logo" class="h-16 w-16 rounded-lg object-cover">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M3 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $job->employer->company_name }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $job->employer->industry }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $job->employer->location }}</p>
                            @if($job->employer->website)
                                <a href="{{ $job->employer->website }}" target="_blank" class="mt-2 text-sm text-neksjob-blue hover:text-blue-800 inline-flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd" />
                                    </svg>
                                    Visit Website
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Job Description</h2>
                    <div class="prose max-w-none text-gray-600">
                        <p>{{ $job->job_description }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Additional Info -->
            <div class="space-y-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-medium text-gray-900 mb-3">Job Details</h3>
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

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-medium text-gray-900 mb-3">Job Information</h3>
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
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $job->tags == 'Urgent' ? 'bg-neksjob-pink text-white' : ($job->tags == 'Featured' ? 'bg-neksjob-blue text-white' : 'bg-gray-100 text-gray-800') }}">
                            {{ $job->tags }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Section -->
        <div id="apply" class="p-6 bg-gray-50 border-t border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Apply for this position</h2>

            @auth
                @if(auth()->user()->isApplicant())
                    @php
                        $applicant = auth()->user();
                        $profile = $applicant->applicantProfile;
                        // Use the value from the controller
                        $completionPercentage = $profileCompletionPercentage;

                        // Check if the user has already applied for this job
                        $hasApplied = \App\Models\Jobs\JobApplication::where('job_id', $job->id)
                            ->where('applicant_id', $applicant->id)
                            ->exists();
                    @endphp

                    @if($hasApplied)
                        <div class="bg-green-50 p-4 rounded-md mb-4">
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
                                            <a href="{{ route('applicant.applications') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
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
                        <button type="button" onclick="openApplicationModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-neksjob-blue hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
                            Apply Now
                        </button>

                        <!-- Application Confirmation Modal -->
                        <div id="applicationModal" class="fixed inset-0 overflow-y-auto hidden z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div id="modalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                <!-- Modal panel -->
                                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
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

                                                    <div class="bg-gray-50 p-3 rounded-md mb-3">
                                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Personal Information</h4>
                                                        <ul class="text-sm text-gray-600 space-y-1">
                                                            <li><span class="font-medium">Name:</span> {{ $applicant->name }}</li>
                                                            <li><span class="font-medium">Email:</span> {{ $applicant->email }}</li>
                                                            <li><span class="font-medium">Phone:</span> {{ $profile->phone_number }}</li>
                                                            <li><span class="font-medium">Location:</span> {{ $profile->location }}</li>
                                                        </ul>
                                                    </div>

                                                    <div class="bg-gray-50 p-3 rounded-md mb-3">
                                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Professional Information</h4>
                                                        <ul class="text-sm text-gray-600 space-y-1">
                                                            <li><span class="font-medium">Field:</span> {{ $profile->field }}</li>
                                                            <li><span class="font-medium">Experience:</span> {{ $profile->years_experience }} years</li>
                                                            <li><span class="font-medium">Skills:</span> {{ $profile->skills }}</li>
                                                        </ul>
                                                    </div>

                                                    <div class="bg-gray-50 p-3 rounded-md">
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
                                        <form action="{{ route('applicant.apply.job', $job->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-neksjob-blue text-base font-medium text-white hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue sm:ml-3 sm:w-auto sm:text-sm">
                                                Submit Application
                                            </button>
                                        </form>
                                        <button type="button" onclick="closeApplicationModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function openApplicationModal() {
                                document.getElementById('applicationModal').classList.remove('hidden');
                                document.body.classList.add('overflow-hidden');
                            }

                            function closeApplicationModal() {
                                document.getElementById('applicationModal').classList.add('hidden');
                                document.body.classList.remove('overflow-hidden');
                            }

                            // Close modal when clicking on overlay
                            document.getElementById('modalOverlay').addEventListener('click', function() {
                                closeApplicationModal();
                            });

                            function scrollToApply() {
                                const applySection = document.getElementById('apply');
                                applySection.scrollIntoView({ behavior: 'smooth' });
                            }
                        </script>
                    @endif
                @elseif(auth()->user()->isEmployer())
                    <div class="bg-blue-50 p-4 rounded-md">
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
                <div class="bg-gray-50 p-6 rounded-lg text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ready to apply?</h3>
                    <p class="text-gray-600 mb-6">Sign in or create an account to apply for this job.</p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('applicant.login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-neksjob-blue hover:bg-blue-700">
                            Sign In
                        </a>
                        <a href="{{ route('applicant.register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-md text-neksjob-blue bg-white hover:bg-gray-50">
                            Create Account
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
