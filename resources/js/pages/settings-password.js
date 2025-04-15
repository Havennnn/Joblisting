import { initPasswordToggle } from '../utils/passwordVisibility';

document.addEventListener('DOMContentLoaded', () => {
    // Initialize the password toggle with event delegation
    initPasswordToggle();
});

// For Livewire component updates
if (typeof window.Livewire !== 'undefined') {
    window.Livewire.hook('component.initialized', (component) => {
        if (component.name === 'settings.password.change-password') {
            // No need to reinitialize since we're using event delegation
        }
    });

    window.Livewire.hook('message.processed', (message, component) => {
        if (component.name === 'settings.password.change-password') {
            // No need to reinitialize since we're using event delegation
        }
    });
}
