<!-- resources/views/messenger/no-interviewer-available.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">No Interviewer Available</div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p>We're sorry, but there are no interviewers available at the moment.</p>
                        <p>Please check back later or contact our support team for assistance.</p>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-primary">Return to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection