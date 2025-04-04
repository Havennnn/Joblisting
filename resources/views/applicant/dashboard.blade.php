@extends('layouts.applicant')

@section('title', 'Applicant Dashboard')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <x-applicant.sidebar />

    <!-- Main Content -->
    <div class="flex-1 bg-gray-50">
        <div class="py-8 px-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Dashboard</h1>
            <p class="text-xl mb-8">Welcome {{ Auth::user()->name ?? 'User' }}</p>

            <!-- Dashboard Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Profile Completion Card -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-sm font-semibold uppercase">PROFILE COMPLETION</h2>
                    </div>
                    <div class="p-4 flex items-center">
                        <div class="mr-4">
                            <div class="relative h-16 w-16">
                                <!-- Circular progress indicator -->
                                <svg class="w-full h-full" viewBox="0 0 36 36">
                                    <path
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none"
                                        stroke="#E6E6E6"
                                        stroke-width="3"
                                    />
                                    <path
                                        d="M18 2.0845
                                        a 15.9155 15.9155 0 0 1 0 31.831
                                        a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none"
                                        stroke="#00CC00"
                                        stroke-width="3"
                                        stroke-dasharray="100, 100"
                                    />
                                </svg>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                                    <span class="text-base font-bold">100%</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm mb-1">You're all set! Start applying now!</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View your profile</a>
                        </div>
                    </div>
                </div>

                <!-- Interested Jobs Card -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-sm font-semibold uppercase">INTERESTED JOBS</h2>
                    </div>
                    <div class="p-4 flex items-center">
                        <div class="text-5xl font-bold mr-6">5</div>
                        <div>
                            <p class="text-sm mb-1">Saved jobs you're interested in</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View your interested jobs</a>
                        </div>
                    </div>
                </div>

                <!-- Scheduled Interviews Card -->
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="p-4">
                        <h2 class="text-sm font-semibold uppercase">SCHEDULED INTERVIEWS</h2>
                    </div>
                    <div class="p-4 flex items-center">
                        <div class="text-5xl font-bold mr-6">1</div>
                        <div>
                            <p class="text-sm mb-1">Job interviews that are scheduled</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View your scheduled interviews</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Applications Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">My Applications</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>

                <!-- Applications Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="py-4 px-3 text-left font-medium text-gray-500 w-2/5">Jobs</th>
                                <th class="py-4 px-3 text-center font-medium text-gray-500">Applied</th>
                                <th class="py-4 px-3 text-center font-medium text-gray-500">Interview</th>
                                <th class="py-4 px-3 text-center font-medium text-gray-500">Hired</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="py-4 px-3">
                                    <div class="flex items-center">
                                        <div class="bg-red-600 text-white p-2 rounded-full mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">Customer Service Representative</p>
                                            <p class="text-sm text-gray-500">March 25, 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full inline-block font-medium">
                                        Hired
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-4 px-3">
                                    <div class="flex items-center">
                                        <div class="bg-red-600 text-white p-2 rounded-full mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">Customer Service Representative</p>
                                            <p class="text-sm text-gray-500">March 25, 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full inline-block font-medium">
                                        Hired
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-4 px-3">
                                    <div class="flex items-center">
                                        <div class="bg-red-600 text-white p-2 rounded-full mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">Customer Service Representative</p>
                                            <p class="text-sm text-gray-500">March 25, 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full inline-block font-medium">
                                        Hired
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-4 px-3">
                                    <div class="flex items-center">
                                        <div class="bg-red-600 text-white p-2 rounded-full mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">Customer Service Representative</p>
                                            <p class="text-sm text-gray-500">March 25, 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full inline-block font-medium">
                                            Waiting
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="bg-red-100 text-red-600 px-3 py-1 rounded-full inline-block font-medium">
                                        Rejected
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-4 px-3">
                                    <div class="flex items-center">
                                        <div class="bg-red-600 text-white p-2 rounded-full mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">Customer Service Representative</p>
                                            <p class="text-sm text-gray-500">March 25, 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full inline-block font-medium">
                                        Waiting
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4 px-3">
                                    <div class="flex items-center">
                                        <div class="bg-red-600 text-white p-2 rounded-full mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">Customer Service Representative</p>
                                            <p class="text-sm text-gray-500">March 25, 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="flex justify-center">
                                        <div class="bg-green-500 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center">
                                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full inline-block font-medium">
                                        Hired
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
