@extends('layouts.setup')

@section('content')
<div class="flex justify-center items-center min-h-screen px-4 py-10">
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
            <input type="hidden" name="otp" id="otp-hidden">

            <div class="flex justify-center gap-2">
                @for ($i = 0; $i < 6; $i++)
                    <input
                        type="text"
                        maxlength="1"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        class="otp-input w-12 h-12 text-center text-xl border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                @endfor
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

        <div class="mt-8 text-center text-sm text-gray-600">
            <p>
                Didn’t receive the code?
                <form id="resend-form" method="POST" action="{{ route('otp.resend') }}" class="inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button
                        type="submit"
                        id="resend-otp-btn"
                        class="text-indigo-600 hover:underline disabled:text-gray-400 disabled:cursor-not-allowed"
                        disabled
                    >
                        Resend OTP
                    </button>
                </form>
                <span class="ml-2">(Wait <span id="otp-timer" class="font-bold">30</span>s)</span>
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.otp-input');
    const hiddenOtp = document.getElementById('otp-hidden');
    const resendBtn = document.getElementById('resend-otp-btn');
    const timerSpan = document.getElementById('otp-timer');

    // Timer setup
    let timeLeft = {{ session('otp_timer', 60) }};
    timerSpan.textContent = timeLeft;

    const countdown = setInterval(() => {
        timeLeft--;
        timerSpan.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            resendBtn.disabled = false;
            resendBtn.classList.remove('disabled:text-gray-400', 'disabled:cursor-not-allowed');
            resendBtn.classList.add('text-indigo-600', 'hover:underline');
            document.querySelector('.ml-2').textContent = ''; // Remove timer text
        }
    }, 1000);

    // OTP behavior: auto-fill & move
    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            const value = e.target.value;
            if (value.length > 1) {
                const digits = value.slice(0, 6).split('');
                digits.forEach((digit, i) => {
                    if (inputs[i]) inputs[i].value = digit;
                });
                if (inputs[5]) inputs[5].focus();
            } else if (value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            updateHiddenOTP();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            if (pasted.length === 6) {
                pasted.split('').forEach((digit, i) => {
                    if (inputs[i]) inputs[i].value = digit;
                });
                if (inputs[5]) inputs[5].focus();
                updateHiddenOTP();
            }
        });
    });

    function updateHiddenOTP() {
        hiddenOtp.value = Array.from(inputs).map(input => input.value).join('');
    }

    // Prevent form resubmission on refresh
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
});
</script>
@endsection

