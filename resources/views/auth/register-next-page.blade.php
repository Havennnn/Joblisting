@extends('layouts.app')

@section('content')

<div class="register-container">

    <div class="register-content">
        <span class="register-title">Applicant Registration</span>
        <div class="name-fields">
            <div>
                <span class="label">Contact Number:</span>
                <input type="text" name="cnum" required class="reg-txtbox">
            </div>
        </div>
        <div class="email-fields">
            <div>
                <span class="label">Enter Password:</span>
                <input type="password" name="email" required class="reg-txtbox">
            </div>
        </div>
        <div class="email-fields">
            <div>
                <span class="label">Re-Enter Password:</span>
                <input type="password" name="email" required class="reg-txtbox">
            </div>
        </div>
        
        <button type="button" class="register-btn">Register</button>


        <div class="divider">
            <span>or Register with</span>
        </div>
        <div class="social-fields">
            <button type="button" class="social-btn google-btn">
                <img src="{{ asset('images/google-icon.png') }}" alt="Google Logo"> Google
            </button>
            <button type="button" class="social-btn facebook-btn">
                <img src="{{ asset('images/facebook-icon.png') }}" alt="Facebook Logo"> Facebook
            </button>
        </div>
        <p>Already have an account? <a href="{{ route('register') }}">Sign In</a></p>
    </div>
</div>
@endsection