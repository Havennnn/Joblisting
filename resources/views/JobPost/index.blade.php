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

            <h1 class="mb-0">Job Management</h1>
            <a href="{{ route('jobposts.create') }}" class="btn btn-primary">Post Job</a>
        @else
            <h1 class="mb-0">Job List</h1>
        @endif
    </div>
    <hr />

    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    @if(Auth::user()->usertype === 'applicant')
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Industry</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if($jobpost->count() > 0)
                    @foreach($jobpost as $rs)
                        <tr>
                            <td class="align-middle">{{ $rs->title }}</td>
                            <td class="align-middle">{{ $rs->role}}</td>
                            <td class="align-middle">{{ $rs->industry}}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Actions">
                                    <a href="{{ route('jobposts.show', $rs->id) }}" class="btn btn-secondary">Show</a>
                                   {{--  <a href="{{ route('apply.now', $rs->id) }}" class="btn btn-success">Apply Now</a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">Job not found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @else
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Applicant</th>
                    <th>Unread</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($jobpost->count() > 0)
                    @foreach($jobpost as $rs)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $rs->title }}</td>
                            <td class="align-middle">{{ $rs->tags }}</td>
                            <td class="align-middle">{{ $rs->vacancies }}</td>
                            <td class="align-middle">{{ $rs->vacancies }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Actions">
                                    <a href="{{ route('jobposts.show', $rs->id) }}" class="btn btn-secondary">Detail</a>
                                    <a href="{{ route('jobposts.edit', $rs->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('jobposts.destroy', $rs->id) }}" method="POST" onsubmit="return confirm('Delete?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6">Job not found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @endif
    </div>
    </main>
</div>
@endsection

