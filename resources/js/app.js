import './bootstrap';
import initDropdowns from './components/dropdownHandler';
import jobDetails from './pages/jobDetails';
import * as employerJobPosts from './pages/employerJobPosts';

window.jobDetails = jobDetails;
window.employerJobPosts = employerJobPosts;

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

document.addEventListener('DOMContentLoaded', () => {
    console.log('JobFair application initialized');
    initDropdowns();
});
