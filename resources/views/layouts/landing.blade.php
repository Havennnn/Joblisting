<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Neksjob</title>

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

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

            <!-- Hero Section -->
            <div class="hero">
                <h1 id="catchphrase">Find your Dream Job today with <span id="company">Neksjob</span>!</h1>
                <p id="subtitle">Discover job opportunities today. Apply and get interviewed now!</p>

                <div class="auth-buttons">
                    <input type="button" name="sign-in" id="sign-in" value="Sign In"></input>
                    <a id="register" href="#">Register</a>
                </div>
            </div>

            <!-- Events -->
            <div class="events">
                <h1 id="event">Events for you</h1>

                <div class="event-container">
                    @foreach($events as $event)
                        <div class="event-card">
                            <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="event-image">
                            <div class="event-content">
                                <h3 class="event-title">{{ $event->title }}</h3>
                                <p class="event-date">{{ \Carbon\Carbon::parse($event->date)->format('D, F d') }} • {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }} GMT+8</p>

                                <p class="event-price">
                                    <strong>
                                        @if($event->price === 'Free')
                                            Free
                                        @else
                                            Php {{ number_format($event->price, 2) }}
                                        @endif
                                    </strong>
                                </p>

                                <p class="event-company">{{ $event->company }}</p>
                                <p class="event-followers"><i class="fa-solid fa-user"></i> {{ number_format($event->followers) }} followers</p>

                                @if($event->is_promoted)
                                    <p class="event-promoted">Promoted <i class="material-icons">info_outline</i></p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Jobs -->
            <div class="jobs">
                <h2 id="find">Find your <span>Neksjob</span></h2>
                <p id="sub">Explore exciting job openings and take the next step in your journey.</p>

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

                <a href="/jobs" class="browse-more">Browse More</a>
            </div>

            <!-- About Section -->
            <div class="about">
                <div class="about-container">
                    <img src="{{ asset('images/about.jpg') }}" alt="About Us Image" class="about-img">
                    <div class="about-text">
                        <h2>About Us</h2>
                        <p>
                            Neksjob is an outsourcing and social enterprise that provides quality services to our clients locally and abroad.
                            We are driven by the innate desire to bring about change by encouraging out-of-the-box solutions to well-worn
                            path challenges at a cost-effective rate. We aim to bridge the gap between countries and cultures, distance,
                            and time zones, to bring the world closer through the help of emerging technology.
                        </p>
                    </div>
                </div>
            </div>

            <!-- BLOG -->
            <div class="blog">
                <h1 class="blogs">Blogs</h1>

                <!-- Blog Container -->
                <div class="blog-container">
                    @foreach ($blogs as $blog)
                    <div class="blog-card">
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="blog-image">
                        <div class="blog-content">
                            <h1 class="blog-title">{{ $blog->title }}</h1>
                            <p class="blog-description">{{ $blog->description }}</p>
                            <input type="button" value="Read more" class="read-more"></input>
                        </div>
                    </div>
                    @endforeach

                </div>

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
        </div>

        <script>
            document.querySelector('.jobs-container').addEventListener('wheel', function(event) {
                if (event.deltaY !== 0) {
                    event.preventDefault();
                    this.scrollLeft += event.deltaY;
                }
            });
        </script>

    </body>
</html>
