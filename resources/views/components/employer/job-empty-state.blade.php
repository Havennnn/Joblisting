@props(['completionPercentage'])

<div class="text-center py-12 px-4">
    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
    </div>

    <h3 class="text-lg font-medium text-gray-900 mb-2">No Job Listings Yet</h3>

    <p class="text-sm text-gray-600 mb-6 max-w-md mx-auto">
        You haven't created any job listings yet. Start by creating your first job post to find the perfect candidates.
    </p>

    @if($completionPercentage < 100)
        <div class="mb-6 max-w-md mx-auto">
            <div class="flex items-center justify-between mb-1">
                <span class="text-sm text-gray-600">Profile completion</span>
                <span class="text-sm font-medium text-gray-900">{{ $completionPercentage }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $completionPercentage }}%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Complete your profile to increase your visibility to job seekers.
            </p>
        </div>
    @endif

    <a href="{{ route('employer.JobPost.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-neksjob-blue hover:bg-neksjob-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neksjob-blue">
        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Create Job Listing
    </a>
</div>
