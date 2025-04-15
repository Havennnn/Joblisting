import './bootstrap';
import initDropdowns from './components/dropdownHandler';

// We're now using direct imports in the blade templates for specific pages
// This file is mainly used for global functionality that applies to all pages

// Add global Livewire hooks for debugging (no console.log)
if (typeof window.Livewire !== 'undefined') {
    window.Livewire.hook('component.initialized', (component) => {
        // Component initialized
    });

    window.Livewire.hook('element.initialized', (element) => {
        // Element initialized
    });

    window.Livewire.hook('element.updating', (fromEl, toEl) => {
        // Element updating
    });

    window.Livewire.hook('element.updated', (el) => {
        // Element updated
    });

    window.Livewire.hook('message.sent', (message, component) => {
        // Message sent
    });

    window.Livewire.hook('message.failed', (message, component) => {
        // Message failed
    });

    window.Livewire.hook('message.received', (message, component) => {
        // Message received
    });

    window.Livewire.hook('message.processed', (message, component) => {
        // Message processed
    });
}

// Add global event listeners or functionality here if needed
document.addEventListener('DOMContentLoaded', () => {
    console.log('JobFair application initialized');
    initDropdowns();
});
