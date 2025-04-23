@extends('layouts.employer')

@section('title', 'Company Management - Neksjob')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-employer.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="max-w-5xl mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Company Management</h1>
                <p class="mt-1 text-gray-600">Search, create, or join a company</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Search Company Section -->
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Search for a Company</h2>
                    <div class="flex space-x-3">
                        <div class="flex-1">
                            <input type="text" placeholder="Enter company name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Search
                        </button>
                    </div>
                    <div class="mt-4 text-sm text-gray-500">
                        <p>Search results will appear here.</p>
                    </div>
                </div>

                <!-- Create Company Section -->
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Create a New Company</h2>
                    <p class="mb-4 text-gray-600">If your company doesn't exist in our database, you can create a new company profile.</p>
                    <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Create Company
                    </button>
                </div>

                <!-- Join Company Section -->
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Join a Company</h2>
                    <p class="mb-4 text-gray-600">Join an existing company by requesting access from a company administrator.</p>
                    <div class="text-sm text-gray-500">
                        <p>Company join requests will appear here after searching for a company.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
