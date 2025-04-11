@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-4">Change Email Address</h2>

            <div class="mb-6">
                <p class="text-gray-700">
                    To change your email address, please enter your new email below.
                    A verification code will be sent to this new email address to confirm it belongs to you.
                </p>
            </div>

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Email</label>
                <div class="flex items-center py-2 px-3 rounded-md bg-gray-100 text-gray-800">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <form method="POST" action="{{ route('settings.email.change') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="new_email" class="block text-sm font-medium text-gray-700">New Email Address</label>
                    <input
                        type="email"
                        id="new_email"
                        name="new_email"
                        value="{{ old('new_email') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        required
                    >
                    @error('new_email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <button
                        type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Send Verification Code
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('settings.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                    Back to Settings
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
