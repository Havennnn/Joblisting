/**
 * Handle dropdown menus closing when clicking outside and interactivity between dropdowns
 */
function initDropdowns() {
    // Direct handlers for each dropdown button
    setupDropdown('#userDropdown button', 'dropdown-menu');
    setupDropdown('#notificationDropdown button', 'notification-menu');
    setupDropdown('#employerNotificationDropdown button', 'employer-notification-menu');

    // Function to set up click handlers for each dropdown
    function setupDropdown(buttonSelector, menuId) {
        const button = document.querySelector(buttonSelector);
        const menu = document.getElementById(menuId);

        if (button && menu) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Toggle this menu
                menu.classList.toggle('hidden');

                // Close other menus
                closeOtherMenus(menuId);
            });
        }
    }

    // Function to close other menus when one is opened
    function closeOtherMenus(currentMenuId) {
        const menus = [
            'dropdown-menu',
            'notification-menu',
            'employer-notification-menu'
        ];

        menus.forEach(function(menuId) {
            if (menuId !== currentMenuId) {
                const menu = document.getElementById(menuId);
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            }
        });
    }

    // Close all menus when clicking outside
    document.addEventListener('click', function() {
        const menus = [
            'dropdown-menu',
            'notification-menu',
            'employer-notification-menu'
        ];

        menus.forEach(function(menuId) {
            const menu = document.getElementById(menuId);
            if (menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    });
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dropdown handler initialized');
    initDropdowns();
});

// Export for use as a module
export default initDropdowns;
