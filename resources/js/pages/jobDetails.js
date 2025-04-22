/**
 * Toggle bookmark status for a job
 */
export function toggleBookmark(jobId, csrfToken) {
    const bookmark = document.getElementById('bookmark-' + jobId);
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
    .then(response => response.json())
    .then(data => {
        if (data.saved) {
            bookmark.classList.remove('text-gray-500');
            bookmark.classList.add('text-yellow-500', 'fill-yellow-500');
        } else {
            bookmark.classList.remove('text-yellow-500', 'fill-yellow-500');
            bookmark.classList.add('text-gray-500');
        }
    })
    .catch(error => {
        console.error('Error toggling bookmark:', error);
    });
}

/**
 * Check if a job is bookmarked
 */
export function checkBookmarkStatus(jobId) {
    fetch(`/applicant/saved-jobs/${jobId}/check`)
        .then(response => response.json())
        .then(data => {
            const bookmark = document.getElementById('bookmark-' + jobId);
            if (bookmark && data.saved) {
                bookmark.classList.remove('text-gray-500');
                bookmark.classList.add('text-yellow-500', 'fill-yellow-500');
            }
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
