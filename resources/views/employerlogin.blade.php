@extends('layouts.employer.guest')

@section('content')
    <div class="card p-4 shadow-lg" style="width: 350px;">
        <h3 class="text-center mb-3">Employer Login</h3>

        <!-- Laravel Form -->
        <form method="POST" action="{{ route('employer.login') }}">
            @csrf  <!-- CSRF Token for security -->

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <!-- Forgot Password & Login Button -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="text-decoration-none">Forgot Password?</a>
                <button type="submit" class="btn btn-primary">Log In</button>
            </div>
        </form>
    </div>
@endsection

@push('pageStyles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('pageScripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
