@props(['percentage', 'userType' => 'applicant'])

@if(isset($percentage) && $percentage < 100)
    @php
        // Set variables based on user type
        if ($userType === 'employer') {
            $message = $percentage < 70
                ? 'Your profile requires more information before you can post jobs. A complete profile helps attract better candidates.'
                : 'Continue completing your profile to improve your company\'s visibility and attract better candidates.';
            $routeName = 'employer.profile.edit';
        } else {
            $message = $percentage < 70
                ? 'Your profile requires more information before you can apply for jobs. A complete profile improves your chances of being hired.'
                : 'Continue completing your profile to improve your visibility to employers and increase your chances of being hired.';
            $routeName = 'applicant.profile';
        }
    @endphp

    <div class="bg-white shadow-sm border border-gray-100 mb-6">
        <div class="p-5">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-lg font-medium text-gray-900">Profile Completion</h2>
                <div class="flex items-center gap-1">
                    <div class="text-nextjob-blue font-bold text-xl mr-1">{{ $percentage }}%</div>
                    <span class="text-lg text-gray-500">complete</span>
                </div>
            </div>

            <div class="mb-4 w-full">
                <div class="w-full bg-gray-100 h-2">
                    <div class="bg-nextjob-blue h-2 transition-all duration-500" style="width: {{ $percentage }}%"></div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 max-w-md">
                    {{ $message }}
                </p>
                <a href="{{ route($routeName) }}"
                   class="flex-shrink-0 ml-2 px-4 py-2 text-sm font-medium text-white bg-nextjob-blue hover:bg-blue-600 transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-nextjob-blue">
                    Complete Profile
                </a>
            </div>
        </div>
    </div>
@endif
