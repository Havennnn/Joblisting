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

     <div class="profile-container">
        <div class="profile-header">
            <h1>{{ $user->name ?? 'Meryl Bennett Castro' }}</h1>
            <p>{{ $user->email ?? 'meryl.neksjob@gmail.com' }}</p>
            <button class="edit-btn">Edit</button>
        </div>

        <div class="section">
            <h2>Skills</h2>
            <p>Let employers know how valuable you can be to them.</p>
            <button class="add-btn">Add Skills</button>
        </div>

        <div class="section">
            <h2>Education</h2>
            <p>Tell employers about your education.</p>
            <button class="add-btn">Add Education</button>
        </div>

        <div class="section">
            <h2>Resumé</h2>
            <p>Upload a resumé for easy applying and access no matter where you are.</p>
            <button class="upload-btn">Upload Resume</button>
        </div>
    </div>

</body>
</html>