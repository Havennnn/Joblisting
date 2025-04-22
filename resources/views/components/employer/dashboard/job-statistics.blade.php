@props(['dateRange', 'jobStats'])

<div class="bg-white shadow-sm overflow-hidden">
    <div class="p-5 border-b border-gray-200">
        <h2 class="text-lg font-semibold">Job posting statistics</h2>
        <p class="text-xs text-gray-500">Showing statistics for {{ $dateRange[0] }} - {{ $dateRange[1] }}</p>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <div class="flex px-5">
            <button class="px-4 py-3 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600">
                Overview
            </button>
            <button class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">
                Job Views
            </button>
            <button class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">
                Applications
            </button>
        </div>
    </div>

    <!-- Chart Area -->
    <div class="p-5">
        <div class="h-60">
            <!-- Chart container -->
            <div class="h-full relative">
                <!-- Chart Bars visualization -->
                <div class="absolute inset-0 flex items-end justify-between pt-6">
                    <!-- Monday -->
                    <div class="w-1/7 flex flex-col items-center">
                        <div class="space-y-1 w-12">
                            <div class="h-24 bg-yellow-400 w-full"></div>
                            <div class="h-12 bg-indigo-600 w-full"></div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">Mon</span>
                    </div>

                    <!-- Tuesday -->
                    <div class="w-1/7 flex flex-col items-center">
                        <div class="space-y-1 w-12">
                            <div class="h-16 bg-yellow-400 w-full"></div>
                            <div class="h-20 bg-indigo-600 w-full"></div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">Tue</span>
                    </div>

                    <!-- Wednesday -->
                    <div class="w-1/7 flex flex-col items-center">
                        <div class="space-y-1 w-12">
                            <div class="h-30 bg-yellow-400 w-full"></div>
                            <div class="h-18 bg-indigo-600 w-full"></div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">Wed</span>
                    </div>

                    <!-- Thursday -->
                    <div class="w-1/7 flex flex-col items-center">
                        <div class="space-y-1 w-12">
                            <div class="h-28 bg-yellow-400 w-full"></div>
                            <div class="h-22 bg-indigo-600 w-full"></div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">Thu</span>
                    </div>

                    <!-- Friday -->
                    <div class="w-1/7 flex flex-col items-center">
                        <div class="space-y-1 w-12">
                            <div class="h-22 bg-yellow-400 w-full"></div>
                            <div class="h-10 bg-indigo-600 w-full"></div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">Fri</span>
                    </div>

                    <!-- Saturday -->
                    <div class="w-1/7 flex flex-col items-center">
                        <div class="space-y-1 w-12">
                            <div class="h-14 bg-yellow-400 w-full"></div>
                            <div class="h-8 bg-indigo-600 w-full"></div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">Sat</span>
                    </div>

                    <!-- Sunday -->
                    <div class="w-1/7 flex flex-col items-center">
                        <div class="space-y-1 w-12">
                            <div class="h-18 bg-yellow-400 w-full"></div>
                            <div class="h-16 bg-indigo-600 w-full"></div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">Sun</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Legend -->
        <div class="mt-6 flex items-center justify-center space-x-8">
            <div class="flex items-center">
                <div class="w-3 h-3 bg-yellow-400 mr-2"></div>
                <span class="text-xs text-gray-600">Job Views</span>
            </div>
            <div class="flex items-center">
                <div class="w-3 h-3 bg-indigo-600 mr-2"></div>
                <span class="text-xs text-gray-600">Applications</span>
            </div>
        </div>
    </div>

    <!-- Job Stats Metrics -->
    <div class="grid grid-cols-2 border-t border-gray-200">
        <div class="p-5 border-r border-gray-200">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-sm text-gray-500 uppercase">Total Job Views</h3>
                    <div class="flex items-baseline mt-1">
                        <span class="text-2xl font-bold">{{ $jobStats['jobViews']['total'] }}</span>
                        <span class="ml-2 text-xs {{ $jobStats['jobViews']['trend'] === 'up' ? 'text-green-600' : 'text-red-600' }} flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 mr-1">
                                @if($jobStats['jobViews']['trend'] === 'up')
                                <path fill-rule="evenodd" d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022a19.407 19.407 0 00-5.594 5.203.75.75 0 01-1.139.093L7 10.06l-4.72 4.72a.75.75 0 01-1.06-1.061l5.25-5.25a.75.75 0 011.06 0l3.074 3.073a20.923 20.923 0 015.545-4.931l-3.042-.815a.75.75 0 01-.53-.919z" clip-rule="evenodd" />
                                @else
                                <path fill-rule="evenodd" d="M1.22 5.222a.75.75 0 011.06 0L7 9.942l3.768-3.769a.75.75 0 011.113.058 20.908 20.908 0 013.813 7.254l1.574-2.727a.75.75 0 011.3.75l-2.475 4.286a.75.75 0 01-.916.341l-4.473-1.576a.75.75 0 01.506-1.413l3.019 1.058a19.408 19.408 0 00-3.507-6.608L7 10.943 1.72 5.663a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                @endif
                            </svg>
                            {{ $jobStats['jobViews']['percentageChange'] }}%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">This Week</p>
                </div>
                <div class="text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8">
                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-1">
                    <h3 class="text-sm text-gray-500 uppercase">Total Applications</h3>
                    <div class="flex items-baseline mt-1">
                        <span class="text-2xl font-bold">{{ $jobStats['applications']['total'] }}</span>
                        <span class="ml-2 text-xs {{ $jobStats['applications']['trend'] === 'up' ? 'text-green-600' : 'text-red-600' }} flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3 mr-1">
                                @if($jobStats['applications']['trend'] === 'up')
                                <path fill-rule="evenodd" d="M12.577 4.878a.75.75 0 01.919-.53l4.78 1.281a.75.75 0 01.531.919l-1.281 4.78a.75.75 0 01-1.449-.387l.81-3.022a19.407 19.407 0 00-5.594 5.203.75.75 0 01-1.139.093L7 10.06l-4.72 4.72a.75.75 0 01-1.06-1.061l5.25-5.25a.75.75 0 011.06 0l3.074 3.073a20.923 20.923 0 015.545-4.931l-3.042-.815a.75.75 0 01-.53-.919z" clip-rule="evenodd" />
                                @else
                                <path fill-rule="evenodd" d="M1.22 5.222a.75.75 0 011.06 0L7 9.942l3.768-3.769a.75.75 0 011.113.058 20.908 20.908 0 013.813 7.254l1.574-2.727a.75.75 0 011.3.75l-2.475 4.286a.75.75 0 01-.916.341l-4.473-1.576a.75.75 0 01.506-1.413l3.019 1.058a19.408 19.408 0 00-3.507-6.608L7 10.943 1.72 5.663a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                @endif
                            </svg>
                            {{ $jobStats['applications']['percentageChange'] }}%
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">This Week</p>
                </div>
                <div class="text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-8 h-8">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .h-18 { height: 4.5rem; }
    .h-22 { height: 5.5rem; }
    .h-30 { height: 7.5rem; }
    .w-1/7 { width: 14.285%; }
</style>
@endpush
