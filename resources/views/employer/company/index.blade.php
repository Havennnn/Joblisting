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
                <p class="mt-1 text-gray-600">Manage your company or create a new one</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                @if($company)
                <!-- Company Information -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-medium text-gray-800">Your Company</h2>
                        <a href="{{ url('/employer/company/invite') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Invite Members
                        </a>
                    </div>

                    <div class="flex items-start">
                        <div class="mr-6">
                            @if($company->logo_path)
                                <img src="{{ Storage::url($company->logo_path) }}" alt="{{ $company->name }}" class="w-24 h-24 object-cover rounded-md">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $company->name }}</h3>
                            <p class="text-gray-600 mt-1">{{ $company->industry }}</p>
                            <div class="mt-2 text-sm text-gray-600">
                                <p class="mt-1"><strong>Location:</strong> {{ $company->location }}</p>
                                <p class="mt-1"><strong>Size:</strong> {{ $company->size }}</p>
                                @if($company->website)
                                    <p class="mt-1"><strong>Website:</strong> <a href="{{ $company->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $company->website }}</a></p>
                                @endif
                            </div>
                            <div class="mt-4">
                                <p class="text-gray-700">{{ Str::limit($company->description, 250) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <!-- Create Company Section -->
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Create a New Company</h2>
                    <p class="mb-4 text-gray-600">You haven't created or joined a company yet. Create a new company profile to get started.</p>
                    <a href="{{ route('employer.company.create') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Create Company
                    </a>
                </div>
                @endif

                @if($company)
                <!-- Company Members Section -->
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Company Members</h2>
                    @if($company->employers->count() > 1)
                        <div class="space-y-3">
                            @foreach($company->employers as $member)
                                <div class="flex items-center justify-between p-3 border rounded-md">
                                    <div>
                                        <h4 class="font-medium">{{ $member->user->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $member->user->email }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">You are currently the only member of this company.</p>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
