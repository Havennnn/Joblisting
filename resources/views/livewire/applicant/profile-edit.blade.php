<div class="bg-gray-100 min-h-screen">
    <!-- Page Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Your Profile</h1>
        </div>
    </header>

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <!-- Profile Form -->
            <form wire:submit.prevent="saveProfile" class="space-y-8" enctype="multipart/form-data">
                <!-- Basic Information Section -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Basic Information</h3>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" wire:model="full_name" id="full_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" wire:model="phone_number" id="phone_number" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" wire:model="location" id="location" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="City, State, Country">
                                @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                                <input type="number" wire:model="age" id="age" min="18" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('age') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <select wire:model="gender" id="gender" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Select gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('gender') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Details Section -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Professional Details</h3>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="field" class="block text-sm font-medium text-gray-700">Field of Expertise</label>
                                <input type="text" wire:model="field" id="field" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('field') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                                <textarea wire:model="skills" id="skills" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                <p class="mt-2 text-sm text-gray-500">Separate skills with commas</p>
                                @error('skills') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="years_experience" class="block text-sm font-medium text-gray-700">Years of Experience</label>
                                <input type="number" wire:model="years_experience" id="years_experience" min="0" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('years_experience') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Documents</h3>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                                <div class="mt-1 flex items-center">
                                    <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                        @if($profile_picture_preview)
                                            <img src="{{ $profile_picture_preview }}" alt="Profile" class="h-full w-full object-cover">
                                        @elseif($user->applicantProfile && $user->applicantProfile->profile_picture_path)
                                            <img src="{{ route('applicant.profile.picture', ['user' => $user->id]) }}" alt="Profile" class="h-full w-full object-cover">
                                        @else
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        @endif
                                    </span>
                                    <input type="file" wire:model="profile_picture" id="profile_picture" class="ml-5 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                                @if($user->profile_picture_path)
                                    <div class="mt-1 text-xs text-gray-500">
                                        Current file: {{ $user->profile_picture_path }}
                                    </div>
                                @endif
                                <div wire:loading wire:target="profile_picture" class="mt-2 text-sm text-blue-500">
                                    Uploading...
                                </div>
                                @error('profile_picture') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Resume</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        @if($user->resume_path && !$resume_name)
                                            <div class="text-sm text-gray-600 mb-3">
                                                <a href="{{ Storage::url($user->resume_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">
                                                    View Current Resume
                                                </a>
                                            </div>
                                        @endif

                                        @if($resume_name)
                                            <div class="text-sm text-green-600 mb-3">
                                                New File Selected: {{ $resume_name }}
                                            </div>
                                        @endif

                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="resume" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload a file</span>
                                                <input id="resume" wire:model="resume" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PDF, DOC, DOCX up to 5MB
                                        </p>
                                    </div>
                                </div>
                                <div wire:loading wire:target="resume" class="mt-2 text-sm text-blue-500">
                                    Uploading...
                                </div>
                                @error('resume') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save Profile
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
