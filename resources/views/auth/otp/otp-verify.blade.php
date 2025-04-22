@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="min-h-screen bg-[#EBF5FF] relative flex justify-center py-24 px-4">
    <div class="absolute top-0 right-0 bottom-0 left-0 overflow-hidden z-0 pointer-events-none">
        <svg class="absolute top-0 right-0 h-full w-full text-[#C7E1FF] opacity-80" xmlns="http://www.w3.org/2000/svg">
            <line x1="30%" y1="0" x2="10%" y2="100%" stroke="currentColor" stroke-width="2" />
            <line x1="50%" y1="0" x2="30%" y2="100%" stroke="currentColor" stroke-width="2" />
            <line x1="70%" y1="0" x2="50%" y2="100%" stroke="currentColor" stroke-width="2" />
            <line x1="90%" y1="0" x2="70%" y2="100%" stroke="currentColor" stroke-width="2" />
        </svg>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-[#2563EB]">
                Verify Your Email
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter the OTP code sent to <span class="font-medium">{{ $email }}</span>
            </p>
        </div>

        <div class="mt-8">
            <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
                @if (session('message'))
                    <div class="mb-4 bg-blue-50 border-l-4 border-[#2563EB] text-blue-700 p-4 rounded-md">
                        {{ session('message') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md">
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
                                class="otp-input w-12 h-14 text-center text-xl border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#2563EB] focus:border-[#2563EB] shadow-sm transition-colors"
                                required
                            >
                        @endfor
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded shadow-sm text-sm font-medium text-white bg-[#2563EB] hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2563EB] transition-colors"
                        >
                            Verify OTP
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    <p>
                        Didn't receive the code?
                        <form id="resend-form" method="POST" action="{{ route('otp.resend') }}" class="inline">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <button
                                type="submit"
                                id="resend-otp-btn"
                                class="text-[#2563EB] hover:text-blue-700 font-medium disabled:text-gray-400 disabled:cursor-not-allowed transition-colors"
                                disabled
                            >
                                Resend OTP
                            </button>
                        </form>
                        <span class="ml-2">(Wait <span id="otp-timer" class="font-bold">{{ session('otp_timer', 30) }}</span>s)</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/pages/otpVerification.js')
@endpush
