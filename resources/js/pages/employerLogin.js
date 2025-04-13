import { togglePasswordVisibility } from '../utils/passwordVisibility.js';

/**
 * Initialize the employer login form
 */
const initEmployerLogin = () => {
    // Set up password visibility toggle
    const passwordField = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePassword');

    // Add event listener for toggling password visibility
    if (togglePasswordBtn && passwordField) {
        togglePasswordBtn.addEventListener('click', () => {
            togglePasswordVisibility(passwordField, togglePasswordBtn);
        });
    }
};

// Auto-initialize on DOM content loaded
document.addEventListener('DOMContentLoaded', () => {
    // We'll check if we're on the employer login page by
    // checking for both the password toggle button and the employer-specific heading
    if (document.getElementById('togglePassword') &&
        document.querySelector('h2')?.textContent.includes('Employers Sign in')) {
        initEmployerLogin();
    }
});
