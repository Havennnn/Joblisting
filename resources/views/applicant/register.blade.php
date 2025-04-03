@extends('layouts.app')

@section('title', 'Job Seeker Registration')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-medium text-gray-900 mb-8">Create an account before applying</h1>

    <div class="max-w-md w-full bg-white rounded-lg border border-gray-200 shadow-sm p-8">
        <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">
            Jobseeker Registration
        </h2>

        <form class="space-y-6" action="{{ route('applicant.register.post') }}" method="POST">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Full Name
                </label>
                <input id="name" name="name" type="text" autocomplete="name" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#2271b1] focus:border-[#2271b1] sm:text-sm"
                    value="{{ old('name') }}">
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email address
                </label>
                <input id="email" name="email" type="email" autocomplete="email" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#2271b1] focus:border-[#2271b1] sm:text-sm"
                    value="{{ old('email') }}">
                @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <div class="relative">
                    <input id="password" name="password" type="password" autocomplete="new-password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#2271b1] focus:border-[#2271b1] sm:text-sm">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" id="togglePassword" class="text-gray-400 focus:outline-none">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
                @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Re-type Password
                </label>
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        autocomplete="new-password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#2271b1] focus:border-[#2271b1] sm:text-sm">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" id="toggleConfirmPassword" class="text-gray-400 focus:outline-none">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required
                    class="h-4 w-4 text-[#2271b1] focus:ring-[#2271b1] border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-xs text-gray-700">
                    By registering, I agree to the Terms and Conditions and confirm that the information I provide is accurate. I acknowledge that I may receive job-related updates.
                </label>
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4285F4] hover:bg-[#3367d6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4285F4]">
                    Register Account
                </button>
            </div>

            <div class="text-center text-sm">
                Already have an account? <a href="{{ route('applicant.login') }}" class="font-medium text-[#2271b1] hover:underline">Sign in</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            // Toggle type between password and text
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle icon between eye and eye-slash
            if (type === 'text') {
                this.innerHTML = `
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                `;
            } else {
                this.innerHTML = `
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                `;
            }
        });

        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const passwordConfirmation = document.getElementById('password_confirmation');

        toggleConfirmPassword.addEventListener('click', function() {
            // Toggle type between password and text
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);

            // Toggle icon between eye and eye-slash
            if (type === 'text') {
                this.innerHTML = `
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                `;
            } else {
                this.innerHTML = `
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                `;
            }
        });
    });
</script>
@endsection
