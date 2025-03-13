<!-- resources/views/messenger/interviewer-chats.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Your Conversations</h5>
                        <div>
                            <a href="{{ route('messenger.new-conversation') }}" class="btn btn-sm btn-primary">New Conversation</a>
                            <a href="{{ route('messenger') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($conversations->count() > 0)
                        <div class="list-group">
                            @foreach($conversations as $conversation)
                                <a href="{{ route('messenger.conversation', $conversation) }}" 
                                   class="list-group-item list-group-item-action {{ !$conversation->is_read ? 'fw-bold' : '' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">{{ $conversation->applicant->name }}</h5>
                                            <p class="mb-1 text-truncate" style="max-width: 300px;">
                                                @if($conversation->messages->count() > 0)
                                                    {{ $conversation->messages->first()->content }}
                                                @else
                                                    No messages yet
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <small>{{ $conversation->last_message_at->diffForHumans() }}</small>
                                            @if(!$conversation->is_read)
                                                <span class="badge bg-primary ms-2">New</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            You don't have any conversations yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection