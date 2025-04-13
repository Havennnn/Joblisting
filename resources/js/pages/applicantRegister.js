import { initializePasswordValidation } from '../components/passwordStrengthIndicator.js';
import { togglePasswordVisibility } from '../utils/passwordVisibility.js';

/**
 * Initialize the applicant registration form
 */
export const initApplicantRegistration = () => {
    document.addEventListener('DOMContentLoaded', () => {
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
    });
};
