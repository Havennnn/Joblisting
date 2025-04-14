@props([
    'menuClass' => 'hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50',
    'linkClass' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100'
])

<div id="dropdown-menu" class="{{ $menuClass }}" data-dropdown="user">
    <div class="py-1">
        @if (auth()->user()->isEmployer())
            <a href="{{ route('employer.dashboard') }}" class="{{ $linkClass }}">Dashboard</a>
            <a href="{{ route('employer.profile.index') }}" class="{{ $linkClass }}">Profile</a>
            <a href="{{ route('settings.index') }}" class="{{ $linkClass }}">Settings</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left {{ $linkClass }}">
                    Sign out
                </button>
            </form>
        @else
            <a href="{{ route('applicant.dashboard') }}" class="{{ $linkClass }}">Dashboard</a>
            <a href="{{ route('applicant.profile') }}" class="{{ $linkClass }}">Profile</a>
            <a href="{{ route('settings.index') }}" class="{{ $linkClass }}">Settings</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left {{ $linkClass }}">
                    Sign out
                </button>
            </form>
        @endif

        {{ $slot ?? '' }}
    </div>
</div>
