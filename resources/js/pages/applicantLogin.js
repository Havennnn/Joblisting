import { togglePasswordVisibility } from '../utils/passwordVisibility.js';

/**
 * Initialize the applicant login form
 */
const initApplicantLogin = () => {
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
    // The form doesn't have an ID in the current HTML, so we'll check if we're on the login page
    // by checking for the password toggle button which should only exist on this page
    if (document.getElementById('togglePassword')) {
        initApplicantLogin();
    }
});
