<nav class="w-full bg-white border-b border-gray-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('images/NextJob.svg') }}" alt="Logo" class="h-8 w-auto">
                </a>
            </div>

            <div class="hidden md:flex items-center justify-between flex-1 ml-8">
                <x-navigation.nav-links />

                <div class="flex items-center space-x-1">
                    <x-navigation.notifications />
                    <x-navigation.user />
                    <div class="ml-2">
                        <x-navigation.auth-buttons />
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
    @vite('resources/js/components/dropdownHandler.js')
@endpush
