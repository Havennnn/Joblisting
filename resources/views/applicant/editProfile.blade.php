<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/editprofile.css') }}">
        
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

    <h1>Edit Profile</h1>

    <form class="info-container" enctype="multipart/form-data">
        <!-- Basic Information -->
        <div class="info-box">
            <h3>Basic Information</h3>
            <div class="info-grid">
                <p><span>Full Name</span><br><input type="text" name="fullname" class="fields"></p>
                <p><span>Age</span><br><input type="number" name="age" class="fields"></p>
                <p><span>Gender</span><br>
                    <select name="gender" class="fields">
                        <option disabled selected>Select your gender</option>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                        <option value="others">Others</option>
                        <option value="prefer_not_to_say">Prefer not to say</option>
                    </select>
                </p>
                <p><span>Phone Number</span><br><input type="text" name="number" class="fields"></p>
                <p style="grid-column: span 2;"><span>Location</span><br><input type="text" name="location" class="fields full-width"></p>
                <div class="email-container">
                    <label><span>Email address</span></label>
                    <div class="email-wrapper">
                        <input type="email" name="email" class="fields email-field" value="applicant@gmail.com">
                        <a href="#" class="edit-link">Edit</a>
                    </div>
                </div>
                
                
            </div>
        </div>

        <!-- Professional Details -->
        <div class="info-box">
            <h3>Professional Details</h3>
            <div class="info-grid">
                <p style="grid-column: span 2;"><span>Field of Expertise</span><br><input type="text" name="expertise" class="fields full-width"></p>
                <p style="grid-column: span 2;"><span>Skills</span><br><textarea name="skills" class="fields full-width" id="skills"></textarea><span>Separate skills with commas</span></p>
                <p><span>Years of Experience</span><br><input type="number" name="experience" class="fields"></p>
            </div>
        </div>

        <!-- Documents -->
        <div class="info-box">
            <h3>Documents</h3>
            <div class="info-grid">
                <!-- Profile Picture -->
                <div style="display: flex; align-items: center; gap: 1vw;">
                    <i class="material-icons" style="font-size: 4vh;">account_circle</i>
                    <label class="custom-file-upload">
                        <input type="file" name="profile_picture" accept="image/*" style="display: none;">
                        <span class="choose-file-btn">Choose File</span>
                        <span class="file-chosen-text">No File Chosen</span>
                    </label>
                </div>

                <!-- Upload CV -->
                <div style="grid-column: span 2;">
                    <span>Upload CV</span><br>
                    <div class="upload-box">
                        <p><strong>Drag or Drop</strong></p>
                        <i class="material-icons" style="font-size: 3vh;">upload_file</i><br>
                        <input type="file" name="cv" accept=".pdf,.doc,.docx" style="display: none;">
                        <button type="button" class="upload-btn">Upload</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save & Cancel -->
        <div class="edit-container">
            <button type="button" class="edit-btn cancel-btn" onclick="window.history.back()">Cancel</button>
            <button type="submit" class="edit-btn save-btn">Save Profile</button>
        </div>
    </form>

</body>
</html>