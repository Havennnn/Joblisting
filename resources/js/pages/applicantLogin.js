import { togglePasswordVisibility } from '../utils/passwordVisibility.js';

/**
 * Initialize the applicant login form
 */
const initApplicantLogin = () => {
    const passwordField = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePassword');

    if (togglePasswordBtn && passwordField) {
        togglePasswordBtn.addEventListener('click', () => {
            togglePasswordVisibility(passwordField, togglePasswordBtn);
        });
    }
};

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('togglePassword')) {
        initApplicantLogin();
    }
});
