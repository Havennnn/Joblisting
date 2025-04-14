@props([
    'employerLoginClass' => 'hover:text-neksjob-pink text-sm font-medium transition-colors duration-300 ease-in-out',
    'applicantLoginClass' => 'hover:text-neksjob-blue text-sm font-medium transition-colors duration-300 ease-in-out',
    'buttonClass' => 'border border-neksjob-blue rounded-md text-neksjob-blue hover:bg-neksjob-blue hover:text-white px-3 py-1 text-sm font-medium transition-all duration-300 ease-in-out'
])

@auth
    {{-- If authenticated, nothing to show here as user dropdown will be shown instead --}}
@else
    @if (Route::currentRouteName() == 'applicant.login')
        <a href="{{ route('employer.login') }}"
            class="{{ $employerLoginClass }}">
            Employer Login
        </a>
    @elseif(Route::currentRouteName() == 'employer.login' || Route::currentRouteName() == 'employer.register')
        <a href="{{ route('applicant.login') }}"
            class="{{ $applicantLoginClass }}">
            Jobseeker Login
        </a>
    @elseif(request()->is('/') || request()->is('jobs') || request()->is('job-details/*') || Route::currentRouteName() == 'content.unavailable')
        <div class="flex justify-center items-center space-x-4">
            <a href="{{ route('applicant.login') }}"
                class="{{ $applicantLoginClass }}">
                Jobseeker Login
            </a>
            <span class="text-gray-500 text-sm">|</span>
            <a href="{{ route('employer.login') }}"
                class="{{ $employerLoginClass }}">
                Employer Login
            </a>
        </div>
    @else
        <a href="{{ route('applicant.login') }}"
            class="{{ $buttonClass }}">Jobseeker Login</a>
    @endif
@endauth
