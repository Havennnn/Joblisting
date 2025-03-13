<!-- resources/views/messenger/new-conversation.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Start New Conversation</h5>
                        <a href="{{ route('messenger.interviewer-chats') }}" class="btn btn-sm btn-outline-secondary">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <label for="search-input" class="form-label">Search for an applicant</label>
                        <input type="text" id="search-input" class="form-control" placeholder="Search by name or email">
                    </div>

                    <div id="search-results" class="list-group mb-4">
                        <!-- Search results will appear here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');
    
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            const query = searchInput.value.trim();
            
            if (query.length >= 2) { // Only search if at least 2 characters
                fetch(`/api/messenger/search-applicants?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(applicants => {
                        searchResults.innerHTML = '';
                        
                        if (applicants.length === 0) {
                            searchResults.innerHTML = '<div class="alert alert-info">No applicants found</div>';
                            return;
                        }
                        
                        applicants.forEach(applicant => {
                            searchResults.innerHTML += `
                                <a href="/messenger/start-conversation/${applicant.id}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">${applicant.name}</h5>
                                            <p class="mb-1 small">${applicant.email}</p>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                    });
            } else {
                searchResults.innerHTML = '';
            }
        }, 300);
    });
</script>
@endsection