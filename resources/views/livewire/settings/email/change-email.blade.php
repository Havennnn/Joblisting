<div class="mb-6">
    @if (!$isVerifyingEmail)
        <p class="text-gray-700 mb-4">Update your email address. A verification link will be sent to the new address.</p>
    @endif

    <!-- Success Messages -->
    @if (session('emailSuccess'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('emailSuccess') }}
        </div>
    @endif
    @if (session('emailVerified'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('emailVerified') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Current Email Section - only show when not in verification mode -->
    @if (!$isVerifyingEmail)
        <div class="mb-8 bg-gray-50 p-4 rounded-md">
            <h3 class="text-md font-medium text-gray-900 mb-2">Current Email</h3>
            <div class="flex items-center">
                <span class="text-gray-700">{{ $currentEmail }}</span>
                @if (!auth()->user()->hasVerifiedEmail())
                    <span class="ml-2 px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Unverified</span>
                @else
                    <span class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Verified</span>
                @endif
            </div>

            @if (!auth()->user()->hasVerifiedEmail())
                <div class="mt-3">
                    <button
                        wire:click="resendVerificationEmail"
                        wire:loading.attr="disabled"
                        class="text-sm text-blue-600 hover:text-blue-800 flex items-center"
                    >
                        <span wire:loading.remove wire:target="resendVerificationEmail">Resend verification email</span>
                        <span wire:loading wire:target="resendVerificationEmail">Sending...</span>
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- Change Email Form -->
    <div class="space-y-4">
        @if (!$isChangingEmail && !$isVerifyingEmail)
            <button
                wire:click="startEmailChange"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Change Email
            </button>
        @endif

        @if ($isChangingEmail && !$isVerifyingEmail)
            <div>
                <label for="newEmail" class="block text-sm font-medium text-gray-700">New Email Address</label>
                <div class="mt-1">
                    <input
                        type="email"
                        id="newEmail"
                        wire:model.defer="newEmail"
                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    />
                    @if($errors->has('newEmail'))
                        <span class="text-red-600 text-sm">{{ $errors->first('newEmail') }}</span>
                    @endif
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Current Password</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input
                        type="password"
                        id="password"
                        wire:model.defer="password"
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
                @if($errors->has('password'))
                    <span class="text-red-600 text-sm">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="flex items-center space-x-3 pt-3">
                <button
                    wire:click="initiateEmailChange"
                    wire:loading.attr="disabled"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <span wire:loading.remove wire:target="initiateEmailChange">Update Email</span>
                    <span wire:loading wire:target="initiateEmailChange">Updating...</span>
                </button>
                <button
                    wire:click="cancelEmailChange"
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Cancel
                </button>
            </div>
        @endif

        <!-- Verification Form with OTP -->
        @if ($isVerifyingEmail)
            <div class="bg-blue-50 p-4 rounded-md mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            A verification code has been sent to <strong>{{ $newEmail }}</strong>. Please enter the code below to complete your email change.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <label for="otp" class="block text-sm font-medium text-gray-700">Verification Code</label>
                <div class="mt-1">
                    <x-otp-input wire:model="otp" name="otp" digits="6"></x-otp-input>
                    @if($errors->has('otp'))
                        <span class="text-red-600 text-sm">{{ $errors->first('otp') }}</span>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <div>
                    @if($canResendOtp)
                        <button
                            wire:click="resendOtp"
                            wire:loading.attr="disabled"
                            type="button"
                            id="resend-otp-btn"
                            class="text-sm text-blue-600 hover:text-blue-800"
                        >
                            <span wire:loading.remove wire:target="resendOtp">Resend verification code</span>
                            <span wire:loading wire:target="resendOtp">Sending...</span>
                        </button>
                    @else
                        <span class="text-sm text-gray-500">
                            Resend code in <span id="otp-timer">{{ $otpResendTimer }}</span> seconds <span id="timer-text"></span>
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex items-center space-x-3 pt-3">
                <button
                    wire:click="verifyEmailChange"
                    wire:loading.attr="disabled"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <span wire:loading.remove wire:target="verifyEmailChange">Verify</span>
                    <span wire:loading wire:target="verifyEmailChange">Verifying...</span>
                </button>
                <button
                    wire:click="cancelEmailChange"
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Cancel
                </button>
            </div>
        @endif
    </div>
</div>


<!-- OTP Handler logic -->
@push('scripts')
    @vite(['resources/js/pages/settings-email.js'])
@endpush
