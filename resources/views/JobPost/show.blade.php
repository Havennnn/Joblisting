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

            <h1 class="mb-0">Job Details</h1>
            <hr />
            <div class="row">
                <div class="col mb-3">

                    <br>
                    <br>

                    <h3>{{ $jobpost->title }}</h3>
                    <p>
                    Industries: {{ $jobpost->industry }}
                    | Role: {{ $jobpost->role }}
                    </p>

                    <p>
                    Tags: {{ $jobpost->tags }}
                    | Location: {{ $jobpost->location }}
                    | Salary: {{ $jobpost->salary }}
                    </p>

                    <br>

                    Description:
                    <p>{{ $jobpost->job_description }}</p>

                    Qualifications:
                    <p>{{ $jobpost->qualifications }}</p>

                    <p>
                    Educational Level: {{ $jobpost->educational_level }}
                    | Work Experience: {{ $jobpost->work_experience_level }}
                    </p>

                    <p>
                    Type: {{ $jobpost->type }}
                    | Shift: {{ $jobpost->shift }}
                    | Work Set-Up: {{ $jobpost->work_setup }}
                    | Vacancies: {{ $jobpost->vacancies }}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Created At</label>
                    <input type="text" name="created_at" class="form-control" placeholder="Created At" value="{{ $jobpost->created_at }}" readonly>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Updated At</label>
                    <input type="text" name="updated_at" class="form-control" placeholder="Updated At" value="{{ $jobpost->updated_at }}" readonly>
                </div>
            </div>  

        </div>
    </main>
</div>
@endsection
