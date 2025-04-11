@extends('layouts.app')

@section('title', 'Forgot Password - Employer')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[calc(100vh-200px)] bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">Reset Your Password</h2>
        <p class="text-center text-gray-600 mb-8">Enter your email address and we'll send you a one-time password to reset your password.</p>

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

        <form method="POST" action="{{ route('employer.password.email') }}">
            @csrf
            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-neksjob-pink focus:border-neksjob-pink" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-6">
                <button type="submit" class="w-full bg-neksjob-pink text-white py-2 px-4 rounded-md hover:bg-pink-600 transition duration-300">
                    Send Reset Link
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Remember your password? <a href="{{ route('employer.login') }}" class="text-neksjob-pink hover:underline">Sign in</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
