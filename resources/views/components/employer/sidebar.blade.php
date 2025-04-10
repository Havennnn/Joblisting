<!-- Sidebar Component for Employer -->
<div class="w-64 min-h-screen bg-white border-r border-gray-200">
    <div class="py-6 px-6">
        <ul class="space-y-5">
            <li>
                <a href="{{ route('employer.dashboard') }}" class="{{ request()->routeIs('employer.dashboard') ? 'text-gray-900 font-semibold' : 'text-gray-600' }} hover:text-gray-900">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('employer.JobPost') }}" class="{{ request()->routeIs('employer.JobPost*') ? 'text-gray-900 font-semibold' : 'text-gray-600' }} hover:text-gray-900">
                    Job Listings
                </a>
            </li>
            <li>
                <a href="{{ route('employer.applications.index') }}" class="{{ request()->routeIs('employer.applications*') ? 'text-gray-900 font-semibold' : 'text-gray-600' }} hover:text-gray-900">
                    Applications
                </a>
            </li>
            <li>
                <a href="#" class="{{ request()->routeIs('employer.interviews*') ? 'text-gray-900 font-semibold' : 'text-gray-600' }} hover:text-gray-900">
                    Scheduled Interviews
                </a>
            </li>
        </ul>
    </div>
</div>
