@props([
    'menuClass' => 'hidden absolute right-0 mt-3 w-80 shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden',
    'headerClass' => 'bg-gray-50 px-4 py-2 border-b border-gray-200',
    'markAllReadClass' => 'text-xs text-blue-600 hover:text-blue-800',
    'viewAllClass' => 'block w-full text-center text-sm font-medium text-blue-600 hover:text-blue-800 py-1',
    'type' => 'applicant'
])

@php
    $menuId = $type === 'employer' ? 'employer-notification-menu' : 'notification-menu';
    $viewAllRoute = $type === 'employer' ? 'employer.notifications.index' : 'applicant.notifications';
    $markAllReadRoute = $type === 'employer' ? 'employer.notifications.read-all' : 'applicant.notifications.read-all';
@endphp

<div id="{{ $menuId }}" class="{{ $menuClass }}" data-dropdown="{{ $type }}-notifications">
    <div class="{{ $headerClass }}">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-medium text-gray-700">Notifications</h3>
            @if (auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route($markAllReadRoute) }}"
                    method="POST" class="inline">
                    @csrf
                    <button type="submit" class="{{ $markAllReadClass }}">
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="max-h-60 overflow-y-auto">
        {{ $slot ?? '' }}

        @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
            <div
                class="p-3 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50 border-b border-gray-100">
                <div class="flex items-start">
                    @if (!$notification->read_at)
                        <span
                            class="flex-shrink-0 inline-block w-2 h-2 bg-blue-600 rounded-full mt-2 mr-2"></span>
                    @endif
                    <div class="ml-2 w-full">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center">
                                @if(str_contains($notification->type, 'Application'))
                                    <svg class="h-5 w-5 text-indigo-500 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                                        <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V8.414a2 2 0 00-.293-1.037l-4.586-4.586A2 2 0 0010.586 2H4zm3 5a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h4a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                @elseif(str_contains($notification->type, 'Invitation'))
                                    <svg class="h-5 w-5 text-green-500 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-blue-500 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                    </svg>
                                @endif
                                <p class="text-sm font-medium text-gray-900">
                                    @if($type === 'applicant' && $notification->type === 'App\\Notifications\\ApplicationStatusChanged')
                                        Application Status Update
                                    @elseif($type === 'employer' && $notification->type === 'App\\Notifications\\NewJobApplication')
                                        New Application
                                    @elseif($type === 'employer' && ($notification->type === 'App\\Notifications\\Company\\InvitationSent' || $notification->type === 'App\\Notifications\\CompanyInvitationNotification'))
                                        Company Invitation
                                    @elseif($type === 'employer' && ($notification->type === 'App\\Notifications\\Company\\InvitationAccepted' || $notification->type === 'App\\Notifications\\InvitationAccepted'))
                                        Invitation Accepted
                                    @else
                                        New Notification
                                    @endif
                                </p>
                            </div>
                            <span
                                class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">
                            @if($type === 'applicant' && $notification->type === 'App\\Notifications\\ApplicationStatusChanged')
                                Your application for the position of "<strong>{{ $notification->data['job_title'] }}</strong>" at {{ $notification->data['employer_name'] }} has been updated to <strong>{{ ucfirst($notification->data['status']) }}</strong>.
                            @elseif($type === 'employer' && $notification->type === 'App\\Notifications\\NewJobApplication')
                                <strong>{{ $notification->data['applicant_name'] }}</strong> has applied for the position of "<strong>{{ $notification->data['job_title'] }}</strong>".
                            @elseif($type === 'employer' && ($notification->type === 'App\\Notifications\\Company\\InvitationSent' || $notification->type === 'App\\Notifications\\CompanyInvitationNotification'))
                                You have been invited to join <strong>{{ $notification->data['company_name'] }}</strong> by {{ $notification->data['sender_name'] }}.
                            @elseif($type === 'employer' && ($notification->type === 'App\\Notifications\\Company\\InvitationAccepted' || $notification->type === 'App\\Notifications\\InvitationAccepted'))
                                <strong>{{ $notification->data['acceptor_name'] }}</strong> has accepted your invitation to join <strong>{{ $notification->data['company_name'] }}</strong>.
                            @else
                                You have a new notification
                            @endif
                        </p>
                        <div class="mt-1 flex justify-between items-center">
                            @if($type === 'applicant')
                                <a href="{{ route('applicant.applications') }}"
                                    class="text-xs text-blue-600 hover:text-blue-800">
                                    View details
                                </a>
                            @elseif($type === 'employer' && $notification->type === 'App\\Notifications\\NewJobApplication')
                                <a href="{{ route('employer.applications.show', $notification->data['application_id']) }}"
                                    class="text-xs text-blue-600 hover:text-blue-800">
                                    View details
                                </a>
                            @else
                                <span></span>
                            @endif

                            @if(!$notification->read_at)
                                <form
                                    action="{{ route($type.'.notifications.read', $notification->id) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="text-xs text-gray-500 hover:text-gray-700">
                                        Mark as read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-4 px-3 text-center text-sm text-gray-500">
                No notifications yet
            </div>
        @endforelse
    </div>

    <div class="{{ $headerClass }} border-t border-gray-200">
        <a href="{{ route($viewAllRoute) }}" class="{{ $viewAllClass }}">
            View all notifications
        </a>
    </div>
</div>
