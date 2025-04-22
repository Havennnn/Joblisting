import initOtpHandler from '../utils/otpHandler';
import { initPasswordToggle } from '../utils/passwordVisibility';

document.addEventListener('DOMContentLoaded', () => {
    initOtpHandler();
    initPasswordToggle();
});

if (typeof window.Livewire !== 'undefined') {
    window.Livewire.hook('component.initialized', (component) => {
        if (component.name === 'settings.email.change-email') {
        }
    });

    window.Livewire.hook('message.processed', (message, component) => {
        if (component.name === 'settings.email.change-email') {
        }
    });
}
