<div class="bg-white shadow-sm p-12 text-center">
    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $title ?? 'No data found' }}</h3>
    <p class="mt-2 text-sm text-gray-500">{{ $message ?? 'There are no items to display at the moment.' }}</p>
    @if(isset($action) && isset($actionUrl))
    <div class="mt-6">
        <a href="{{ $actionUrl }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ $action }}
        </a>
    </div>
    @endif
</div>
