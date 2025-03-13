<!-- resources/views/messenger/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Messenger</div>

                <div class="card-body">
                    @if($roleType === 'applicant')
                        <p>Welcome to your applicant chat portal.</p>
                        <a href="{{ route('messenger.check-profile') }}" class="btn btn-primary">
                            Chat with Interviewer
                        </a>
                    @elseif($roleType === 'interviewer')
                        <p>Welcome to your interviewer dashboard.</p>
                        <a href="{{ route('messenger.interviewer-chats') }}" class="btn btn-primary">
                            View Conversations
                        </a>
                    @else
                        <div class="alert alert-warning">
                            <p>Your role type is not recognized.</p>
                            <p>Please contact an administrator to set up your account properly.</p>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-primary">Return to Dashboard</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection