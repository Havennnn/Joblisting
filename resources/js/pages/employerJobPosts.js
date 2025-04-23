function setupJobPostMenus() {
    document.querySelectorAll('[id^="menu-button-"]').forEach(button => {
        const id = button.id.replace('menu-button-', '');
        const menu = document.getElementById(`dropdown-menu-${id}`);

        button.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });

        window.addEventListener('click', (e) => {
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });
}

function setupPaginationLinks() {
    const paginationLinks = document.querySelectorAll('.pagination-link');

    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');

            // Show loading state
            const tableContainer = document.getElementById('job-posts-container');
            tableContainer.innerHTML = '<div class="p-8 text-center"><svg class="animate-spin h-8 w-8 mx-auto text-neksjob-blue" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><p class="mt-2 text-gray-600">Loading...</p></div>';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                tableContainer.innerHTML = html;

                setupJobPostMenus();
                setupPaginationLinks();

                window.history.pushState({}, '', url);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                tableContainer.innerHTML = '<div class="p-8 text-center text-red-600">Error loading data. Please try again.</div>';
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    setupJobPostMenus();
    setupPaginationLinks();
});

export { setupJobPostMenus, setupPaginationLinks };
