<div class="w-full md:w-72 md:flex-shrink-0" x-data="{ open: false }">
    <div class="md:hidden flex justify-between items-center bg-white shadow-sm p-4 mb-4">
        <h2 class="text-lg font-medium text-gray-900">Filters</h2>
        <button @click="open = !open" class="bg-gray-100 p-2 hover:bg-gray-200 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" x-bind:class="open ? 'rotate-180 transform' : ''" />
            </svg>
        </button>
    </div>

    <div class="bg-white shadow-sm overflow-hidden transition-all duration-300 mb-6"
         :class="{'max-h-0 md:max-h-full': !open, 'max-h-[1000px]': open, 'mb-0': !open && window.innerWidth < 768}">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-6 hidden md:block">Filters</h2>

            <div class="mb-6">
                <h3 class="text-md font-medium text-gray-900 mb-3">Location</h3>
                <div class="space-y-2.5">
                    <div class="flex items-center">
                        <input id="makati" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="makati" class="ml-2 text-sm text-gray-700">Makati</label>
                    </div>
                    <div class="flex items-center">
                        <input id="pasig" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="pasig" class="ml-2 text-sm text-gray-700">Pasig</label>
                    </div>
                    <div class="flex items-center">
                        <input id="quezon" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="quezon" class="ml-2 text-sm text-gray-700">Quezon City</label>
                    </div>
                    <div class="flex items-center">
                        <input id="manila" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="manila" class="ml-2 text-sm text-gray-700">Manila</label>
                    </div>
                    <div class="flex items-center">
                        <input id="taguig" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="taguig" class="ml-2 text-sm text-gray-700">Taguig</label>
                    </div>
                </div>
                <button class="text-blue-600 text-sm mt-3 hover:text-blue-800 font-medium flex items-center">
                    Show More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <div class="mb-6">
                <h3 class="text-md font-medium text-gray-900 mb-3">Job Type</h3>
                <div class="space-y-2.5">
                    <div class="flex items-center">
                        <input id="full-time" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="full-time" class="ml-2 text-sm text-gray-700">Full Time</label>
                    </div>
                    <div class="flex items-center">
                        <input id="part-time" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="part-time" class="ml-2 text-sm text-gray-700">Part Time</label>
                    </div>
                    <div class="flex items-center">
                        <input id="contract" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="contract" class="ml-2 text-sm text-gray-700">Contract</label>
                    </div>
                    <div class="flex items-center">
                        <input id="internship" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="internship" class="ml-2 text-sm text-gray-700">Internship</label>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-md font-medium text-gray-900 mb-3">Specialization</h3>
                <div class="space-y-2.5">
                    <div class="flex items-center">
                        <input id="call-center" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="call-center" class="ml-2 text-sm text-gray-700">Call Center & Customer Service</label>
                    </div>
                    <div class="flex items-center">
                        <input id="accounting" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="accounting" class="ml-2 text-sm text-gray-700">Accounting</label>
                    </div>
                    <div class="flex items-center">
                        <input id="info-comm" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="info-comm" class="ml-2 text-sm text-gray-700">Information & Communication</label>
                    </div>
                    <div class="flex items-center">
                        <input id="sales" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="sales" class="ml-2 text-sm text-gray-700">Sales</label>
                    </div>
                    <div class="flex items-center">
                        <input id="engineering" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="engineering" class="ml-2 text-sm text-gray-700">Engineering</label>
                    </div>
                </div>
                <button class="text-blue-600 text-sm mt-3 hover:text-blue-800 font-medium flex items-center">
                    Show More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <div class="mb-6">
                <h3 class="text-md font-medium text-gray-900 mb-3">Experience Level</h3>
                <div class="space-y-2.5">
                    <div class="flex items-center">
                        <input id="entry-level" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="entry-level" class="ml-2 text-sm text-gray-700">Entry Level</label>
                    </div>
                    <div class="flex items-center">
                        <input id="mid-level" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="mid-level" class="ml-2 text-sm text-gray-700">Mid Level</label>
                    </div>
                    <div class="flex items-center">
                        <input id="senior-level" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="senior-level" class="ml-2 text-sm text-gray-700">Senior Level</label>
                    </div>
                    <div class="flex items-center">
                        <input id="manager" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <label for="manager" class="ml-2 text-sm text-gray-700">Manager</label>
                    </div>
                </div>
            </div>

            <div class="flex space-x-3">
                <button class="flex-1 py-2.5 px-4 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Reset
                </button>
                <button class="flex-1 py-2.5 px-4 bg-[#2563EB] border border-transparent text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-md">
                    Apply
                </button>
            </div>
        </div>
    </div>
</div>
