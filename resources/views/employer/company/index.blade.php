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

            @if(session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

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

                <!-- Received Invitations Section -->
                @if(isset($receivedInvitations) && $receivedInvitations->count() > 0)
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-800">Company Invitations</h2>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $receivedInvitations->count() }}</span>
                    </div>

                    <p class="mb-4 text-gray-600">You have pending invitations to join the following companies:</p>

                    <div class="space-y-4">
                        @foreach($receivedInvitations as $invitation)
                        <div class="p-4 border rounded-md bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $invitation->company->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">Invited by: {{ $invitation->creator->name }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Sent on: {{ $invitation->created_at->format('M d, Y') }}</p>
                                </div>
                                <a href="{{ route('employer.company.invite.accept', $invitation->token) }}"
                                   class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Accept Invitation
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @endif

                @if($company)
                <!-- Company Members Section -->
                <div class="p-6 border-b border-gray-100">
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

                <!-- Pending Invitations Section -->
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-gray-800">Pending Invitations</h2>
                        @if($pendingInvitations->count() > 0)
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $pendingInvitations->count() }}</span>
                        @endif
                    </div>

                    @if($pendingInvitations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date Sent
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pendingInvitations as $invitation)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $invitation->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $invitation->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $invitation->created_at->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('employer.company.invite.cancel', $invitation->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Cancel</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">No pending invitations.</p>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
