<div class="bg-white min-h-screen">

    <!-- Header -->
    <div class="bg-gradient-to-r from-[#5d0000] to-[#e00000] text-white py-12 px-4">
        <div class="max-w-5xl mx-auto flex items-center">
            <div class="w-36 h-36 rounded-full border-4 border-white overflow-hidden">
                <img src="{{ $profile->profile_picture_path ? route('applicant.profile.picture', ['user' => $user->id]) : asset('images/avatar.png') }}"
                    alt="Profile Photo"
                    class="w-full h-full object-cover" />
            </div>
            <h1 class="text-3xl font-bold ml-10">{{ $user->name }}</h1>
        </div>
    </div>
 

    <!-- Info Sections -->
    <div class="max-w-5xl mx-auto py-10 space-y-8 px-4">
        <!-- Personal Info -->
        <div class="border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold underline mb-6">Personal Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 text-sm">
                <div>
                    <p class="text-gray-500">Full Name</p>
                    <p class="text-gray-900">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Email address</p>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Phone Number</p>
                    <p class="text-gray-900">{{ $profile->phone_number }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Location</p>
                    <p class="text-gray-900">{{ $profile->location }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Gender</p>
                    <p class="text-gray-900">{{ ucfirst($profile->gender) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Age</p>
                    <p class="text-gray-900">{{ $profile->age }}</p>
                </div>
            </div>
        </div>

        <!-- Professional Info -->
        <div class="border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold underline mb-6">Professional Information</h3>
            <div class="grid grid-cols-1 gap-6 text-sm">
                <div>
                    <p class="text-gray-500">Field of Expertise</p>
                    <p class="text-gray-900">{{ $profile->field }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Skills</p>
                    <p class="text-gray-900">{{ $profile->skills }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Years of Experience</p>
                    <p class="text-gray-900">{{ $profile->years_experience }}</p>
                </div>
            </div>
        </div>

        <!-- Document -->
        <div class="border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold underline mb-6">Document</h3>
            <div class="text-sm">
                <p class="text-gray-500 mb-1">Resume</p>
                @if($profile && $profile->resume_path)
                    <a href="{{ route('applicant.profile.resume', ['user' => $user->id]) }}" class="text-[#3674B5] hover:underline">
                        View attached File
                    </a>
                @else
                    <p class="text-gray-900">No resume uploaded</p>
                @endif
            </div>
        </div>

        <!-- Edit Button -->
        <div class="flex justify-end">
            <a href="{{ route('applicant.profile.edit') }}"
               class="bg-[#3674B5] hover:bg-[#15589e] text-white text-sm px-4 py-2 rounded-md transition duration-300">
                Edit Profile
            </a>
        </div>
    </div>
</div>
