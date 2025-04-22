import {
    meetsLengthRequirement,
    hasUppercase,
    hasNumber,
    getSuccessPath,
    getFailurePath
} from '../utils/passwordValidation.js';

/**
 * Updates the UI to show password validation status
 */
export const updatePasswordValidationUI = (elements, password) => {
    const {
        lengthElement,
        uppercaseElement,
        numberElement,
        lengthIcon,
        uppercaseIcon,
        numberIcon
    } = elements;

    if (meetsLengthRequirement(password)) {
        lengthElement.classList.remove('text-red-600');
        lengthElement.classList.add('text-green-600');
        lengthIcon.innerHTML = getSuccessPath();
    } else {
        lengthElement.classList.remove('text-green-600');
        lengthElement.classList.add('text-red-600');
        lengthIcon.innerHTML = getFailurePath();
    }

    if (hasUppercase(password)) {
        uppercaseElement.classList.remove('text-red-600');
        uppercaseElement.classList.add('text-green-600');
        uppercaseIcon.innerHTML = getSuccessPath();
    } else {
        uppercaseElement.classList.remove('text-green-600');
        uppercaseElement.classList.add('text-red-600');
        uppercaseIcon.innerHTML = getFailurePath();
    }

    if (hasNumber(password)) {
        numberElement.classList.remove('text-red-600');
        numberElement.classList.add('text-green-600');
        numberIcon.innerHTML = getSuccessPath();
    } else {
        numberElement.classList.remove('text-green-600');
        numberElement.classList.add('text-red-600');
        numberIcon.innerHTML = getFailurePath();
    }
};

/**
 * Initialize the password validation UI by gathering elements and setting up events
 */
export const initializePasswordValidation = (passwordFieldId) => {
    const passwordField = document.getElementById(passwordFieldId);
    const lengthValidation = document.getElementById('length-validation');
    const uppercaseValidation = document.getElementById('uppercase-validation');
    const numberValidation = document.getElementById('number-validation');
    const lengthIcon = document.getElementById('length-icon');
    const uppercaseIcon = document.getElementById('uppercase-icon');
    const numberIcon = document.getElementById('number-icon');

    const elements = {
        lengthElement: lengthValidation,
        uppercaseElement: uppercaseValidation,
        numberElement: numberValidation,
        lengthIcon: lengthIcon,
        uppercaseIcon: uppercaseIcon,
        numberIcon: numberIcon
    };

    updatePasswordValidationUI(elements, passwordField.value);

    passwordField.addEventListener('input', () => {
        updatePasswordValidationUI(elements, passwordField.value);
    });

    return elements;
};
