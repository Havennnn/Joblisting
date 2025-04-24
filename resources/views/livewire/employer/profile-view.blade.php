<div class="min-h-screen py-6 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900">Your Profile</h1>

                @if (session('status'))
                    <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('status') }}
                    </div>
                @endif

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
                        <div>
                            <p class="text-sm font-medium text-gray-500">Phone Number</p>
                            <p class="text-base text-gray-900">{{ $employer->phone_number ?? 'Not provided' }}</p>
                        </div>
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
