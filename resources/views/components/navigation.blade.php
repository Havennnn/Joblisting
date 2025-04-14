<!-- Navigation Component -->
<nav class="w-full bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-8 w-auto">
                </a>
            </div>

            <div class="hidden md:flex items-center justify-between flex-1 ml-6">
                <div class="flex items-start space-x-4">
                    <a href="/"
                        class="{{ request()->is('/') ? 'text-neksjob-pink' : 'text-gray-900' }} hover:text-neksjob-pink px-3 py-2 text-sm font-medium transition-colors duration-300 ease-in-out">Home</a>
                    <a href="{{ route('jobs.index') }}"
                        class="{{ request()->routeIs('jobs.index') ? 'text-neksjob-pink' : 'text-gray-900' }} hover:text-neksjob-pink px-3 py-2 text-sm font-medium transition-colors duration-300 ease-in-out">Find jobs</a>

                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        @if (auth()->user()->role === 'applicant')
                            <div class="relative" id="notificationDropdown">
                                <button onclick="document.getElementById('notification-menu').classList.toggle('hidden')"
                                    class="relative p-1 rounded-full hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @if (auth()->user()->unreadNotifications->count() > 0)
                                        <span
                                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </button>

                                <!-- Notification Dropdown -->
                                <div id="notification-menu"
                                    class="hidden absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-sm font-medium text-gray-700">Notifications</h3>
                                            @if (auth()->user()->unreadNotifications->count() > 0)
                                                <form action="{{ route('applicant.notifications.read-all') }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-xs text-blue-600 hover:text-blue-800">
                                                        Mark all as read
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="max-h-60 overflow-y-auto">
                                        @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                                            <div
                                                class="p-3 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50 border-b border-gray-100">
                                                <div class="flex items-start">
                                                    @if (!$notification->read_at)
                                                        <span
                                                            class="flex-shrink-0 inline-block w-2 h-2 bg-blue-600 rounded-full mt-2 mr-2"></span>
                                                    @endif
                                                    <div class="ml-2 w-full">
                                                        <div class="flex justify-between items-start">
                                                            <p class="text-sm font-medium text-gray-900">
                                                                @if ($notification->type === 'App\\Notifications\\ApplicationStatusChanged')
                                                                    {{ ucfirst($notification->data['status']) }}
                                                                @else
                                                                    New notification
                                                                @endif
                                                            </p>
                                                            <span
                                                                class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-xs text-gray-600 mt-1">
                                                            @if ($notification->type === 'App\\Notifications\\ApplicationStatusChanged')
                                                                Application for {{ $notification->data['job_title'] }}
                                                            @else
                                                                You have a new notification
                                                            @endif
                                                        </p>
                                                        <div class="mt-1 flex justify-between items-center">
                                                            <a href="{{ route('applicant.applications') }}"
                                                                class="text-xs text-blue-600 hover:text-blue-800">
                                                                View details
                                                            </a>
                                                            @if (!$notification->read_at)
                                                                <form
                                                                    action="{{ route('applicant.notifications.read', $notification->id) }}"
                                                                    method="POST" class="inline">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="text-xs text-gray-500 hover:text-gray-700">
                                                                        Mark as read
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="py-4 px-3 text-center text-sm text-gray-500">
                                                No notifications yet
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="bg-gray-50 px-4 py-2 border-t border-gray-200">
                                        <a href="{{ route('applicant.notifications') }}"
                                            class="block w-full text-center text-sm font-medium text-blue-600 hover:text-blue-800 py-1">
                                            View all notifications
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @elseif(auth()->user()->isEmployer())
                            <div class="relative" id="employerNotificationDropdown">
                                <button
                                    onclick="document.getElementById('employer-notification-menu').classList.toggle('hidden')"
                                    class="relative p-1 rounded-full hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @if (auth()->user()->unreadNotifications->count() > 0)
                                        <span
                                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </button>

                                <!-- Employer Notification Dropdown -->
                                <div id="employer-notification-menu"
                                    class="hidden absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
                                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-sm font-medium text-gray-700">Notifications</h3>
                                            @if (auth()->user()->unreadNotifications->count() > 0)
                                                <form action="{{ route('employer.notifications.read-all') }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-xs text-blue-600 hover:text-blue-800">
                                                        Mark all as read
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="max-h-60 overflow-y-auto">
                                        @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                                            <div
                                                class="p-3 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50 border-b border-gray-100">
                                                <div class="flex items-start">
                                                    @if (!$notification->read_at)
                                                        <span
                                                            class="flex-shrink-0 inline-block w-2 h-2 bg-blue-600 rounded-full mt-2 mr-2"></span>
                                                    @endif
                                                    <div class="ml-2 w-full">
                                                        <div class="flex justify-between items-start">
                                                            <p class="text-sm font-medium text-gray-900">
                                                                @if ($notification->type === 'App\\Notifications\\NewJobApplication')
                                                                    New Application
                                                                @else
                                                                    New notification
                                                                @endif
                                                            </p>
                                                            <span
                                                                class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-xs text-gray-600 mt-1">
                                                            @if ($notification->type === 'App\\Notifications\\NewJobApplication')
                                                                {{ $notification->data['applicant_name'] }} applied for
                                                                {{ $notification->data['job_title'] }}
                                                            @else
                                                                You have a new notification
                                                            @endif
                                                        </p>
                                                        <div class="mt-1 flex justify-between items-center">
                                                            @if ($notification->type === 'App\\Notifications\\NewJobApplication')
                                                                <a href="{{ route('employer.applications.show', $notification->data['application_id']) }}"
                                                                    class="text-xs text-blue-600 hover:text-blue-800">
                                                                    View details
                                                                </a>
                                                            @else
                                                                <span></span>
                                                            @endif
                                                            @if (!$notification->read_at)
                                                                <form
                                                                    action="{{ route('employer.notifications.read', $notification->id) }}"
                                                                    method="POST" class="inline">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="text-xs text-gray-500 hover:text-gray-700">
                                                                        Mark as read
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="py-4 px-3 text-center text-sm text-gray-500">
                                                No notifications yet
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="bg-gray-50 px-4 py-2 border-t border-gray-200">
                                        <a href="{{ route('employer.notifications.index') }}"
                                            class="block w-full text-center text-sm font-medium text-blue-600 hover:text-blue-800 py-1">
                                            View all notifications
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="relative inline-block text-left" id="userDropdown">
                            <button type="button"
                                onclick="document.getElementById('dropdown-menu').classList.toggle('hidden')"
                                class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-gray-900 focus:outline-none">
                                {{ auth()->user()->name }}
                                <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="dropdown-menu"
                                class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <div class="py-1">
                                    @if (auth()->user()->isEmployer())
                                        <a href="{{ route('employer.dashboard') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                        <a href="{{ route('employer.profile.index') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                        <a href="{{ route('settings.index') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Sign out
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('applicant.dashboard') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                        <a href="{{ route('applicant.profile') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                        <a href="{{ route('settings.index') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Sign out
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        @if (Route::currentRouteName() == 'applicant.login')
                            <a href="{{ route('employer.login') }}"
                                class="hover:text-neksjob-pink text-sm font-medium transition-colors duration-300 ease-in-out">
                                Employer Login
                            </a>
                        @elseif(Route::currentRouteName() == 'employer.login' || Route::currentRouteName() == 'employer.register')
                            <a href="{{ route('applicant.login') }}"
                                class="hover:text-neksjob-blue text-sm font-medium transition-colors duration-300 ease-in-out">
                                Jobseeker Login
                            </a>
                        @elseif(request()->is('/') || request()->is('jobs') || request()->is('job-details/*') || Route::currentRouteName() == 'content.unavailable')
                            <div class="flex justify-center items-center space-x-4">
                                <a href="{{ route('applicant.login') }}"
                                    class="hover:text-neksjob-blue text-sm font-medium transition-colors duration-300 ease-in-out">
                                    Jobseeker Login
                                </a>
                                <span class="text-gray-500 text-sm">|</span>
                                <a href="{{ route('employer.login') }}"
                                    class="hover:text-neksjob-pink text-sm font-medium transition-colors duration-300 ease-in-out">
                                    Employer Login
                                </a>
                            </div>
                        @else
                            <a href="{{ route('applicant.login') }}"
                                class="border border-neksjob-blue rounded-md text-neksjob-blue hover:bg-neksjob-blue hover:text-white px-3 py-1 text-sm font-medium transition-all duration-300 ease-in-out">Jobseeker
                                Login</a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-neksjob-blue"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Simple JavaScript to close dropdown when clicking outside -->
<script>
    document.addEventListener('click', function(event) {
        var userDropdown = document.getElementById('userDropdown');
        var userDropdownMenu = document.getElementById('dropdown-menu');
        var notificationDropdown = document.getElementById('notificationDropdown');
        var notificationMenu = document.getElementById('notification-menu');
        var employerNotificationDropdown = document.getElementById('employerNotificationDropdown');
        var employerNotificationMenu = document.getElementById('employer-notification-menu');

        if (userDropdown && !userDropdown.contains(event.target) && userDropdownMenu && !userDropdownMenu
            .classList.contains('hidden')) {
            userDropdownMenu.classList.add('hidden');
        }

        if (notificationDropdown && !notificationDropdown.contains(event.target) && notificationMenu && !
            notificationMenu.classList.contains('hidden')) {
            notificationMenu.classList.add('hidden');
        }

        if (employerNotificationDropdown && !employerNotificationDropdown.contains(event.target) &&
            employerNotificationMenu && !employerNotificationMenu.classList.contains('hidden')) {
            employerNotificationMenu.classList.add('hidden');
        }
    });
</script>
