@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-4">Verify Your New Email Address</h2>

            <div class="mb-6">
                <p class="text-gray-700">
                    We sent a verification code to <span class="font-medium">{{ $email }}</span>.
                    Please enter the 6-digit code below to verify your new email address.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('settings.email.verify.submit') }}" class="space-y-6">
                @csrf
                <div>
                    <div class="flex justify-center">
                        <input
                            type="text"
                            name="otp"
                            placeholder="Enter 6-digit OTP"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg tracking-widest"
                            required
                            autofocus
                            maxlength="6"
                            pattern="[0-9]{6}"
                        >
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                    >
                        Verify Email
                    </button>
                </div>
            </form>

            <!-- Resend OTP Section with Timer -->
            <div class="mt-8 text-center">
                <p id="timer-text" class="text-gray-600 mb-4">
                    You can request a new OTP in <span id="otp-timer" class="font-bold">60</span> seconds
                </p>

                <form method="POST" action="{{ route('settings.email.change') }}">
                    @csrf
                    <input type="hidden" name="new_email" value="{{ $email }}">
                    <button
                        type="submit"
                        id="resend-otp-btn"
                        disabled
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-500 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Resend OTP
                    </button>
                </form>
            </div>

            <!-- Cancel button -->
            <div class="mt-4 text-center">
                <a href="{{ route('settings.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    Cancel email change
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get elements
        const timerElement = document.getElementById('otp-timer');
        const timerTextElement = document.getElementById('timer-text');
        const resendButton = document.getElementById('resend-otp-btn');

        // Set initial time (in seconds)
        let timeLeft = {{ session('otp_timer', 60) }};

        // Update timer text initially
        timerElement.textContent = timeLeft;

        // Start countdown
        const countdownInterval = setInterval(function() {
            timeLeft -= 1;

            // Update timer display
            timerElement.textContent = timeLeft;

            // Check if timer is done
            if (timeLeft <= 0) {
                // Stop the interval
                clearInterval(countdownInterval);

                // Update text and enable button
                timerTextElement.textContent = 'You can now request a new OTP code';
                resendButton.disabled = false;
                resendButton.classList.remove('bg-gray-500', 'hover:bg-gray-600');
                resendButton.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
            }
        }, 1000);

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    });
</script>
@endsection
