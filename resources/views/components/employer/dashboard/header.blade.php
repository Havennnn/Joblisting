@props(['companyName', 'currentDateRange'])

<div class="flex justify-between items-center py-4 px-12 border-b">
    <div>
        <div class="flex items-center space-x-3">
            <h1 class="text-xl font-semibold text-gray-800">Good morning, {{ Auth::user()->name ?? 'Employer' }}</h1>
        </div>
        <p class="text-sm text-gray-600 mt-1">
            Here is your recruitment statistics report from {{ $currentDateRange[0] }} - {{ $currentDateRange[1] }}
        </p>
    </div>

    <div class="flex items-center">
        <a href="{{ route('employer.JobPost.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 flex items-center text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
            </svg>
            Post a job
        </a>
    </div>
</div>
