@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-content">
        <span class="login-title">Employer Login</span>

        <form action="{{ route('employer.login.post') }}" method="POST">
            @csrf
            <div class="name-fields">
                <div>
                    <span class="label">Email:</span>
                    <input type="email" name="email" required class="reg-txtbox">
                    @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="email-fields">
                <div>
                    <span class="label">Password:</span>
                    <input type="password" name="password" required class="reg-txtbox">
                    @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="register-btn">Sign-In</button>
            <div class="divider">
                <span>or Sign-In with</span>
            </div>
            <div class="social-fields">
                <button type="button" class="social-btn google-btn">
                    <img src="{{ asset('images/google-icon.png') }}" alt="Google Logo"> Google
                </button>
                <button type="button" class="social-btn facebook-btn">
                    <img src="{{ asset('images/facebook-icon.png') }}" alt="Facebook Logo"> Facebook
                </button>
            </div>
            <p>Don't have an account? <a href="{{ route('employer.register') }}">Register</a></p>
        </form>
    </div>
</div>
@endsection
