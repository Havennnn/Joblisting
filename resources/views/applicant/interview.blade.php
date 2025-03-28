<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Events</title>

         <!-- CSS -->
         <link rel="stylesheet" href="{{ asset('css/interview.css') }}">

         <!-- Audiowide/Neksjob font -->
         <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
 
         <!-- Inter Font Family -->
         <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
 
         <!-- Icons -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
         <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    </head>

    <body>
        <!-- Navbar -->
        <div class="navbar">
            <div class="left-nav">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" id="logo">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/jobs">Find Job</a>
            </div>
            
            <div class="right-nav">
                <a class="nav-link" href="#">Register</a>
                <p id="nav-divider">|</p>
                <a class="nav-link" id="emp" href="#">Employers</a>
            </div>
        </div>

        <div class="content">
            <!-- Hero Section -->
            <div class="hero">
                <div class="text">
                    <h2 id="get">Get</h2>
                    <h1 id="interviewed">Interviewed <span id="now">Now!</span></h1>
                </div>
            </div>

            <!-- Event List -->
            <div class="interview">
                <p id="discover">Discover amazing career opportunities and move forward in your path.</p>
                <div class="jobs-container">
                    @foreach ($jobs as $job)
                        <div class="job-card">
                            <div class="job-header">
                                <img src="{{ asset('images/logo2.png') }}" alt="Neksjob" class="job-logo">
                                <h3 class="job-title">{{ $job->title }}</h3>
                            </div>
                            <p class="job-location"><i class="fa-solid fa-map-marker-alt"></i>&nbsp;{{ $job->location }}</p>
                            <p class="job-salary"><i class="fa-solid fa-money-bill-wave"></i>&nbsp;PHP {{ number_format($job->min_salary, 0) }} - PHP {{ number_format($job->max_salary, 0) }}</p>
                            <p class="job-experience"><i class="fa-solid fa-briefcase"></i>&nbsp;{{ $job->experience }} year(s) Experience</p>
                        </div>
                    @endforeach
                </div>                
            </div>
            
            <br><br><br><br><br>

        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-left">
                    <h2>Neksjob</h2>
                    <a href="https://maps.app.goo.gl/ZCwkt3FjH32PRAdA9"><p>2nd Floor Fuentes Bldg. Waling Waling St. Mla. East Road, San Isidro, Angono, Rizal</p></a>
                    <a href="https://www.neksjob.com/"><p>neksjob.com</p></a>
                    <p>Monday to Friday, 6:00 AM to 4:00 PM</p>
                    
                    <div class="social-icons">
                        <a href="#" class="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="twitter"><i class="fa-brands fa-twitter"></i></a>
                    </div>

                    <p id="copyright">© 2025 Copyright: neksjobph</p>
                </div>

                <div class="footer-right">
                    <div class="footer-section">
                        <h3>About</h3>
                        <a href="#">About Neksjob</a>
                    </div>
                    <div class="footer-section">
                        <h3>Jobseekers</h3>
                        <a href="#">Sign-Up</a>
                        <a href="#">Sign-In</a>
                        <a href="#">Find a Job</a>
                    </div>
                    <div class="footer-section">
                        <h3>Employers</h3>
                        <a href="#">Sign-Up</a>
                        <a href="#">Sign-In</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <a href="#">Privacy Policy</a> |
                <a href="#">Terms and Conditions</a> |
                <a href="#">About Us</a>
            </div>
        </footer>


    </body>
</html>