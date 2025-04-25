/**
 * Toggle bookmark status for a job
 */
export function toggleBookmark(jobId, csrfToken) {
    const bookmark = document.getElementById('bookmark-' + jobId);
    const bookmarkText = document.getElementById('bookmark-text-' + jobId);

    if (!bookmark) return;

    const isSaved = bookmark.classList.contains('text-yellow-500');

    const url = isSaved
        ? `/applicant/saved-jobs/${jobId}/unsave`
        : `/applicant/saved-jobs/${jobId}/save`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Update UI based on the response
        updateBookmarkUI(bookmark, bookmarkText, data.saved);
    })
    .catch(error => {
        // If there's an error, just revert the UI back to original state
        updateBookmarkUI(bookmark, bookmarkText, isSaved);
    });

    // Update UI immediately for a better user experience
    updateBookmarkUI(bookmark, bookmarkText, !isSaved);
}

/**
 * Update bookmark UI elements
 */
function updateBookmarkUI(bookmark, bookmarkText, isSaved) {
    if (isSaved) {
        bookmark.classList.remove('text-gray-500');
        bookmark.classList.add('text-yellow-500', 'fill-yellow-500');
        if (bookmarkText) bookmarkText.textContent = 'Saved';
    } else {
        bookmark.classList.remove('text-yellow-500', 'fill-yellow-500');
        bookmark.classList.add('text-gray-500');
        if (bookmarkText) bookmarkText.textContent = 'Save Job';
    }
}

/**
 * Check if a job is bookmarked
 */
export function checkBookmarkStatus(jobId) {
    fetch(`/applicant/saved-jobs/${jobId}/check`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const bookmark = document.getElementById('bookmark-' + jobId);
            const bookmarkText = document.getElementById('bookmark-text-' + jobId);

            if (bookmark && data.saved) {
                updateBookmarkUI(bookmark, bookmarkText, true);
            }
        })
        .catch(error => {
            // Silent fail - just keep default state
        });
}

/**
 * Open the job application modal
 */
export function openApplicationModal() {
    document.getElementById('applicationModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

/**
 * Close the job application modal
 */
export function closeApplicationModal() {
    document.getElementById('applicationModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

/**
 * Scroll to the apply section
 */
export function scrollToApply() {
    const applySection = document.getElementById('apply');
    applySection.scrollIntoView({ behavior: 'smooth' });
}

/**
 * Initialize job details page functionality
 */
export function init(jobId, csrfToken) {
    window.toggleBookmark = (id) => toggleBookmark(id, csrfToken);
    window.openApplicationModal = openApplicationModal;
    window.closeApplicationModal = closeApplicationModal;
    window.scrollToApply = scrollToApply;

    checkBookmarkStatus(jobId);

    const modalOverlay = document.getElementById('modalOverlay');
    if (modalOverlay) {
        modalOverlay.addEventListener('click', closeApplicationModal);
    }
}

export default { init, toggleBookmark, checkBookmarkStatus, openApplicationModal, closeApplicationModal, scrollToApply };
