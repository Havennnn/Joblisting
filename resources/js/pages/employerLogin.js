import { togglePasswordVisibility } from '../utils/passwordVisibility.js';

/**
 * Initialize the employer login form
 */
const initEmployerLogin = () => {
    const passwordField = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePassword');

    if (togglePasswordBtn && passwordField) {
        togglePasswordBtn.addEventListener('click', () => {
            togglePasswordVisibility(passwordField, togglePasswordBtn);
        });
    }
};


document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('togglePassword') &&
        document.querySelector('h2')?.textContent.includes('Employers Sign in')) {
        initEmployerLogin();
    }
});
