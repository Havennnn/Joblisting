/**
 * Password validation utility functions
 */

/**
 * Check if password meets minimum length requirement
 * @param {string} password - The password to check
 * @param {number} minLength - The minimum required length
 * @returns {boolean} True if meets requirement
 */
export const meetsLengthRequirement = (password, minLength = 8) => {
    return password.length >= minLength;
};

/**
 * Check if password has at least one uppercase letter
 * @param {string} password - The password to check
 * @returns {boolean} True if meets requirement
 */
export const hasUppercase = (password) => {
    return /[A-Z]/.test(password);
};

/**
 * Check if password has at least one number
 * @param {string} password - The password to check
 * @returns {boolean} True if meets requirement
 */
export const hasNumber = (password) => {
    return /[0-9]/.test(password);
};

/**
 * Gets SVG path for success checkmark
 * @returns {string} SVG path for checkmark icon
 */
export const getSuccessPath = () => {
    return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
};

/**
 * Gets SVG path for failure X mark
 * @returns {string} SVG path for X icon
 */
export const getFailurePath = () => {
    return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
};
