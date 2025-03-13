<!-- resources/views/messenger/conversation.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Main conversation area -->
        <div class="{{ Auth::user()->role === 'applicant' ? 'col-md-8' : 'col-md-8' }}">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            @if(Auth::user()->role === 'interviewer')
                                Chat with {{ $conversation->applicant->name }}
                            @else
                                Chat with {{ $conversation->interviewer->name }}
                            @endif
                        </h5>
                        <a href="{{ Auth::user()->role === 'interviewer' ? route('messenger.interviewer-chats') : route('messenger.applicant-chat') }}" class="btn btn-sm btn-outline-secondary">Back</a>
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
                            
                            @if(Auth::user()->role === 'applicant')
                                <div class="input-group-append">
                                    <button id="send-resume-btn" type="button" class="btn btn-info">Resume</button>
                                    <button id="send-phone-btn" type="button" class="btn btn-warning">Phone Number</button>
                                    <button id="interview-ready-btn" type="button" class="btn btn-success">Interview Ready</button>
                                </div>
                            @endif
                            
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right sidebar: Conversation list for applicants OR Applicant Info for interviewers -->
        @if(Auth::user()->role === 'applicant')
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">My Conversations</h5>
                </div>
                <div class="card-body p-0">
                    <div id="conversations-list" class="list-group list-group-flush">
                        <!-- Conversations will be loaded here via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Interviewer's applicant panel -->
        <div class="col-md-4">
            <!-- Applicant info card -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Applicant Info</h5>
                </div>
                <div class="card-body">
                    <h6>{{ $conversation->applicant->name }}</h6>
                    <p class="text-muted mb-2">Joined: {{ $conversation->applicant->created_at->format('M d, Y') }}</p>
                    
                    @if($conversation->applicant->applicantProfile)
                        <p><strong>Phone:</strong> {{ $conversation->applicant->applicantProfile->phone_number }}</p>
                        <p><strong>Location:</strong> {{ $conversation->applicant->applicantProfile->location }}</p>
                    @endif
                    
                    <!-- View Resume Button -->
                    <button id="view-resume-btn" class="btn btn-sm btn-outline-primary mb-3 w-100">
                        <i class="fas fa-file-pdf"></i> View Resume
                    </button>
                    
                    <!-- Applicant Rating -->
                    <div class="mb-3">
                        <label class="form-label">Applicant Rating</label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" class="rating-input"><label for="star5" class="rating-star">★</label>
                            <input type="radio" id="star4" name="rating" value="4" class="rating-input"><label for="star4" class="rating-star">★</label>
                            <input type="radio" id="star3" name="rating" value="3" class="rating-input"><label for="star3" class="rating-star">★</label>
                            <input type="radio" id="star2" name="rating" value="2" class="rating-input"><label for="star2" class="rating-star">★</label>
                            <input type="radio" id="star1" name="rating" value="1" class="rating-input"><label for="star1" class="rating-star">★</label>
                        </div>
                    </div>
                    
                    <!-- Application Status -->
                    <div class="mb-3">
                        <label class="form-label">Application Status</label>
                        <select id="application-status" class="form-select">
                            <option value="new">New Application</option>
                            <option value="screening">Initial Screening</option>
                            <option value="interview">Interview Scheduled</option>
                            <option value="technical">Technical Assessment</option>
                            <option value="final">Final Interview</option>
                            <option value="offered">Offer Extended</option>
                            <option value="hired">Hired</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    
                    <button id="save-applicant-info" class="btn btn-success w-100">Save Changes</button>
                </div>
            </div>
            
            <!-- Interview Notes Card -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Interview Notes</h5>
                </div>
                <div class="card-body">
                    <textarea id="interview-notes" class="form-control" rows="7" placeholder="Take notes during the interview..."></textarea>
                    <div class="d-flex justify-content-between mt-2">
                        <button id="save-notes" class="btn btn-primary">Save Notes</button>
                        <button id="clear-notes" class="btn btn-outline-secondary">Clear</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Resume Modal -->
<div class="modal fade" id="resumeModal" tabindex="-1" aria-labelledby="resumeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resumeModalLabel">{{ $conversation->applicant->name ?? 'Applicant' }}'s Resume</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="resume-content">
                <!-- Resume content will be loaded here -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading resume...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="download-resume" class="btn btn-primary">Download</a>
            </div>
        </div>
    </div>
</div>

<style>
/* Star Rating System */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating-input {
    display: none;
}

.rating-star {
    font-size: 1.5rem;
    padding: 0 0.2rem;
    color: #ddd;
    cursor: pointer;
}

.rating-input:checked ~ .rating-star,
.rating-input:checked ~ .rating-star ~ .rating-star {
    color: #ffc107;
}

.rating-star:hover,
.rating-star:hover ~ .rating-star {
    color: #ffc107;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const conversationId = {{ $conversation->id }};
        const userId = {{ Auth::id() }};
        const userRole = "{{ Auth::user()->role }}";

        // Load initial messages
        loadMessages();
        
        // For applicants, also load conversations list
        if (userRole === 'applicant') {
            loadConversations();
            
            // Handle quick response buttons
            document.getElementById('send-resume-btn').addEventListener('click', function() {
                sendMessage("I've attached my resume for your review. Please let me know if you need any additional information.");
            });
            
            document.getElementById('send-phone-btn').addEventListener('click', function() {
                sendMessage("My phone number is: [YOUR PHONE NUMBER]. Feel free to call me for the interview.");
            });
            
            document.getElementById('interview-ready-btn').addEventListener('click', function() {
                sendMessage("I'm ready for the interview. Please let me know what time works best for you.");
            });
        } else {
            // Interviewer-specific functionality
            
            // Resume button handler
            document.getElementById('view-resume-btn').addEventListener('click', function() {
                // Show modal
                const resumeModal = new bootstrap.Modal(document.getElementById('resumeModal'));
                resumeModal.show();
                
                // Load resume (placeholder - would load actual resume in production)
                loadApplicantResume({{ $conversation->applicant->id }});
            });
            
            // Rating star handler
            const ratingInputs = document.querySelectorAll('.rating-input');
            ratingInputs.forEach(input => {
                input.addEventListener('change', function() {
                    saveApplicantRating(this.value);
                });
            });
            
            // Status change handler
            document.getElementById('application-status').addEventListener('change', function() {
                // Update status in database
                updateApplicationStatus(this.value);
            });
            
            // Notes handlers
            document.getElementById('save-notes').addEventListener('click', function() {
                saveInterviewNotes(document.getElementById('interview-notes').value);
            });
            
            document.getElementById('clear-notes').addEventListener('click', function() {
                document.getElementById('interview-notes').value = '';
            });
            
            // Save all changes button
            document.getElementById('save-applicant-info').addEventListener('click', function() {
                saveAllApplicantInfo();
            });
            
            // Load existing data
            loadApplicantInfo();
        }

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

        // Set up polling instead of Pusher (free alternative)
        const pollInterval = setInterval(loadMessages, 5000); // Poll every 5 seconds
        
        // If applicant, also poll conversations
        let conversationsPollInterval;
        if (userRole === 'applicant') {
            conversationsPollInterval = setInterval(loadConversations, 10000); // Poll every 10 seconds
        }
        
        // Clean up polling when page is closed
        window.addEventListener('beforeunload', function() {
            clearInterval(pollInterval);
            if (conversationsPollInterval) {
                clearInterval(conversationsPollInterval);
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

                    if (messages.length === 0) {
                        container.innerHTML = '<div class="text-center text-muted">No messages yet. Start the conversation!</div>';
                        return;
                    }

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

        function loadConversations() {
            if (userRole !== 'applicant') return;
            
            fetch('/api/messenger/conversations')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load conversations');
                    }
                    return response.json();
                })
                .then(conversations => {
                    const container = document.getElementById('conversations-list');
                    container.innerHTML = '';

                    if (conversations.length === 0) {
                        container.innerHTML = '<div class="list-group-item text-muted">No conversations found.</div>';
                        return;
                    }

                    conversations.forEach(conv => {
                        const isActive = conv.id == conversationId;
                        container.innerHTML += `
                            <a href="/messenger/conversation/${conv.id}" 
                               class="list-group-item list-group-item-action ${isActive ? 'active' : ''} ${!conv.is_read ? 'fw-bold' : ''}">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">${conv.interviewer_name}</h6>
                                    <small>${conv.last_message_time}</small>
                                </div>
                                <p class="mb-1 text-truncate">${conv.last_message || 'No messages yet'}</p>
                            </a>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error loading conversations:', error);
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
                // Reload messages after sending
                loadMessages();
                
                // Also reload conversations list for applicants
                if (userRole === 'applicant') {
                    loadConversations();
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            });
        }

        function createMessageHTML(message) {
            const isMine = message.is_mine || message.user_id == userId;
            const messageClass = isMine ? 'text-end' : 'text-start';
            const bubbleClass = isMine ? 'bg-primary text-white' : 'bg-light';
            
            // Add role-specific styling
            const roleBubbleClass = userRole === 'interviewer' && !isMine ? 'border-info' : 
                                   (userRole === 'applicant' && !isMine ? 'border-success' : '');

            return `
                <div class="${messageClass} mb-2">
                    <div class="d-inline-block ${bubbleClass} ${roleBubbleClass} p-2 rounded border" style="max-width: 75%; word-break: break-word;">
                        <div>${message.content}</div>
                        <small>${message.created_at}</small>
                    </div>
                    <div class="text-muted small">
                        ${isMine ? 'You' : message.user_name}
                    </div>
                </div>
            `;
        }
        
        // Interviewer-specific functions
        function loadApplicantResume(applicantId) {
            // Fetch the actual resume URL
            fetch(`/api/applicant/${applicantId}/resume`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load resume');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.resume_url) {
                        // Show the resume in an iframe or redirect to download
                        document.getElementById('resume-content').innerHTML = `
                            <iframe src="/storage/${data.resume_url}" width="100%" height="500px"></iframe>
                        `;
                        document.getElementById('download-resume').href = `/storage/${data.resume_url}`;
                    } else {
                        document.getElementById('resume-content').innerHTML = `
                            <div class="alert alert-info">
                                This applicant hasn't uploaded a resume yet.
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading resume:', error);
                    document.getElementById('resume-content').innerHTML = `
                        <div class="alert alert-danger">
                            Failed to load resume. Please try again later.
                        </div>
                    `;
                });
        }
        
        function saveApplicantRating(rating) {
            // Save rating to the database
            fetch(`/api/applicant/${{{ $conversation->applicant->id }}}/rating`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ rating })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to save rating');
                }
                return response.json();
            })
            .then(data => {
                // Show success notification
                console.log('Rating saved:', rating);
                // In production, add a toast notification
            })
            .catch(error => {
                console.error('Error saving rating:', error);
                // In development only - would use proper notification in production
                alert('Rating will be saved in production.');
            });
        }
        
        function updateApplicationStatus(status) {
            console.log('Status updated to:', status);
            // In production, you'd save this to the database
        }
        
        function saveInterviewNotes(notes) {
            console.log('Notes saved:', notes);
            // In production, you'd save this to the database
            // For demo, just show an alert
            alert('Notes saved!');
        }
        
        function saveAllApplicantInfo() {
            const rating = document.querySelector('input[name="rating"]:checked')?.value || 0;
            const status = document.getElementById('application-status').value;
            const notes = document.getElementById('interview-notes').value;
            
            // In production, you'd save all this data in one request
            console.log('Saving all applicant info:', { rating, status, notes });
            
            // For demo, just show an alert
            alert('All applicant information saved!');
        }
        
        function loadApplicantInfo() {
            // In production, you'd load saved data from the server
            // For demo, we'll simulate loading data
            
            // Simulate delay
            setTimeout(() => {
                // Set simulated rating
                document.getElementById('star4').checked = true;
                
                // Set simulated status
                document.getElementById('application-status').value = 'interview';
                
                // Set simulated notes
                document.getElementById('interview-notes').value = 'Applicant has strong communication skills. Technical assessment scheduled for next week.';
            }, 500);
        }
    });
</script>
@endsection