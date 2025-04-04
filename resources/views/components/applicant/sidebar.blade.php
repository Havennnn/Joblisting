<!-- Sidebar Component for Applicant -->
<div class="w-64 min-h-screen bg-white border-r border-gray-200">
    <div class="py-6 px-6">
        <ul class="space-y-5">
            <li>
                <a href="{{ route('applicant.dashboard') }}" class="{{ request()->routeIs('applicant.dashboard') ? 'text-gray-900 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('applicant.dashboard') }}" class="{{ request()->routeIs('applicant.applications') ? 'text-gray-900 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    My Applications
                </a>
            </li>
            <li>
                <a href="{{ route('applicant.dashboard') }}" class="{{ request()->routeIs('applicant.interested-jobs') ? 'text-gray-900 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    Interested Jobs
                </a>
            </li>
            <li>
                <a href="{{ route('applicant.dashboard') }}" class="{{ request()->routeIs('applicant.interviews') ? 'text-gray-900 font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                    Scheduled Interview
                </a>
            </li>
        </ul>
    </div>
</div>
