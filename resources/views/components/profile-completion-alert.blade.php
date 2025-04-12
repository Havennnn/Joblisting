@props(['percentage', 'userType' => 'applicant'])

@if(isset($percentage) && $percentage < 100)
    @php
        // Set variables based on user type
        if ($userType === 'employer') {
            $textColor = 'text-neksjob-pink';
            $buttonColor = 'bg-neksjob-pink hover:bg-pink-600';
            $barColor = 'bg-neksjob-pink';
            $message = $percentage < 70
                ? '<span class="text-neksjob-pink font-medium">Your profile requires more information before you can post jobs.</span> A complete profile helps attract better candidates and improves your company\'s visibility.'
                : 'Continue completing your profile to improve your company\'s visibility and attract better candidates.';
            $routeName = 'employer.profile.edit';
        } else {
            $textColor = 'text-neksjob-blue';
            $buttonColor = 'bg-neksjob-blue hover:bg-blue-600';
            $barColor = 'bg-neksjob-blue';
            $message = $percentage < 70
                ? '<span class="text-neksjob-blue font-medium">Your profile requires more information before you can apply for jobs.</span> A complete profile helps improve your chances of being hired.'
                : 'Continue completing your profile to improve your visibility to employers and increase your chances of being hired.';
            $routeName = 'applicant.profile';
        }
    @endphp

    <div class="bg-gray-50 rounded-lg border border-gray-200 mb-6 p-4">
        <div class="flex gap-4 items-start">
            {{-- Left: Percentage --}}
            <div class="flex flex-col items-center justify-center w-20 px-2 py-2">
                <span class="text-2xl font-bold {{ $textColor }}">{{ $percentage }}%</span>
                <span class="text-xs text-gray-500 leading-tight">of your profile is complete</span>
            </div>

            {{-- Right: Content --}}
            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Profile Completion Status</h2>

                    <div class="mb-3">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="{{ $barColor }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600">
                        {!! $message !!}
                    </p>
                </div>

                <div class="mt-4 text-right">
                    <a href="{{ route($routeName) }}"
                       class="inline-block px-4 py-2 text-sm font-medium text-white rounded-md {{ $buttonColor }} transition duration-200">
                        Complete Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
