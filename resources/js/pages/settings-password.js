import { initPasswordToggle } from '../utils/passwordVisibility';

document.addEventListener('DOMContentLoaded', () => {
    initPasswordToggle();
});

if (typeof window.Livewire !== 'undefined') {
    window.Livewire.hook('component.initialized', (component) => {
        if (component.name === 'settings.password.change-password') {
        }
    });

    window.Livewire.hook('message.processed', (message, component) => {
        if (component.name === 'settings.password.change-password') {
        }
    });
}
