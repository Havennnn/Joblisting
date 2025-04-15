<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-6">Account Settings</h2>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-200 mb-6">
                <div class="flex -mb-px">
                    <button
                        wire:click="setTab('email')"
                        class="py-2 px-4 {{ $activeTab === 'email' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}"
                    >
                        Email Settings
                    </button>
                    <button
                        wire:click="setTab('password')"
                        class="ml-8 py-2 px-4 {{ $activeTab === 'password' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500 hover:text-gray-700' }}"
                    >
                        Password Settings
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            @if ($activeTab === 'email')
                @livewire('settings.email.change-email')
            @elseif ($activeTab === 'password')
                @livewire('settings.password.change-password')
            @endif
        </div>
    </div>
</div>
