<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/userprofile.css') }}">
        
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
            <!-- username dropdown > profile + settings + logout + ? -->
            <!-- papalitan pa -->
            <p id="username">merylcastro</p>
        </div>
    </div>

    <!-- Header -->
    <div class="profile-banner">
        <div class="profile-picture">
            <img src="{{ asset('images/avatar.png') }}" alt="Profile Photo">
        </div>
        <div class="profile-name">
            <h1>{{ $user->name ?? 'Jimuel Sgv' }}</h1>
        </div>
    </div>

    <!-- Info Boxes -->
    <div class="info-container">

        <div class="info-box">
            <h3><u>Personal Information</u></h3>
            <div class="info-grid">
                <p><span>Full Name</span><br>{{ $user->name ?? 'Meryl Bennett Castro' }}</p>
                <p><span>Email address</span><br>{{ $user->email ?? 'meryl.neksjob@gmail.com' }}</p>
                <p><span>Phone Number</span><br>{{ $user->number ?? '09381234567' }}</p>
                <p><span>Location</span><br>{{ $user->location ?? 'Binangonan, Rizal' }}</p>
                <p><span>Gender</span><br>{{ $user->gender ?? 'Male' }}</p>
                <p><span>Age</span><br>{{ $user->number ?? '23' }}</p>
            </div>
        </div>

        <div class="info-box">
            <h3><u>Professional Information</u></h3>
            <div class="info-grid" id="professional-info">
                <p><span>Field of Expertise</span><br>{{ $user->expertise ?? 'Computer Science' }}</p>
                <p><span>Skills</span><br>{{ $user->skills ?? 'Javascript, PHP, CSS' }}</p>
                <p><span>Years of Experience</span><br>{{ $user->experience ?? '7' }}</p>
            </div>
        </div>

        <div class="info-box">
            <h3><u>Document</u></h3>
            <p><span>Resume</span><br>
                <a href="#">View attached File</a>
            </p>
        </div>

        <div class="edit-container">
            <button class="edit-btn">Edit Profile</button>
        </div>
    </div>
</body>
</html>