import { initializePasswordValidation } from '../components/passwordStrengthIndicator.js';
import { togglePasswordVisibility } from '../utils/passwordVisibility.js';

/**
 * Initialize the employer registration form
 */
const initEmployerRegistration = () => {
    // Initialize password validation
    initializePasswordValidation('password');

    // Set up password visibility toggles
    const passwordField = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const toggleConfirmBtn = document.getElementById('toggleConfirmPassword');

    // Add event listeners for toggling password visibility
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', () => {
            togglePasswordVisibility(passwordField, togglePasswordBtn);
        });
    }

    if (toggleConfirmBtn) {
        toggleConfirmBtn.addEventListener('click', () => {
            togglePasswordVisibility(passwordConfirmation, toggleConfirmBtn);
        });
    }
};

// Auto-initialize on DOM content loaded
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('employer-registration-form')) {
        initEmployerRegistration();
    }
});
