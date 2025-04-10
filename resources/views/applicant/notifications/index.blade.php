@extends('layouts.applicant')

@section('title', 'My Notifications')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Notifications</h1>
            @if(count($notifications) > 0 && auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('applicant.notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Mark All as Read
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if(count($notifications) > 0)
                    <div class="space-y-4">
                        @foreach($notifications as $notification)
                            <div class="p-4 rounded-lg border {{ $notification->read_at ? 'bg-white border-gray-200' : 'bg-blue-50 border-blue-200' }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            @if(!$notification->read_at)
                                                <span class="inline-block w-2 h-2 bg-blue-600 rounded-full mr-2" aria-hidden="true"></span>
                                            @endif
                                            <h3 class="text-md font-medium text-gray-900">
                                                @if($notification->type === 'App\\Notifications\\ApplicationStatusChanged')
                                                    Application Status Update: {{ ucfirst($notification->data['status']) }}
                                                @else
                                                    New Notification
                                                @endif
                                            </h3>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-700">
                                            @if($notification->type === 'App\\Notifications\\ApplicationStatusChanged')
                                                <p>Your application for the position of "<strong>{{ $notification->data['job_title'] }}</strong>" at {{ $notification->data['employer_name'] }} has been updated to <strong>{{ ucfirst($notification->data['status']) }}</strong>.</p>
                                                <div class="mt-2">
                                                    <a href="{{ route('applicant.applications') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                                        View application details
                                                    </a>
                                                </div>
                                            @else
                                                <p>You have a new notification.</p>
                                            @endif
                                        </div>
                                        <div class="mt-2 text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if(!$notification->read_at)
                                            <form action="{{ route('applicant.notifications.read', $notification->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">
                                                    Mark as read
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('applicant.notifications.delete', $notification->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-10">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                        <p class="mt-1 text-sm text-gray-500">You don't have any notifications yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
