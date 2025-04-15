/**
 * OTP Handler - Manages OTP input fields and countdown timer
 *
 * This utility handles:
 * 1. OTP input field navigation and auto-focus
 * 2. Countdown timer for OTP resend
 * 3. Hidden field updates for form submission and Livewire binding
 */

export default function initOtpHandler() {
    initOtpInputHandling();
    initCountdownTimer();
    preventFormResubmission();
}

/**
 * Initialize OTP input field handling with event delegation
 * This approach allows handling of dynamically added OTP inputs in Livewire
 */
function initOtpInputHandling() {
    // Use event delegation for input events
    document.body.addEventListener('input', (e) => {
        const input = e.target;
        if (!input.classList.contains('otp-input')) return;

        // Find all OTP inputs in this container
        const container = input.closest('.space-y-4');
        if (!container) return;

        const inputs = container.querySelectorAll('.otp-input');
        const hiddenOtp = container.querySelector('#otp-hidden');
        if (!inputs.length) return;

        // Find index of current input
        const index = Array.from(inputs).indexOf(input);
        const value = input.value;

        // Check if using Livewire
        let livewireEl = null;
        let livewireModel = null;
        if (hiddenOtp && hiddenOtp.hasAttribute('wire:model')) {
            livewireModel = hiddenOtp.getAttribute('wire:model');
            livewireEl = hiddenOtp.closest('[wire\\:id]');
        }

        if (value.length === 1) {
            // Normal typing - single digit
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        } else if (value.length > 1) {
            // Auto-filling or pasting multiple digits into a single field
            input.value = value.charAt(0); // Keep only first digit

            // Try to distribute the rest of the characters to following inputs
            const remainingChars = value.substring(1);
            for (let i = 0; i < remainingChars.length && (index + i + 1) < inputs.length; i++) {
                inputs[index + i + 1].value = remainingChars.charAt(i);
            }

            // Focus on the next empty input or the last one
            let focusIndex = Math.min(index + value.length, inputs.length - 1);
            inputs[focusIndex].focus();
        }

        // Update hidden field and Livewire model
        updateOTPValues(inputs, hiddenOtp, livewireEl, livewireModel);
    });

    // Handle keydown events for navigation
    document.body.addEventListener('keydown', (e) => {
        const input = e.target;
        if (!input.classList.contains('otp-input')) return;

        // Find all OTP inputs in this container
        const container = input.closest('.space-y-4');
        if (!container) return;

        const inputs = container.querySelectorAll('.otp-input');
        if (!inputs.length) return;

        // Find index of current input
        const index = Array.from(inputs).indexOf(input);

        if (e.key === 'Backspace') {
            if (!input.value && index > 0) {
                // If current field is empty and backspace is pressed, focus on previous field
                inputs[index - 1].focus();
            } else if (input.value && e.target.selectionStart === 0 && e.target.selectionEnd === 0) {
                // Cursor is at start of field with text, focus on previous field
                if (index > 0) {
                    inputs[index - 1].focus();
                    e.preventDefault(); // Prevent the backspace from happening in this field
                }
            }
        } else if (e.key === 'ArrowLeft' && index > 0) {
            e.preventDefault();
            inputs[index - 1].focus();
        } else if (e.key === 'ArrowRight' && index < inputs.length - 1) {
            e.preventDefault();
            inputs[index + 1].focus();
        }
    });

    // Handle paste events
    document.body.addEventListener('paste', (e) => {
        const input = e.target;
        if (!input.classList.contains('otp-input')) return;

        e.preventDefault();

        // Find all OTP inputs in this container
        const container = input.closest('.space-y-4');
        if (!container) return;

        const inputs = container.querySelectorAll('.otp-input');
        const hiddenOtp = container.querySelector('#otp-hidden');
        if (!inputs.length) return;

        // Find index of current input
        const index = Array.from(inputs).indexOf(input);

        // Check if using Livewire
        let livewireEl = null;
        let livewireModel = null;
        if (hiddenOtp && hiddenOtp.hasAttribute('wire:model')) {
            livewireModel = hiddenOtp.getAttribute('wire:model');
            livewireEl = hiddenOtp.closest('[wire\\:id]');
        }

        const pastedData = (e.clipboardData || window.clipboardData).getData('text');
        const numericData = pastedData.replace(/\D/g, '').substring(0, inputs.length);

        if (numericData.length === 0) return;

        // Fill in the inputs
        for (let i = 0; i < numericData.length; i++) {
            const targetIndex = index + i;
            if (targetIndex < inputs.length) {
                inputs[targetIndex].value = numericData.charAt(i);
            }
        }

        // Focus the appropriate field
        const focusIndex = Math.min(index + numericData.length, inputs.length - 1);
        inputs[focusIndex].focus();

        // Update hidden field and Livewire model
        updateOTPValues(inputs, hiddenOtp, livewireEl, livewireModel);
    });
}

/**
 * Update both the hidden OTP field and Livewire model if they exist
 */
function updateOTPValues(inputs, hiddenOtp, livewireEl, livewireModel) {
    const combinedValue = Array.from(inputs).map(input => input.value || '').join('');

    // Update hidden field if exists
    if (hiddenOtp) {
        hiddenOtp.value = combinedValue;

        // Dispatch change event to trigger any potential listeners
        const event = new Event('change', { bubbles: true });
        hiddenOtp.dispatchEvent(event);
    }

    // Update Livewire model if using Livewire
    if (livewireEl && livewireModel && window.Livewire) {
        const componentId = livewireEl.getAttribute('wire:id');
        if (componentId) {
            window.Livewire.find(componentId).set(livewireModel, combinedValue);
        }
    }
}

/**
 * Initialize countdown timer for OTP resend
 */
function initCountdownTimer() {
    // This function needs to be called whenever the DOM updates with new timers
    const setupTimers = () => {
        const resendBtns = document.querySelectorAll('#resend-otp-btn');

        resendBtns.forEach(resendBtn => {
            // Check if this timer is already initialized
            if (resendBtn.dataset.timerInitialized === 'true') return;

            const timerContainer = resendBtn.closest('div');
            if (!timerContainer) return;

            const timerSpan = timerContainer.querySelector('#otp-timer');
            const timerTextElement = timerContainer.querySelector('#timer-text');

            if (!timerSpan) return;

            // Mark as initialized
            resendBtn.dataset.timerInitialized = 'true';

            // Extract the timer value from the span and default to 60 if not set
            let timeLeft = parseInt(timerSpan.textContent) || 60;

            // Update timer text initially
            timerSpan.textContent = timeLeft;

            // Start countdown
            const countdownId = setInterval(() => {
                timeLeft--;
                if (timerSpan) timerSpan.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(countdownId);
                    enableResendButton(resendBtn, timerTextElement, timerSpan);
                    // Reset the initialized flag so it can be reinitialized if needed
                    resendBtn.dataset.timerInitialized = 'false';
                }
            }, 1000);

            // Store interval ID for cleanup
            resendBtn.dataset.countdownId = countdownId;
        });
    };

    // Initial setup
    setupTimers();

    // Setup timers when Livewire updates the DOM
    if (window.Livewire) {
        window.Livewire.hook('message.processed', () => {
            setupTimers();
        });
    }
}

/**
 * Enable the resend button and update UI when countdown is complete
 */
function enableResendButton(resendBtn, timerTextElement, timerSpan) {
    if (!resendBtn) return;

    resendBtn.disabled = false;

    // Handle different button styles based on the page
    if (resendBtn.classList.contains('bg-gray-500')) {
        // Email change page
        if (timerTextElement) {
            timerTextElement.textContent = 'You can now request a new OTP code';
        }
        resendBtn.classList.remove('bg-gray-500', 'hover:bg-gray-600');
        resendBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
    } else {
        // OTP verification page
        resendBtn.classList.remove('disabled:text-gray-400', 'disabled:cursor-not-allowed');
        resendBtn.classList.add('text-indigo-600', 'hover:underline');

        // Find and remove the timer text if it exists
        if (timerSpan) {
            const timerParent = timerSpan.parentElement;
            if (timerParent && timerParent.classList.contains('ml-2')) {
                timerParent.textContent = '';
            }
        }
    }
}

/**
 * Prevent form resubmission on page refresh
 */
function preventFormResubmission() {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
}
