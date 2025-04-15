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

            <x-otp-input />

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
                Didn't receive the code?
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
                <span class="ml-2">(Wait <span id="otp-timer" class="font-bold">60</span>s)</span>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/pages/otpVerification.js')
@endpush

