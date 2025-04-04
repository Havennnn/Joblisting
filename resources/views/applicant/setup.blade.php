@extends('layouts.setup')

@section('title', 'Complete Your Profile')

@section('content')
<div class="min-h-screen bg-white-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full {{ $step == 1 ? 'bg-blue-600 text-white' : ($step > 1 ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500') }} flex items-center justify-center">
                                    1
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium {{ $step == 1 ? 'text-blue-600' : ($step > 1 ? 'text-green-600' : 'text-gray-500') }}">Basic Information</h3>
                                <p class="text-sm text-gray-500">Your personal details</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full {{ $step == 2 ? 'bg-blue-600 text-white' : ($step > 2 ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500') }} flex items-center justify-center">
                                    2
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium {{ $step == 2 ? 'text-blue-600' : ($step > 2 ? 'text-green-600' : 'text-gray-500') }}">Professional Details</h3>
                                <p class="text-sm text-gray-500">Experience and documents</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full {{ $step == 3 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center">
                                    3
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium {{ $step == 3 ? 'text-blue-600' : 'text-gray-500' }}">Confirmation</h3>
                                <p class="text-sm text-gray-500">Review and finish</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Setup Form -->
            <div class="bg-white shadow sm:rounded-lg border border-gray-300">
                <div class="px-4 py-5 sm:p-6">
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Step 1: Basic Information -->
                    @if($step == 1)
                        <form action="{{ route('applicant.setup.step-one') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h2>
                                <p class="text-sm text-gray-500 mb-6">Please provide your basic contact information.</p>
                                <hr class="border-t-2 border-gray-300 mb-4">
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $data['full_name'] ?? $user->name) }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $data['email'] ?? $user->email) }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $data['phone_number'] ?? '') }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                    <input type="text" name="location" id="location" value="{{ old('location', $data['location'] ?? '') }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                    <select name="gender" id="gender" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">Select gender</option>
                                        <option value="male" {{ old('gender', $data['gender'] ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $data['gender'] ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $data['gender'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                                    <input type="number" name="age" id="age" min="18" value="{{ old('age', $data['age'] ?? '') }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="flex justify-between pt-6">
                                <a href="{{ route('applicant.setup.skip') }}" class="text-sm text-blue-600 hover:text-blue-500">Skip for now</a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Next
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Step 2: Professional Details and Documents -->
                    @if($step == 2)
                        <form action="{{ route('applicant.setup.step-two') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h2>
                                <p class="text-sm text-gray-500 mb-6">Tell us about your skills and experience.</p>
                                <hr class="border-t-2 border-gray-300 mb-4">
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="field" class="block text-sm font-medium text-gray-700">Field of Expertise</label>
                                    <input type="text" name="field" id="field" value="{{ old('field', $data['field'] ?? '') }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                                    <textarea name="skills" id="skills" rows="3"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('skills', $data['skills'] ?? '') }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">Separate skills with commas</p>
                                </div>

                                <div>
                                    <label for="years_experience" class="block text-sm font-medium text-gray-700">Years of Experience</label>
                                    <input type="number" name="years_experience" id="years_experience" min="0" value="{{ old('years_experience', $data['years_experience'] ?? 0) }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Profile Picture (Optional)</label>
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-block h-16 w-16 rounded-full overflow-hidden bg-gray-100" id="preview-container">
                                            @if(isset($user->applicantProfile) && $user->applicantProfile->profile_picture_path && Storage::disk('public')->exists($user->applicantProfile->profile_picture_path))
                                                <img src="{{ Storage::url($user->applicantProfile->profile_picture_path) }}" alt="Profile" class="h-full w-full object-cover" id="profile-preview">
                                            @else
                                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24" id="profile-placeholder">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            @endif
                                        </span>
                                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*"
                                            class="ml-5 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Resume (Optional)</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="resume" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Upload a file</span>
                                                    <input id="resume" name="resume" type="file" class="sr-only" accept=".pdf,.doc,.docx">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PDF, DOC, DOCX up to 5MB
                                            </p>
                                            <div id="selected-resume" class="mt-2 text-sm text-green-600 {{ isset($user->applicantProfile) && $user->applicantProfile->resume_path ? '' : 'hidden' }}">
                                                @if(isset($user->applicantProfile) && $user->applicantProfile->resume_path)
                                                    Current resume: {{ basename($user->applicantProfile->resume_path) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between pt-6">
                                <a href="{{ route('applicant.setup.previous') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Previous
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Next
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Step 3: Confirmation -->
                    @if($step == 3)
                        <div class="space-y-6">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Confirm Your Information</h2>
                                <p class="text-sm text-gray-500 mb-6">Please review your information before finalizing your setup.</p>
                                <hr class="border-t-2 border-gray-300 mb-4">
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg space-y-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-3">Personal Information</h3>
                                    <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['full_name'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['email'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['phone_number'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['location'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                            <dd class="text-sm text-gray-900">{{ ucfirst($data['gender'] ?? 'Not provided') }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Age</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['age'] ?? 'Not provided' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-3">Professional Information</h3>
                                    <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Field of Expertise</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['field'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Years of Experience</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['years_experience'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div class="col-span-2">
                                            <dt class="text-sm font-medium text-gray-500">Skills</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['skills'] ?? 'Not provided' }}</dd>
                                        </div>

                                        @if(isset($data['profile_picture_path']))
                                        <div class="col-span-2 mt-2">
                                            <dt class="text-sm font-medium text-gray-500 mb-2">Profile Picture</dt>
                                            <dd class="text-sm text-gray-900">
                                                <img src="{{ Storage::url($data['profile_picture_path']) }}" alt="Profile Picture" class="h-16 w-16 rounded-full object-cover">
                                            </dd>
                                        </div>
                                        @endif

                                        @if(isset($data['resume_path']))
                                        <div class="col-span-2">
                                            <dt class="text-sm font-medium text-gray-500">Resume</dt>
                                            <dd class="text-sm text-gray-900">
                                                <a href="{{ Storage::url($data['resume_path']) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                    View Resume
                                                </a>
                                            </dd>
                                        </div>
                                        @endif
                                    </dl>
                                </div>
                            </div>

                            <form action="{{ route('applicant.setup.step-three') }}" method="POST" class="pt-4">
                                @csrf
                                <div class="flex justify-between">
                                    <a href="{{ route('applicant.setup.previous') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Previous
                                    </a>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Complete Setup
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Real-time image preview for profile picture
    document.addEventListener('DOMContentLoaded', function() {
        const profileInput = document.getElementById('profile_picture');
        const resumeInput = document.getElementById('resume');

        // Handle profile picture preview
        if (profileInput) {
            profileInput.addEventListener('change', function() {
                const preview = document.getElementById('preview-container');
                const placeholder = document.getElementById('profile-placeholder');

                // If there's already an image preview, replace it
                const existingPreview = document.getElementById('profile-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }

                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        if (placeholder) placeholder.style.display = 'none';

                        const img = document.createElement('img');
                        img.id = 'profile-preview';
                        img.src = e.target.result;
                        img.alt = 'Profile Preview';
                        img.className = 'h-full w-full object-cover';

                        preview.appendChild(img);
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // Handle resume file selection display
        if (resumeInput) {
            resumeInput.addEventListener('change', function() {
                const selectedResume = document.getElementById('selected-resume');

                if (this.files && this.files[0]) {
                    selectedResume.textContent = 'Selected file: ' + this.files[0].name;
                    selectedResume.classList.remove('hidden');
                }
            });
        }
    });
</script>
@endsection
@endsection
