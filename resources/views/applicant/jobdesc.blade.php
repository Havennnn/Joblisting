<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $job->title }}</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/jobdesc.css') }}">

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

    <!-- Job Description -->
    <div class="job-container">
        <h1 class="job-title">{{ $job->title }}</h1>
        <p class="job-location"><i class="fa-solid fa-location-dot"></i> {{ $job->location }}</p>
        <p class="company-name"><strong>Company:</strong> {{ $job->company_name }}</p>
        <p class="company-description"><strong>Company Description:</strong> {{ $job->company_description }}</p>

        <div class="job-details">
            <p><span>Contract Type:</span> {{ $job->job_type }}</p>
            <p><span>Experience Required:</span> {{ $job->experience }} year(s)</p>
            <p><span>Educational Level:</span> {{ $job->education_level }}</p>
            <p><span>Number of Vacancies:</span> {{ $job->vacancies }}</p>
        </div>

        <div class="job-description">
            <h3>Job Description</h3>
            <p>{{ $job->description }}</p>
        </div>

        <p class="salary"><strong>Salary Range:</strong> PHP {{ number_format($job->min_salary, 0) }} - PHP {{ number_format($job->max_salary, 0) }}</p>
        
        <a href="#" class="apply-btn">Apply Now</a>
    </div>
</body>
</html>
