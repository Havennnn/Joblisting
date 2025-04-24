@props(['company', 'currentDateRange'])

<div class="flex justify-between items-center py-4 px-12 border-b">
    <div>
        <div class="flex items-center space-x-3">
            <h1 class="text-xl font-semibold text-gray-800">Good morning, {{ Auth::user()->name ?? 'Maria' }}</h1>
        </div>
        <p class="text-sm text-gray-600 mt-1">
            Here is your job application statistic report from {{ $currentDateRange[0] }} - {{ $currentDateRange[1] }}
        </p>
    </div>
</div>
