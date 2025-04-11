<div class="bg-gray-100 min-h-screen">
    <!-- Page Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
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
                        <h3 class="text-md font-semibold text-gray-800 mb-4 underline underline-offset-4">Basic Information</h3>
            
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" wire:model="full_name" id="full_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
            
                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                                <input type="number" wire:model="age" id="age" min="18" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('age') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
            
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <select wire:model="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('gender') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
            
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" wire:model="phone_number" id="phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
            
                            <div class="md:col-span-2">
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" wire:model="location" id="location" placeholder="City, State, Country" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
            
                            <div class="md:col-span-1">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                <div class="mt-1 flex items-center gap-4">
                                    <input
                                        type="email"
                                        id="email"
                                        value="{{ $user->email }}"
                                        disabled
                                        class="flex-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500"
                                    >
                                    <button
                                        type="button"
                                        class="text-sm text-blue-600 hover:underline"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            
                <!-- Professional Details Section -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-md font-semibold text-gray-800 mb-4 underline underline-offset-4">Professional Details</h3>
            
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="field" class="block text-sm font-medium text-gray-700">Field of Expertise</label>
                                <input type="text" wire:model="field" id="field" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('field') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
            
                            <div>
                                <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
                                <textarea wire:model="skills" id="skills" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                                <p class="mt-2 text-sm text-gray-500">Separate skills with commas</p>
                                @error('skills') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
            
                            <div class="md:w-1/3">
                                <label for="years_experience" class="block text-sm font-medium text-gray-700">Years of Experience</label>
                                <input type="number" wire:model="years_experience" id="years_experience" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('years_experience') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Documents Section -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-md font-semibold text-gray-800 mb-4 underline underline-offset-4">Documents</h3>
            
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                                <div class="mt-2 flex items-center gap-4">
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
                                    <input type="file" wire:model="profile_picture" id="profile_picture" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
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
            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Resume</label>
                                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-md">
                                    <div class="text-center">
                                        @if($user->resume_path && !$resume_name)
                                            <div class="mb-3 text-sm text-gray-600">
                                                <a href="{{ Storage::url($user->resume_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                                    View Current Resume
                                                </a>
                                            </div>
                                        @endif
                                        @if($resume_name)
                                            <div class="mb-3 text-sm text-green-600">
                                                New File Selected: {{ $resume_name }}
                                            </div>
                                        @endif
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="mt-2 flex text-sm text-gray-600 justify-center items-center gap-2">
                                            <label for="resume" class="cursor-pointer font-medium text-blue-600 hover:text-blue-500">
                                                Upload a file
                                                <input id="resume" wire:model="resume" type="file" class="sr-only">
                                            </label>
                                            <span>or drag and drop</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX up to 5MB</p>
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
            
                <!-- Submit Buttons -->
                <div class="flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save Profile</button>
                </div>
            </form>
            
        </div>
    </main>
</div>
