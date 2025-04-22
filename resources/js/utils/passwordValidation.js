/**
 * Password validation utility functions
 */

export const meetsLengthRequirement = (password, minLength = 8) => {
    return password.length >= minLength;
};

export const hasUppercase = (password) => {
    return /[A-Z]/.test(password);
};

export const hasNumber = (password) => {
    return /[0-9]/.test(password);
};

export const getSuccessPath = () => {
    return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
};

export const getFailurePath = () => {
    return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
};
