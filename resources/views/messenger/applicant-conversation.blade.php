<!-- resources/views/messenger/applicant-conversation.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chat with {{ $conversation->interviewer->name }}</h5>
                        <a href="{{ route('messenger.applicant-chat') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="messages-container" class="mb-4" style="max-height: 400px; overflow-y: auto;">
                        <!-- Messages will be loaded here via JavaScript -->
                    </div>

                    <form id="message-form">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="message-input" class="form-control" placeholder="Type your message...">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const conversationId = {{ $conversation->id }};
        const userId = {{ Auth::id() }};

        // Load initial messages
        loadMessages();

        // Set up form submission
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const messageInput = document.getElementById('message-input');
            const message = messageInput.value.trim();

            if (message) {
                sendMessage(message);
                messageInput.value = '';
            }
        });

        function loadMessages() {
            fetch(`/api/messenger/conversation/${conversationId}/messages`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load messages');
                    }
                    return response.json();
                })
                .then(messages => {
                    const container = document.getElementById('messages-container');
                    container.innerHTML = '';

                    messages.forEach(message => {
                        container.innerHTML += createMessageHTML(message);
                    });

                    // Scroll to bottom
                    container.scrollTop = container.scrollHeight;
                })
                .catch(error => {
                    console.error('Error loading messages:', error);
                });
        }

        function sendMessage(content) {
            fetch(`/api/messenger/conversation/${conversationId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ content })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to send message');
                }
                return response.json();
            })
            .then(message => {
                loadMessages(); // Reload all messages to include the new one
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            });
        }

        function createMessageHTML(message) {
            const messageClass = message.is_mine ? 'text-end' : 'text-start';
            const bubbleClass = message.is_mine ? 'bg-primary text-white' : 'bg-light';

            return `
                <div class="${messageClass} mb-2">
                    <div class="d-inline-block ${bubbleClass} p-2 rounded">
                        <div>${message.content}</div>
                        <small>${message.created_at}</small>
                    </div>
                </div>
            `;
        }

        // Listen for new messages with Pusher
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        // Subscribe to the conversation channel
        const channel = pusher.subscribe(`conversation.${conversationId}`);

        // Listen for new message events
        channel.bind('App\\Events\\NewMessageSent', function(data) {
            loadMessages(); // Reload messages when a new one is received
        });
    });
</script>
@endsection