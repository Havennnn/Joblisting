@extends('layouts.app')

@section('title', 'Employer Registration')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-medium text-gray-900 mb-8">Create an account to post jobs</h1>

    <div class="max-w-md w-full bg-white rounded-lg border border-gray-200 shadow-sm p-8">
        <h2 class="text-2xl font-semibold text-center text-gray-900 mb-6">
            Employer Registration
        </h2>

        <form id="employer-registration-form" class="space-y-6" action="{{ route('employer.register.post') }}" method="POST">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Full Name
                </label>
                <input id="name" name="name" type="text" autocomplete="name" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#e83e8c] focus:border-[#e83e8c] sm:text-sm"
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
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#e83e8c] focus:border-[#e83e8c] sm:text-sm"
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
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#e83e8c] focus:border-[#e83e8c] sm:text-sm">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" id="togglePassword" class="text-gray-400 focus:outline-none">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="mt-2 text-xs">
                    <p class="mb-1">Password must contain:</p>
                    <ul class="space-y-1 pl-4">
                        <li id="length-validation" class="text-red-600">
                            <span class="inline-flex items-center">
                                <svg id="length-icon" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Minimum 8 characters
                            </span>
                        </li>
                        <li id="uppercase-validation" class="text-red-600">
                            <span class="inline-flex items-center">
                                <svg id="uppercase-icon" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                At least one uppercase letter
                            </span>
                        </li>
                        <li id="number-validation" class="text-red-600">
                            <span class="inline-flex items-center">
                                <svg id="number-icon" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                At least one number
                            </span>
                        </li>
                    </ul>
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
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#e83e8c] focus:border-[#e83e8c] sm:text-sm">
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
                    class="h-4 w-4 text-[#e83e8c] focus:ring-[#e83e8c] border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-xs text-gray-700">
                    By registering, I agree to the Terms and Conditions and confirm that the information I provide is accurate. I acknowledge that I may receive job-related updates.
                </label>
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#e83e8c] hover:bg-[#d6246f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e83e8c]">
                    Register
                </button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or continue with</span>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <a href="{{ route('facebook.login', ['user_type' => 'employer']) }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Continue with Facebook
                </a>

                <a href="{{ route('google.login', ['user_type' => 'employer']) }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                    </svg>
                    Continue with Google
                </a>
            </div>
        </div>

        <p class="mt-8 text-center text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('employer.login') }}" class="font-medium text-[#e83e8c] hover:text-[#d6246f]">
                Sign in
            </a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const lengthValidation = document.getElementById('length-validation');
        const uppercaseValidation = document.getElementById('uppercase-validation');
        const numberValidation = document.getElementById('number-validation');
        const lengthIcon = document.getElementById('length-icon');
        const uppercaseIcon = document.getElementById('uppercase-icon');
        const numberIcon = document.getElementById('number-icon');

        // Function to check password requirements and update UI
        function checkPassword() {
            const value = password.value;

            // Check minimum length
            if (value.length >= 8) {
                lengthValidation.classList.remove('text-red-600');
                lengthValidation.classList.add('text-green-600');
                lengthIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
            } else {
                lengthValidation.classList.remove('text-green-600');
                lengthValidation.classList.add('text-red-600');
                lengthIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
            }

            // Check for uppercase letter
            if (/[A-Z]/.test(value)) {
                uppercaseValidation.classList.remove('text-red-600');
                uppercaseValidation.classList.add('text-green-600');
                uppercaseIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
            } else {
                uppercaseValidation.classList.remove('text-green-600');
                uppercaseValidation.classList.add('text-red-600');
                uppercaseIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
            }

            // Check for number
            if (/[0-9]/.test(value)) {
                numberValidation.classList.remove('text-red-600');
                numberValidation.classList.add('text-green-600');
                numberIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
            } else {
                numberValidation.classList.remove('text-green-600');
                numberValidation.classList.add('text-red-600');
                numberIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
            }
        }

        // Check password on input
        password.addEventListener('input', checkPassword);

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
@endpush
