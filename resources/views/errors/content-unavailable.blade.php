@extends('layouts.app')

@section('title', 'Content Unavailable')

@section('content')
<div class="bg-white min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-4 text-center">
        <div>
            <div class="flex justify-center">
                <img class="h-16 w-auto" src="{{ asset('images/logo.svg') }}" alt="NeksJob Logo">
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Content Unavailable
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                You need to be logged in to access this content.
            </p>
        </div>

        <div class="mt-8">
            <h4 class="text-lg font-medium text-gray-700 mb-4">Choose your account type</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Job Seeker Options -->
                <div class="border border-gray-200 rounded-lg p-4 bg-white shadow-sm hover:shadow-md transition-shadow">
                    <h5 class="font-semibold text-base text-gray-800 mb-3">Job Seeker</h5>
                    <div class="space-y-3">
                        <a href="{{ route('applicant.login') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-neksjob-blue hover:bg-blue-700">
                            Sign In
                        </a>
                        <a href="{{ route('applicant.register') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-neksjob-blue bg-white hover:bg-gray-50">
                            Create Account
                        </a>
                    </div>
                </div>

                <!-- Employer Options -->
                <div class="border border-gray-200 rounded-lg p-4 bg-white shadow-sm hover:shadow-md transition-shadow">
                    <h5 class="font-semibold text-base text-gray-800 mb-3">Employer</h5>
                    <div class="space-y-3">
                        <a href="{{ route('employer.login') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-neksjob-pink hover:bg-pink-700">
                            Sign In
                        </a>
                        <a href="{{ route('employer.register') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-neksjob-pink bg-white hover:bg-gray-50">
                            Create Account
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('landing') }}" class="text-sm text-gray-600 hover:text-neksjob-blue">
                Return to Homepage
            </a>
        </div>
    </div>
</div>
@endsection
