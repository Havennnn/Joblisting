import './bootstrap';
import { initApplicantRegistration } from './pages/applicantRegister.js';
import { initEmployerRegistration } from './pages/employerRegister.js';

// Initialize the scripts based on the current page
document.addEventListener('DOMContentLoaded', () => {
    // Check if we're on the applicant registration page
    if (document.getElementById('applicant-registration-form')) {
        initApplicantRegistration();
    }

    // Check if we're on the employer registration page
    if (document.getElementById('employer-registration-form')) {
        initEmployerRegistration();
    }
});
