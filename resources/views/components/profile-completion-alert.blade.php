@props(['percentage', 'userType' => 'applicant'])

@if(isset($percentage) && $percentage < 100)
    @php
        // Set variables based on user type
        if ($userType === 'employer') {
            $textColor = 'text-neksjob-pink';
            $linkColor = 'text-neksjob-blue';
            $barColor = 'bg-neksjob-blue';
            $message = $percentage < 70
                ? '<span class="text-neksjob-pink font-medium">Your profile requires more information before you can post jobs.</span> A complete profile helps attract better candidates and improves your company\'s visibility.'
                : 'Continue completing your profile to improve your company\'s visibility and attract better candidates.';
            $routeName = 'employer.profile.edit';
        } else {
            $textColor = 'text-neksjob-blue';
            $linkColor = 'text-neksjob-blue';
            $barColor = 'bg-neksjob-blue';
            $message = $percentage < 70
                ? '<span class="text-neksjob-pink font-medium">Your profile requires more information before you can apply for jobs.</span> A complete profile helps improve your chances of being hired.'
                : 'Continue completing your profile to improve your visibility to employers and increase your chances of being hired.';
            $routeName = 'applicant.profile';
        }
    @endphp

    <div class="bg-gray-50 rounded-lg border border-gray-200 mb-6 p-4">
        <h2 class="text-lg font-medium text-gray-900 mb-2">Profile Completion Status</h2>

        <div class="mb-4">
            <div class="flex items-center justify-between mb-1">
                <span class="text-sm font-medium text-gray-700">{{ $percentage }}% Complete</span>
                <a href="{{ route($routeName) }}" class="text-sm {{ $linkColor }} hover:underline">Complete Profile</a>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="{{ $barColor }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
            </div>
        </div>

        <p class="text-sm text-gray-600">
            {!! $message !!}
        </p>
    </div>
@endif
