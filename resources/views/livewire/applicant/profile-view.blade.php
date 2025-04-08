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

            <!-- Profile Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="mr-6">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200">
                                @if($profile && $profile->profile_picture_path)
                                    <img src="{{ route('applicant.profile.picture', ['user' => $user->id]) }}"
                                         alt="Profile Picture" class="w-full h-full object-cover">
                                @else
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-gray-600">{{ $profile->field ?? 'No field specified' }}</p>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Full Name</p>
                                <p class="text-base text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email address</p>
                                <p class="text-base text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Phone Number</p>
                                <p class="text-base text-gray-900">{{ $profile->phone_number ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Location</p>
                                <p class="text-base text-gray-900">{{ $profile->location ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Gender</p>
                                <p class="text-base text-gray-900">{{ ucfirst($profile->gender ?? 'Not provided') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Age</p>
                                <p class="text-base text-gray-900">{{ $profile->age ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Field of Expertise</p>
                                <p class="text-base text-gray-900">{{ $profile->field ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Years of Experience</p>
                                <p class="text-base text-gray-900">{{ $profile->years_experience ?? 'Not provided' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Skills</p>
                                <p class="text-base text-gray-900">{{ $profile->skills ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Document -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Document</h3>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Resume</p>
                            @if($profile && $profile->resume_path)
                                <a href="{{ route('applicant.profile.resume', ['user' => $user->id]) }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                    </svg>
                                    View attached File
                                </a>
                            @else
                                <p class="text-base text-gray-900">No resume uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Button -->
            <div class="flex justify-end">
                <a href="{{ route('applicant.profile.edit') }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                    Edit Profile
                </a>
            </div>
        </div>
    </main>
</div>
