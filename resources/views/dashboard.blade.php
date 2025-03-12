<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Applicant Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome Applicant!") }}
                </div>
            </div>

            <!-- Job Search Filters -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Find a Job</h3>

                <form method="GET" action="">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Job Category Dropdown -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300">Job Category:</label>
                            <select name="job_category" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                                <option value="">Select Category</option>
                                <option value="CSR">Customer Service Representative</option>
                                <option value="Software Developer">Software Developer</option>
                                <option value="IT Support">IT Support</option>
                            </select>
                        </div>

                        <!-- Salary Expectation Dropdown -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300">Salary Expectation:</label>
                            <select name="salary" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                                <option value="">Select Salary</option>
                                <option value="15000-20000">₱15,000 - ₱20,000</option>
                                <option value="25000-30000">₱25,000 - ₱30,000</option>
                            </select>
                        </div>

                        <!-- Work Setup Dropdown -->
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300">Work Setup:</label>
                            <select name="work_setup" class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white" required>
                                <option value="">Select Work Setup</option>
                                <option value="On-site">On-site</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="Remote">Remote</option>
                            </select>
                        </div>
                    </div>


<!-- Search Button -->
<div class="mt-4">
    <button type="submit"
        class="bg-blue-600 text-white font-bold py-3 px-6 rounded-lg
        border-4 border-white shadow-lg transition-all duration-300
        hover:bg-blue-800 hover:scale-105">
        🔍 Search Jobs
    </button>
</div>

                </form>
            </div>

            <!-- No Jobs Available Message and Subscription Button -->
            @if(request()->isMethod('GET') && request()->query() && request()->has('job_category') && request()->has('salary') && request()->has('work_setup'))
                <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex justify-between items-center border border-gray-300 dark:border-gray-600">
                    <p class="text-gray-700 dark:text-gray-300 font-medium">
                        Currently, there are no job listings that match your criteria. Subscribe to job alerts for future updates.
                    </p>
                    <button id="subscribeBtn" class="border border-blue-500 text-blue-500 font-bold py-2 px-4 rounded hover:bg-blue-500 hover:text-white transition duration-300"
                        onclick="toggleSubscription()">
                        Subscribe for Job Alerts
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript for Interactive Button -->
    <script>
        function toggleSubscription() {
            const btn = document.getElementById('subscribeBtn');
            if (btn.classList.contains('bg-blue-500')) {
                btn.classList.remove('bg-blue-500', 'text-white');
                btn.classList.add('border-blue-500', 'text-blue-500');
                btn.innerText = 'Subscribe for Job Alerts';
            } else {
                btn.classList.add('bg-blue-500', 'text-white');
                btn.classList.remove('border-blue-500', 'text-blue-500');
                btn.innerText = 'Subscribed';
            }
        }
    </script>
</x-app-layout>
