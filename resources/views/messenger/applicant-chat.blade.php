<!-- resources/views/messenger/applicant-chat.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Available Interviewers</h5>
                        <a href="{{ route('messenger') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    @if($availableInterviewers->count() > 0)
                        <div class="list-group">
                            @foreach($availableInterviewers as $interviewer)
                                <a href="{{ route('messenger.chat-with-interviewer', $interviewer->id) }}" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">{{ $interviewer->name }}</h5>
                                            @if(isset($existingConversations[$interviewer->id]))
                                                <p class="mb-1 text-truncate" style="max-width: 300px;">
                                                    @if($existingConversations[$interviewer->id]->messages->count() > 0)
                                                        Last message: {{ $existingConversations[$interviewer->id]->messages->first()->content }}
                                                    @else
                                                        No messages yet
                                                    @endif
                                                </p>
                                            @else
                                                <p class="mb-1"><small>Start a new conversation</small></p>
                                            @endif
                                        </div>
                                        <div>
                                            @if($interviewer->last_active_at && now()->diffInMinutes($interviewer->last_active_at) < 15)
                                                <span class="badge bg-success">Online</span>
                                            @else
                                                <small>Last seen: {{ $interviewer->last_active_at ? $interviewer->last_active_at->diffForHumans() : 'Never' }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            No interviewers are available at the moment.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection