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
                            <p class="text-sm font-medium text-gray-900">
                                @if ($type === 'applicant' && $notification->type === 'App\\Notifications\\ApplicationStatusChanged')
                                    {{ ucfirst($notification->data['status']) }}
                                @elseif ($type === 'employer' && $notification->type === 'App\\Notifications\\NewJobApplication')
                                    New Application
                                @else
                                    New notification
                                @endif
                            </p>
                            <span
                                class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">
                            @if ($type === 'applicant' && $notification->type === 'App\\Notifications\\ApplicationStatusChanged')
                                Application for {{ $notification->data['job_title'] }}
                            @elseif ($type === 'employer' && $notification->type === 'App\\Notifications\\NewJobApplication')
                                {{ $notification->data['applicant_name'] }} applied for
                                {{ $notification->data['job_title'] }}
                            @else
                                You have a new notification
                            @endif
                        </p>
                        <div class="mt-1 flex justify-between items-center">
                            @if ($type === 'applicant')
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

                            @if (!$notification->read_at)
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
