import { initializePasswordValidation } from '../components/passwordStrengthIndicator.js';
import { togglePasswordVisibility } from '../utils/passwordVisibility.js';

/**
 * Initialize the applicant registration form
 */
const initApplicantRegistration = () => {
    initializePasswordValidation('password');

    const passwordField = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const toggleConfirmBtn = document.getElementById('toggleConfirmPassword');

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

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('applicant-registration-form')) {
        initApplicantRegistration();
    }
});
