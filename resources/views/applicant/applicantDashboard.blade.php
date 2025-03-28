<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Dashboard</title>

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        
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
                <!-- username > dropdown > profile + settings + logout? -->
                <!-- papalitan pa rawr -->
                <p id="username">merylcastro</p>
            </div>
        </div>

        <div class="container">
            <!-- Sidebar -->
            <div class="sidebar">
                <ul class="sidebar-menu">
                    <li class="active">
                        <i class="fa-solid fa-home"></i>
                        <span>Dashboard</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-file"></i>
                        <span>Applications</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-file-alt"></i>
                        <span>CV</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-bookmark"></i>
                        <span>Interested Jobs</span>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="content">
                <h2>Weclome Meryl!</h2>

                <div class="summary">
                    <div class="stat yellow">
                        <img src="{{ asset('images/interested.png') }}" class="summary-icons">
                        <div>
                            <p class="number">{{ $interestedCount }}</p>
                            <p>Interested Jobs</p>
                        </div>
                    </div>
                    <div class="stat blue">
                        <img src="{{ asset('images/applied.png') }}" class="summary-icons">
                        <div>
                            <p class="number">{{ $appliedCount }}</p>
                            <p>Applied Jobs</p>
                        </div>
                    </div>
                    <div class="stat green">
                        <img src="{{ asset('images/interviewed.png') }}" class="summary-icons">
                        <div>
                            <p class="number">{{ $interviewedCount }}</p>
                            <p>Interviewed Jobs</p>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <!-- papalitan pa -->
                    <div class="table-header">
                        <div class="table-title">My Applications</div>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Jobs</th>
                                <th>Applied</th>
                                <th>Interview</th>
                                <th>Hired</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                <tr>
                                    <td>
                                        <div class="job">
                                            <img src="{{ asset($application->image) }}" alt="Job Image" class="job-image">
                                            <div>
                                                <p class="job-title">{{ $application->job_title }}</p>
                                                <p class="job-date">{{ \Carbon\Carbon::parse($application->applied_date)->format('F d, Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status success">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                    </td>
                                    <td>
                                        @if (strtolower($application->interview_status) === 'waiting')
                                            <span class="status warning">Waiting</span>
                                        @elseif (strtolower($application->interview_status) === 'done')
                                            <span class="status success"><i class="fa-solid fa-check"></i></span>
                                        @else
                                            <span class="status danger">{{ $application->interview_status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (strtolower($application->hiring_status) === 'rejected')
                                            <span class="status danger">Rejected</span>
                                        @elseif (strtolower($application->hiring_status) === 'waiting')
                                            <span class="status warning">Waiting</span>
                                        @elseif (strtolower($application->hiring_status) === 'hired')
                                            <span class="status hired">Hired</span>
                                        @else
                                            <span class="status">{{ $application->hiring_status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                </div>


            </div>
        </div>

        
        
    </body>

</html>