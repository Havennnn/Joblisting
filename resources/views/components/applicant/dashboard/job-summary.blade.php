@props([])

<div class="bg-white shadow-sm h-full flex flex-col">
    <div class="p-5 border-b border-gray-200">
        <h2 class="text-sm font-medium text-gray-500 uppercase">Job Open</h2>
        <div class="mt-1">
            <span class="text-4xl font-bold">12</span>
            <p class="text-sm text-gray-500 mt-1">Jobs Opened</p>
        </div>
    </div>

    <div class="p-5 flex-1 flex flex-col">
        <h2 class="text-sm font-medium text-gray-500 uppercase mb-4">Applicants Summary</h2>

        <div class="flex items-center mb-3">
            <span class="text-4xl font-bold text-gray-800">67</span>
            <span class="text-sm text-gray-500 ml-2">Applicants</span>
        </div>

        <div class="w-full h-2 bg-gray-200 rounded-full mb-6 overflow-hidden">
            <div class="flex h-full">
                <div class="bg-indigo-600 h-full" style="width: 48%;"></div>
                <div class="bg-yellow-400 h-full" style="width: 32%;"></div>
                <div class="bg-pink-500 h-full" style="width: 20%;"></div>
            </div>
        </div>

        <!-- Applicant Types Legend -->
        <div class="space-y-3 flex-1">
            <!-- Full Time -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-indigo-600 mr-2"></div>
                    <span class="text-sm text-gray-600">Full Time</span>
                </div>
                <span class="text-sm font-medium">48</span>
            </div>

            <!-- Internship -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-yellow-400 mr-2"></div>
                    <span class="text-sm text-gray-600">Internship</span>
                </div>
                <span class="text-sm font-medium">32</span>
            </div>

            <!-- Contract -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-pink-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Contract</span>
                </div>
                <span class="text-sm font-medium">20</span>
            </div>

            <!-- Part Time -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Part Time</span>
                </div>
                <span class="text-sm font-medium">24</span>
            </div>

            <!-- Remote -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-cyan-500 mr-2"></div>
                    <span class="text-sm text-gray-600">Remote</span>
                </div>
                <span class="text-sm font-medium">22</span>
            </div>
        </div>
    </div>
</div>
