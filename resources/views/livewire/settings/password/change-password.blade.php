<div class="mb-6">
    <p class="text-gray-700 mb-4">Change your password. For security, you'll need to confirm your current password.</p>

    @if (session('passwordSuccess'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('passwordSuccess') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4">
        <div class="relative">
            <label for="currentPassword" class="block text-sm font-medium text-gray-700">Current Password</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input
                    type="password"
                    id="currentPassword"
                    wire:model="currentPassword"
                    class="password-toggle-field block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm pr-10"
                >
                <button
                    type="button"
                    class="password-toggle-btn absolute inset-y-0 right-0 flex items-center pr-3"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            @error('currentPassword') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="relative">
            <label for="newPassword" class="block text-sm font-medium text-gray-700">New Password</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input
                    type="password"
                    id="newPassword"
                    wire:model="newPassword"
                    class="password-toggle-field block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm pr-10"
                >
                <button
                    type="button"
                    class="password-toggle-btn absolute inset-y-0 right-0 flex items-center pr-3"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            @error('newPassword') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="relative">
            <label for="newPassword_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input
                    type="password"
                    id="newPassword_confirmation"
                    wire:model="newPassword_confirmation"
                    class="password-toggle-field block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm pr-10"
                >
                <button
                    type="button"
                    class="password-toggle-btn absolute inset-y-0 right-0 flex items-center pr-3"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
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

@push('scripts')
    @vite(['resources/js/pages/settings-password.js'])
@endpush
