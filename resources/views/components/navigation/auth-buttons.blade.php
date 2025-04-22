@props([
    'employerLoginClass' => 'relative text-md font-light text-nextjob-black group transition-all duration-300 ease-in-out',
    'applicantLoginClass' => 'relative text-md font-light text-nextjob-black group transition-all duration-300 ease-in-out',
])

@auth

@else
    @if (in_array(Route::currentRouteName(), ['applicant.login', 'employer.register']))
        <a href="{{ route('employer.login') }}" class="{{ $employerLoginClass }}">
            <span class="block group-hover:text-nextjob-red">Employer Login</span>
            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-nextjob-red group-hover:w-full transition-all duration-300 ease-in-out"></span>
        </a>
        @elseif(in_array(Route::currentRouteName(), ['employer.login', 'applicant.register']))
        <a href="{{ route('applicant.login') }}" class="{{ $applicantLoginClass }}">
            <span class="block group-hover:text-nextjob-blue">Jobseeker Login</span>
            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-nextjob-blue group-hover:w-full transition-all duration-300 ease-in-out"></span>
        </a>
    @elseif(request()->is('/') || request()->is('jobs') || Route::currentRouteName() == 'jobs.show' || Route::currentRouteName() == 'job.show' || Route::currentRouteName() == 'content.unavailable')
        <div class="flex justify-center items-center space-x-4">
            <a href="{{ route('applicant.login') }}" class="{{ $applicantLoginClass }}">
                <span class="block group-hover:text-nextjob-blue">Jobseeker Login</span>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-nextjob-blue group-hover:w-full transition-all duration-300 ease-in-out"></span>
            </a>
            <span class="text-gray-500 text-sm">|</span>
            <a href="{{ route('employer.login') }}" class="{{ $employerLoginClass }}">
                <span class="block group-hover:text-nextjob-red">Employer Login</span>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-nextjob-red group-hover:w-full transition-all duration-300 ease-in-out"></span>
            </a>
        </div>
    @endif
@endauth
