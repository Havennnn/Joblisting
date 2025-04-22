@extends('layouts.app')

@section('title', 'Forgot Password - Applicant')

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
                Enter your email address and we'll send you a one-time password to reset your password
            </p>
        </div>

        <div class="mt-8">
            <div class="bg-white py-8 px-4 shadow-lg sm:px-10">
                @if (session('status'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('applicant.password.email') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email"
                                class="appearance-none block w-full pl-10 px-3 py-2 border border-gray-300 shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#2563EB] focus:border-[#2563EB] sm:text-sm transition-colors"
                                placeholder="Enter your email address" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium text-white bg-[#2563EB] hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2563EB] transition-colors">
                            Send Reset Link
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    <p>
                        Remember your password?
                        <a href="{{ route('applicant.login') }}" class="text-[#2563EB] hover:text-blue-700 font-medium transition-colors">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
