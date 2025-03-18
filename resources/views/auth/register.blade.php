@extends('layouts.app')

@section('content')
<div class="register-container">

    <div class="register-content">
        <span class="register-title">Applicant Registration</span>

        <div class="name-fields">
            <div>
                <span class="label">First Name:</span>
                <input type="text" name="fname" required class="reg-txtbox">
            </div>
            <div>
                <span class="label">Last Name:</span>
                <input type="text" name="lname" required class="reg-txtbox">
            </div>
        </div>
        <div class="email-fields">
            <div>
                <span class="label">Email Address:</span>
                <input type="text" name="email" required class="reg-txtbox">
            </div>
        </div>
        <button type="button" class="verify-btn">Send Verification Code</button>
        <input type="text" name="otp" required class="reg-txtbox" placeholder="Enter Verification Code">
        <a href="{{ route('register-next-page') }}" class="next-page">Next>></a>

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
        <p>Already have an account? <a href="{{ route('login') }}">Sign-In</a></p>
    </div>
</div>
@endsection