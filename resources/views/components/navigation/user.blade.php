@props([
    'buttonClass' => 'inline-flex items-center justify-center w-full px-3 py-2 text-gray-900 focus:outline-none text-md font-light',
    'menuClass' => 'hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50',
    'linkClass' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100'
])

@auth
    <div class="relative inline-block text-left" id="userDropdown">
        <button type="button" class="{{ $buttonClass }}" data-dropdown-toggle="dropdown-menu">
            {{ auth()->user()->name }}
            <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <x-navigation.dropdowns.user-menu
            :menuClass="$menuClass"
            :linkClass="$linkClass">
            {{ $slot ?? '' }}
        </x-navigation.dropdowns.user-menu>
    </div>
@endauth
