@props(['applicationStats'])

<div class="bg-white shadow-sm h-full flex flex-col">
    <div class="p-5 border-b border-gray-200">
        <h2 class="text-sm font-medium text-gray-500 uppercase">Active Jobs</h2>
        <div class="mt-1">
            <span class="text-4xl font-bold">{{ $applicationStats['activeJobs'] }}</span>
            <p class="text-sm text-gray-500 mt-1">Currently active jobs</p>
        </div>
    </div>

    <div class="p-5 flex-1 flex flex-col">
        <h2 class="text-sm font-medium text-gray-500 uppercase mb-4">Application Status</h2>

        <div class="flex items-center mb-3">
            <span class="text-4xl font-bold text-gray-800">{{ $applicationStats['totalApplications'] }}</span>
            <span class="text-sm text-gray-500 ml-2">Total applications</span>
        </div>

        <!-- Application Status Progress Bar -->
        <div class="w-full h-2 bg-gray-200 rounded-full mb-6 overflow-hidden">
            <div class="flex h-full">
                <div class="bg-yellow-400 h-full" style="width: {{ $applicationStats['pendingPercentage'] }}%;"></div>
                <div class="bg-indigo-600 h-full" style="width: {{ $applicationStats['reviewingPercentage'] }}%;"></div>
                <div class="bg-green-500 h-full" style="width: {{ $applicationStats['acceptedPercentage'] }}%;"></div>
                <div class="bg-red-500 h-full" style="width: {{ $applicationStats['rejectedPercentage'] }}%;"></div>
            </div>
        </div>

        <div class="space-y-3 flex-1">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-yellow-400 mr-2"></div>
                    <span class="text-sm text-gray-600">Pending</span>
                </div>
                <span class="text-sm font-medium">{{ $applicationStats['pendingApplications'] }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-indigo-600 mr-2"></div>
                    <span class="text-sm text-gray-600">Reviewing</span>
                </div>
                <span class="text-sm font-medium">{{ $applicationStats['reviewingApplications'] }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Accepted</span>
                </div>
                <span class="text-sm font-medium">{{ $applicationStats['acceptedApplications'] }}</span>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-red-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Rejected</span>
                </div>
                <span class="text-sm font-medium">{{ $applicationStats['rejectedApplications'] }}</span>
            </div>

            <div class="flex items-center justify-between mt-4 pt-4 border-t">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-500 mr-2"></div>
                    <span class="text-sm text-gray-600">New today</span>
                </div>
                <span class="text-sm font-medium">{{ $applicationStats['newApplications'] }}</span>
            </div>
        </div>
    </div>
</div>
