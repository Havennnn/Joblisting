<div class="min-h-screen py-6 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900">Company Profile</h1>

                @if (session('status'))
                    <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Company Header -->
                <div class="mt-6 flex items-center">
                    <div class="mr-6">
                        <div class="w-32 h-32 bg-gray-200 rounded-md overflow-hidden flex items-center justify-center">
                            @if($employer && $employer->company_logo_path)
                                <img src="{{ route('employer.profile.logo', ['user' => $user->id]) }}"
                                     alt="Company Logo" class="w-full h-full object-cover">
                            @else
                                <svg class="h-16 w-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 4h16v16H4V4zm1 1v14h14V5H5zm4 6h6v4H9v-4zm1 1v2h4v-2h-4zm-1-6h2v4H9V6zm1 1v2h1V7H10z"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $employer->company_name ?? 'Your Company' }}</h2>
                        <p class="text-gray-600">{{ $employer->industry ?? 'Industry not specified' }}</p>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Full Name</p>
                            <p class="text-base text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="text-base text-gray-900">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Company Details Section -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">Company Details</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Company Name</p>
                            <p class="text-base text-gray-900">{{ $employer->company_name ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Industry</p>
                            <p class="text-base text-gray-900">{{ $employer->industry ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Phone Number</p>
                            <p class="text-base text-gray-900">{{ $employer->phone_number ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Location</p>
                            <p class="text-base text-gray-900">{{ $employer->location ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Website</p>
                            <p class="text-base text-gray-900">
                                @if($employer && $employer->website)
                                    <a href="{{ $employer->website }}" class="text-blue-600 hover:text-blue-800" target="_blank">
                                        {{ $employer->website }}
                                    </a>
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Company Description -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">Company Description</h3>
                    <div class="mt-4">
                        <p class="text-base text-gray-900">{{ $employer->company_description ?? 'No company description provided.' }}</p>
                    </div>
                </div>

                <!-- Edit Profile Button -->
                <div class="mt-8 flex justify-end">
                    <a href="{{ route('employer.profile.edit') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
