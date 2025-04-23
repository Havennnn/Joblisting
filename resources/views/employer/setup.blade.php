@extends('layouts.setup')

@section('title', 'Complete Your Profile')

@section('content')
<div class="min-h-screen bg-white-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Complete Your Profile</h1>
                <p class="mt-2 text-gray-600">Please provide your contact information to get started.</p>
            </div>

            <!-- Setup Form -->
            <div class="bg-white shadow sm:rounded-lg border border-gray-300">
                <div class="px-4 py-5 sm:p-6">
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('employer.setup') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Personal Contact Information</h2>
                            <hr class="border-t-2 border-gray-300 mb-4">
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $data['full_name'] ?? $user->name) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <div class="mt-1 block w-full px-3 py-2 sm:text-sm border border-gray-300 rounded-md bg-gray-50 text-gray-700">
                                    {{ old('email', $data['email'] ?? $user->email) }}
                                </div>
                                <input type="hidden" name="email" value="{{ old('email', $data['email'] ?? $user->email) }}">
                            </div>

                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $data['phone_number'] ?? '') }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="flex justify-between pt-6">
                            <a href="{{ route('employer.setup.skip') }}" class="text-sm text-blue-600 hover:text-blue-500">Skip for now</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Complete Setup
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
