<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Neksjob')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar">
        <a href="/">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            </div>
        </a>
        <div class="nav-con">
                <div class = "con-1">
                    <a href="#">Home </a>
                    <a href="#">Find jobs</a>
                </div>
                <div class = "con-2">
                    <a href="{{ route('login') }}" class="sign-in">Job Seeker Sign-In</a>
                    <text class="bar">|</text>
                    <a href="{{ route('employer-login') }}" class="emp">Employer Sign-In</a>
                </div>
            
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main">
        @yield('content')
    </main>

       <!-- Footer -->
       <div class="footer-cons">
<footer class="footer">
    <div class="footer-container">
        <!-- Left Side -->
        <div class="footer-left">
            <h2>NeksJob</h2>
            <p>2nd Floor Fuentes Bldg, Waling Waling St. Mla. East Road, San Isidro, Angono, Rizal</p>
            <p>neksjob.com</p>
            <p>Monday to Friday, 9:00 AM to 4:00 PM</p>

            <!-- Social Icons -->
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>

            </div>
            
            <p class="copyright">© 2025 Copyright: neksjobph</p>
        </div>

        <!-- Right Side -->
        <div class="footer-right">
            <div class="footer-column">
                <h4>About</h4>
                <a href="#">About neksjob</a>
                <a href="#">Data Privacy</a>
                <a href="#">FAQ</a>
            </div>
            <div class="footer-column">
                <h4>Jobseekers</h4>
                <a href="#">Sign-Up</a>
                <a href="#">Sign-In</a>
                <a href="#">Find a Job</a>
            </div>
            <div class="footer-column">
                <h4>Employers</h4>
                <a href="#">Sign-Up</a>
                <a href="#">Sign-In</a>
            </div>
        </div>
    </div>

    <!-- Bottom Links -->
    <div class="footer-bottom">
        <a href="#">Privacy Policy</a> |
        <a href="#">Terms and Conditions</a> |
        <a href="#">About Us</a>
    </div>
</footer>
</div>
</body>
</html>
