@extends('layouts.app')

@section('title', 'Reset Password - Applicant')

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
                Reset Your Password
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter the one-time password (OTP) sent to your email and set your new password
            </p>
        </div>

        <div class="mt-8">
            <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10">
                @if (session('status'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-md">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update.otp') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-1">
                            One-Time Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="otp" name="otp" type="text" required
                                class="appearance-none block w-full pl-10 px-3 py-2 border border-gray-300 rounded shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#2563EB] focus:border-[#2563EB] sm:text-sm transition-colors"
                                placeholder="Enter 6-digit code">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Enter the 6-digit code sent to your email</p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            New Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="appearance-none block w-full pl-10 px-3 py-2 border border-gray-300 rounded shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#2563EB] focus:border-[#2563EB] sm:text-sm transition-colors"
                                placeholder="Enter new password">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm New Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="appearance-none block w-full pl-10 px-3 py-2 border border-gray-300 rounded shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#2563EB] focus:border-[#2563EB] sm:text-sm transition-colors"
                                placeholder="Confirm new password">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded shadow-sm text-sm font-medium text-white bg-[#2563EB] hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2563EB] transition-colors">
                            Reset Password
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    <p>
                        Didn't receive the OTP?
                        <form method="POST" action="{{ route('applicant.password.email') }}" class="inline">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <button type="submit" class="text-[#2563EB] hover:text-blue-700 font-medium transition-colors">
                                Resend
                            </button>
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
