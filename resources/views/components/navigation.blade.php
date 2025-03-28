<!-- Navigation Component -->
<nav class="w-full bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-8 w-auto">
                </a>
            </div>

            <div class="hidden md:flex items-center justify-between flex-1 ml-2">
                <div class="flex items-start space-x-4">
                    @auth
                        @if(auth()->user()->is_employer)
                            <a href="{{ route('employer.dashboard') }}" class="text-gray-900 hover:text-neksjob-blue px-3 py-2 text-sm font-medium">Dashboard</a>
                        @else
                            <a href="{{ route('applicant.dashboard') }}" class="text-gray-900 hover:text-neksjob-blue px-3 py-2 text-sm font-medium">Dashboard</a>
                        @endif
                    @else
                        <a href="/" class="text-gray-900 hover:text-neksjob-blue px-3 py-2 text-sm font-medium">Home</a>
                    @endauth
                    <a href="{{ route('jobs.index') }}" class="text-gray-900 hover:text-neksjob-blue px-3 py-2 text-sm font-medium">Find jobs</a>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->is_employer)
                            <form method="POST" action="{{ route('employer.logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-neksjob-pink hover:text-neksjob-blue px-3 py-2 text-sm font-medium">
                                    Logout
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-neksjob-pink hover:text-neksjob-blue px-3 py-2 text-sm font-medium">
                                    Logout
                                </button>
                            </form>
                        @endif
                    @else
                        @if(Route::currentRouteName() == 'applicant.login')
                            <a href="{{ route('employer.login') }}" class="border border-neksjob-pink rounded-md text-neksjob-pink hover:bg-neksjob-pink hover:text-white px-3 py-1 text-sm font-medium">Employer Login</a>
                        @elseif(Route::currentRouteName() == 'employer.login' || Route::currentRouteName() == 'employer.register')
                            <a href="{{ route('applicant.login') }}" class="border border-neksjob-blue rounded-md text-neksjob-blue hover:bg-neksjob-blue hover:text-white px-3 py-1 text-sm font-medium">Jobseeker Login</a>
                            @elseif(request()->is('/') || request()->is('jobs') || request()->is('job-details/*'))
                            <div class="flex space-x-4">
                                <a href="{{ route('applicant.login') }}" class="border border-neksjob-blue rounded-md text-neksjob-blue hover:bg-neksjob-blue hover:text-white px-3 py-1 text-sm font-medium">Jobseeker Login</a>
                                <a href="{{ route('employer.login') }}" class="border border-neksjob-pink rounded-md text-neksjob-pink hover:bg-neksjob-pink hover:text-white px-3 py-1 text-sm font-medium">Employer Login</a>
                            </div>
                        @else
                            <a href="{{ route('applicant.login') }}" class="border border-neksjob-blue rounded-md text-neksjob-blue hover:bg-neksjob-blue hover:text-white px-3 py-1 text-sm font-medium transition-all duration-300 ease-in-out">Jobseeker Login</a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-neksjob-blue" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
