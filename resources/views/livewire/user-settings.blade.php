<div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-6">Account Settings</h2>

            <!-- Tabs -->
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

            <!-- Email Settings Tab -->
            <div x-show="$wire.activeTab === 'email'" class="{{ $activeTab === 'email' ? '' : 'hidden' }}">
                <div class="mb-6">
                    <p class="text-gray-700 mb-4">Update your email address. For security, you'll need to confirm your current password.</p>

                    @if (session('emailSuccess'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('emailSuccess') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Email</label>
                        <div class="flex items-center py-2 px-3 rounded-md bg-gray-100 text-gray-800">
                            {{ $currentEmail }}
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="newEmail" class="block text-sm font-medium text-gray-700">New Email Address</label>
                            <input
                                type="email"
                                id="newEmail"
                                wire:model.live="newEmail"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                            @error('newEmail') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="currentPassword" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input
                                type="password"
                                id="currentPassword"
                                wire:model.live="currentPassword"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                            @error('currentPassword') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-3">
                            <button
                                wire:click="updateEmail"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Update Email
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Settings Tab -->
            <div x-show="$wire.activeTab === 'password'" class="{{ $activeTab === 'password' ? '' : 'hidden' }}">
                <div class="mb-6">
                    <p class="text-gray-700 mb-4">Change your password. For security, you'll need to confirm your current password.</p>

                    @if (session('passwordSuccess'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('passwordSuccess') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label for="currentPasswordForPwd" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input
                                type="password"
                                id="currentPasswordForPwd"
                                wire:model.live="currentPassword"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                            @error('currentPassword') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="newPassword" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input
                                type="password"
                                id="newPassword"
                                wire:model.live="newPassword"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                            @error('newPassword') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="newPasswordConfirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input
                                type="password"
                                id="newPasswordConfirmation"
                                wire:model.live="newPassword_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            >
                        </div>

                        <div class="pt-3">
                            <button
                                wire:click="updatePassword"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Update Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
