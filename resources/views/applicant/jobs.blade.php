<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Browse Jobs</title>

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/jobs.css') }}">

        <!-- Audiowide/Neksjob font -->
        <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">

        <!-- Inter Font Family -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            <!-- Search Bar -->
            <div class="searchbar-container">
                <div class="searchbar">
                    <span class="icon"><i class="fa fa-search"></i></span>
                    <input type="text" name="job-title" id="job-title" placeholder="Job Title">
                    
                    <span class="divider"></span>
                    
                    <span class="icon"><i class="fa fa-map-marker-alt"></i></span>
                    <input type="text" name="location" id="location" placeholder="City">
                    
                    <button class="search-btn">Search</button>
                </div>
            </div>

            <!-- Jobs -->
            <div class="jobs">
                <!-- Browse Jobs -->
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
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-left">
                    <a href="#">Privacy Policy</a> |
                    <a href="#">Terms and Conditions</a> |
                    <a href="#">Contact Us</a>
                </div>

                <div class="footer-right">
                    <p id="copyright">© 2025 Copyright: neksjobph</p>
                    <div class="social-icons">
                        <a href="#" class="tw"><img src="{{ asset('images/twitter-icon.png') }}"></a>
                        <a href="#" class="fb"><img src="{{ asset('images/facebook-icon.png') }}"></a>
                        <a href="#" class="lk"><img src="{{ asset('images/linkedin-icon.png') }}"></a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>