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
                    @if($company->employers->count() > 0)
                        <div class="space-y-3">
                            @foreach($company->employers as $member)
                                <div class="flex items-center justify-between p-3 border rounded-md">
                                    <div>
                                        <h4 class="font-medium">{{ $member->user->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $member->user->email }}</p>
                                    </div>
                                    @if($isOwner && $member->id !== Auth::user()->employer->id)
                                        <form action="{{ route('employer.company.kick-member', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this member from your company?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                Remove
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">You are currently the only member of this company.</p>
                    @endif
                </div>

                <!-- Company Job Posts Section -->
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Company Job Posts</h2>

                    @if($companyJobs && $companyJobs->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted By</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted Date</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($companyJobs as $job)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $job->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $job->employer->user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $job->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('employer.company.job-post.view', $job->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>

                                            @if($isOwner || Auth::user()->employer->id === $job->employer_id)
                                                <a href="{{ route('employer.company.job-post.edit', $job->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>

                                                <form method="POST" action="{{ route('employer.company.job-post.delete', $job->id) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this job post?')" class="text-red-600 hover:text-red-900">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $companyJobs->links() }}
                        </div>
                    @else
                        <p class="text-gray-600">No job posts have been created by members of this company yet.</p>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
