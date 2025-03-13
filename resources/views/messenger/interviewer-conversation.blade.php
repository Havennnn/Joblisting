@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Conversation with {{ $conversation->applicant->name }}</h5>
                        <a href="{{ route('messenger.interviewer-chats') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <div id="message-container" class="mb-3" style="max-height: 400px; overflow-y: auto;">
                        <!-- Messages will be loaded here -->
                    </div>

                    <form id="message-form">
                        <div class="input-group">
                            <input type="text" id="message-input" class="form-control" placeholder="Type your message here...">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const conversationId = '{{ $conversation->id }}';
        const userId = '{{ Auth::id() }}';
        
        console.log("Loading conversation:", conversationId);
        
        // Fetch existing messages
        fetchMessages();
        
        // Set up polling for new messages (alternative to Pusher)
        const pollInterval = setInterval(fetchMessages, 5000); // Poll every 5 seconds
        
        // Clean up interval when leaving page
        window.addEventListener('beforeunload', function() {
            clearInterval(pollInterval);
        });

        // Handle form submission
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const messageInput = document.getElementById('message-input');
            const content = messageInput.value.trim();
            if (content) {
                sendMessage(content);
                messageInput.value = '';
            }
        });

        function fetchMessages() {
            fetch(`/api/messenger/conversation/${conversationId}/messages`)
                .then(response => response.json())
                .then(messages => {
                    const container = document.getElementById('message-container');
                    container.innerHTML = '';

                    if (messages.length === 0) {
                        container.innerHTML = '<div class="text-center text-muted my-4">No messages yet. Start the conversation!</div>';
                    } else {
                        messages.forEach(message => {
                            container.appendChild(createMessageElement(message));
                        });
                    }

                    // Scroll to bottom
                    container.scrollTop = container.scrollHeight;
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
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
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(message => {
                console.log('Message sent successfully:', message);
                // Fetch messages again to update the UI with the new message
                fetchMessages();
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            });
        }

        function createMessageElement(message) {
            const isMine = message.is_mine || message.user_id == userId;

            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isMine ? 'text-end' : 'text-start'} mb-2`;

            const bubble = document.createElement('div');
            bubble.className = `d-inline-block p-2 rounded ${isMine ? 'bg-primary text-white' : 'bg-light'}`;
            bubble.style.maxWidth = '75%';

            const content = document.createElement('div');
            content.innerText = message.content;

            const meta = document.createElement('div');
            meta.className = 'text-muted small';
            meta.innerText = `${isMine ? 'You' : message.user_name} · ${message.created_at}`;

            bubble.appendChild(content);
            messageDiv.appendChild(bubble);
            messageDiv.appendChild(meta);

            return messageDiv;
        }
    });
</script>
</script>
@endsection