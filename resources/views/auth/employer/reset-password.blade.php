@extends('layouts.app')

@section('title', 'Reset Password - Employer')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[calc(100vh-200px)] bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">Reset Your Password</h2>
        <p class="text-center text-gray-600 mb-8">Enter the one-time password (OTP) sent to your email and set your new password.</p>

        <!-- Status Message -->
        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('status') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update.otp', ['type' => 'employer']) }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-4">
                <label for="otp" class="block text-gray-700 text-sm font-medium mb-2">One-Time Password</label>
                <input type="text" id="otp" name="otp" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-neksjob-pink focus:border-neksjob-pink" required autofocus>
                <p class="text-sm text-gray-500 mt-1">Enter the 6-digit code sent to your email</p>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">New Password</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-neksjob-pink focus:border-neksjob-pink" required>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-neksjob-pink focus:border-neksjob-pink" required>
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full bg-neksjob-pink text-white py-2 px-4 rounded-md hover:bg-pink-600 transition duration-300">
                    Reset Password
                </button>
            </div>

            <div class="text-center text-sm text-gray-600">
                <p>
                    Didn't receive the OTP?
                    <form method="POST" action="{{ route('employer.password.email') }}" class="inline">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="text-neksjob-pink hover:underline">Resend</button>
                    </form>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
