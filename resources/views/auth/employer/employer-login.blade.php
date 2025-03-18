@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-content">
        <span class="login-title">Employer Login</span>

        {{-- <form action="{{ route('login') }}" method="POST">
            @csrf

            <label for="email">Email address</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <a href="{{ route('verification.show') }}" class="login-btn">Sign in</a>

            <div class="divider">
                <span>or Sign in with</span>
            </div>

            <button type="button" class="social-btn google-btn">
                <img src="{{ asset('images/google-icon.png') }}" alt="Google Logo"> Google
            </button>

            <button type="button" class="social-btn facebook-btn">
                <img src="{{ asset('images/facebook-icon.png') }}" alt="Facebook Logo"> Facebook
            </button>

            <p>Don’t have an account? <a href="{{ route('register') }}">Register</a></p>
        </form> --}}
        <div class="name-fields">
            <div>
                <span class="label">Email:</span>
                <input type="text" name="email" required class="reg-txtbox">
            </div>
        </div>
        <div class="email-fields">
            <div>
                <span class="label">Password:</span>
                <input type="password" name="password" required class="reg-txtbox">
            </div>
        </div>
        <button type="button" class="register-btn">Sign-In</button>
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
        <p>Don’t have an account? <a href="{{ route('register') }}">Register</a></p>
    </div>
</div>
@endsection