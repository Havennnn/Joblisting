import initOtpHandler from '../utils/otpHandler';
import { initPasswordToggle } from '../utils/passwordVisibility';

document.addEventListener('DOMContentLoaded', () => {
    // Initialize OTP Handler (already uses event delegation)
    initOtpHandler();

    // Initialize the password toggle with event delegation
    initPasswordToggle();
});

// For Livewire component updates
if (typeof window.Livewire !== 'undefined') {
    window.Livewire.hook('component.initialized', (component) => {
        if (component.name === 'settings.email.change-email') {
            // No need to reinitialize since our handlers use event delegation
        }
    });

    window.Livewire.hook('message.processed', (message, component) => {
        if (component.name === 'settings.email.change-email') {
            // No need to reinitialize since our handlers use event delegation
        }
    });
}
