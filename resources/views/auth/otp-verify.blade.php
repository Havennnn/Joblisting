@extends('layouts.otp')

@section('content')
        <div class="flex justify-center items-center min-h-[70vh] px-4 py-10">
            <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
                <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Verify Your Email</h1>
                <p class="text-gray-600 text-center mb-6">Enter the OTP code sent to <strong class="font-medium">{{ $email }}</strong></p>

                @if (session('message'))
                    <div class="bg-blue-50 text-blue-700 p-4 rounded-md mb-6">
                        {{ session('message') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 rounded-md mb-6">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="bg-green-50 text-green-700 p-4 rounded-md mb-6">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

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
                            Verify OTP
                        </button>
                    </div>
                </form>

                <!-- Resend OTP Section with Timer -->
                <div class="mt-8 text-center">
                    <p id="timer-text" class="text-gray-600 mb-4">
                        You can request a new OTP in <span id="otp-timer" class="font-bold">30</span> seconds
                    </p>

                    <form method="POST" action="{{ route('otp.resend') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
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
