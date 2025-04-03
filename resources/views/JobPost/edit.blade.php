@extends('layouts.employer')

@section('title', 'Employer Dashboard')

@section('content')
<div class="bg-gray-100">
    <!-- Dashboard header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Job Posting</h1>
        </div>
    </header>

    <!-- Main content -->
    <main class="pt-6 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome section -->
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Welcome back, {{ auth()->user()->name }}!</h2>
                        <p class="mt-1 text-sm text-gray-500">Manage your job listings and applicants here.</p>
                    </div>
                </div>
            </div>

            <h1 class="mb-0">Edit Job</h1>
            <hr />
            <form action="{{ route('jobposts.update', $jobpost->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class=" col mb-3">
                            <label for="title">Job Title:</label>
                            <input type="text" name="title" class="form-control" placeholder="Job Title" value="{{ $jobpost->title }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="industry">Industry:</label>
                        <select name="industry" class="form-control" id="industry" placeholder="Select Industry" required>
                            <option {{ $jobpost->industry == 'Technology and IT' ? 'selected' : '' }}>Technology and IT</option>
                            <option {{ $jobpost->industry == 'Healthcare and Medical' ? 'selected' : '' }}>Healthcare and Medical</option>
                            <!-- Add other industries with similar logic -->
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="role">Role:</label>
                        <select name="role" class="form-control" id="role" placeholder="Select Role" required>
                            <optgroup label="Technology and IT">
                                <option value="Software Developer/Engineer" {{ $jobpost->role == 'Software Developer/Engineer' ? 'selected' : '' }}>Software Developer/Engineer</option>
                                <option value="Web Developer" {{ $jobpost->role == 'Web Developer' ? 'selected' : '' }}>Web Developer</option>
                                <!-- Add other roles with similar logic -->
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="job_description">Description:</label>
                        <textarea name="job_description" class="form-control" placeholder="Job Description" required>{{ $jobpost->job_description }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="qualifications">Qualifications:</label>
                        <textarea name="qualifications" class="form-control" placeholder="Qualifications" required>{{ $jobpost->qualifications }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="starting_date">Starting Date:</label>
                        <input type="date" name="starting_date" class="form-control" value="{{ $jobpost->starting_date }}">
                    </div>

                    <div class="col mb-3">
                        <label for="expiration_date">Expiration Date:</label>
                        <input type="date" name="expiration_date" class="form-control" value="{{ $jobpost->expiration_date }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="work_experience_level">Work Experience Level:</label>
                        <select name="work_experience_level" class="form-control" id="work_experience_level" required>
                            <option {{ $jobpost->work_experience_level == 'Entry-Level' ? 'selected' : '' }}>Entry-Level</option>
                            <option {{ $jobpost->work_experience_level == 'Junior-Level' ? 'selected' : '' }}>Junior-Level</option>
                            <!-- Add other levels with similar logic -->
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="educational_level">Educational Level:</label>
                        <select name="educational_level" class="form-control" id="educational_level" required>
                            <option {{ $jobpost->educational_level == 'Junior High' ? 'selected' : '' }}>Junior High</option>
                            <option {{ $jobpost->educational_level == 'Senior High' ? 'selected' : '' }}>Senior High</option>
                            <!-- Add other levels with similar logic -->
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="work_setup">Work Setup:</label>
                        <select name="work_setup" class="form-control" id="work_setup" required>
                            <option {{ $jobpost->work_setup == 'On-Site' ? 'selected' : '' }}>On-Site</option>
                            <option {{ $jobpost->work_setup == 'Remote' ? 'selected' : '' }}>Remote</option>
                            <option {{ $jobpost->work_setup == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="shift">Shift:</label>
                        <select name="shift" class="form-control" id="shift">
                            <option {{ $jobpost->shift == 'Day shift' ? 'selected' : '' }}>Day shift</option>
                            <option {{ $jobpost->shift == 'Mid shift' ? 'selected' : '' }}>Mid shift</option>
                            <option {{ $jobpost->shift == 'Night shift' ? 'selected' : '' }}>Night shift</option>
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label for="type">Contract Type:</label>
                        <select name="type" class="form-control" id="type" required>
                            <option {{ $jobpost->type == 'Full time' ? 'selected' : '' }}>Full time</option>
                            <option {{ $jobpost->type == 'Part time' ? 'selected' : '' }}>Part time</option>
                            <option {{ $jobpost->type == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="location">Location:</label>
                        <input type="text" name="location" class="form-control" placeholder="Location" value="{{ $jobpost->location }}" required>
                    </div>

                    <div class="col mb-3">
                        <label for="salary">Salary:</label>
                        <input type="number" name="salary" class="form-control" placeholder="Salary" value="{{ $jobpost->salary }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="vacancies">Vacancies:</label>
                        <input type="number" name="vacancies" class="form-control" placeholder="Vacancies" value="{{ $jobpost->vacancies }}" required>
                    </div>

                    <div class="col mb-3">
                        <label for="tags">Tags:</label>
                        <select name="tags" class="form-control" id="tags">
                            <option {{ $jobpost->tags == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                            <option {{ $jobpost->tags == 'Mass Hiring' ? 'selected' : '' }}>Mass Hiring</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="d-grid">
                        <button class="btn btn-warning">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </main>
</div>
@endsection
