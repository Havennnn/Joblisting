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
    document.body.addEventListener('input', (e) => {
        const input = e.target;
        if (!input.classList.contains('otp-input')) return;

        const container = findOtpContainer(input);
        if (!container) return;

        const inputs = Array.from(container.querySelectorAll('.otp-input'));
        const hiddenOtp = container.closest('form').querySelector('#otp-hidden');
        if (!inputs.length) return;

        const index = inputs.indexOf(input);
        const value = input.value;

        let livewireEl = null;
        let livewireModel = null;
        if (hiddenOtp && hiddenOtp.hasAttribute('wire:model')) {
            livewireModel = hiddenOtp.getAttribute('wire:model');
            livewireEl = hiddenOtp.closest('[wire\\:id]');
        }

        if (value.length === 1) {
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        } else if (value.length > 1) {
            input.value = value.charAt(0);

            const remainingChars = value.substring(1);
            for (let i = 0; i < remainingChars.length && (index + i + 1) < inputs.length; i++) {
                inputs[index + i + 1].value = remainingChars.charAt(i);
            }

            let focusIndex = Math.min(index + value.length, inputs.length - 1);
            inputs[focusIndex].focus();
        }

        updateOTPValues(inputs, hiddenOtp, livewireEl, livewireModel);
    });

    document.body.addEventListener('keydown', (e) => {
        const input = e.target;
        if (!input.classList.contains('otp-input')) return;

        const container = findOtpContainer(input);
        if (!container) return;

        const inputs = Array.from(container.querySelectorAll('.otp-input'));
        if (!inputs.length) return;

        const index = inputs.indexOf(input);

        if (e.key === 'Backspace') {
            if (!input.value && index > 0) {
                inputs[index - 1].focus();
            } else if (input.value && e.target.selectionStart === 0 && e.target.selectionEnd === 0) {
                if (index > 0) {
                    inputs[index - 1].focus();
                    e.preventDefault();
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

    document.body.addEventListener('paste', (e) => {
        const input = e.target;
        if (!input.classList.contains('otp-input')) return;

        e.preventDefault();

        const container = findOtpContainer(input);
        if (!container) return;

        const inputs = Array.from(container.querySelectorAll('.otp-input'));
        const hiddenOtp = container.closest('form').querySelector('#otp-hidden');
        if (!inputs.length) return;

        const index = inputs.indexOf(input);

        let livewireEl = null;
        let livewireModel = null;
        if (hiddenOtp && hiddenOtp.hasAttribute('wire:model')) {
            livewireModel = hiddenOtp.getAttribute('wire:model');
            livewireEl = hiddenOtp.closest('[wire\\:id]');
        }

        const pastedData = (e.clipboardData || window.clipboardData).getData('text');
        const numericData = pastedData.replace(/\D/g, '').substring(0, inputs.length);

        if (numericData.length === 0) return;

        for (let i = 0; i < numericData.length; i++) {
            const targetIndex = index + i;
            if (targetIndex < inputs.length) {
                inputs[targetIndex].value = numericData.charAt(i);
            }
        }

        const focusIndex = Math.min(index + numericData.length, inputs.length - 1);
        inputs[focusIndex].focus();

        updateOTPValues(inputs, hiddenOtp, livewireEl, livewireModel);
    });
}

/**
 * Update both the hidden OTP field and Livewire model if they exist
 */
function updateOTPValues(inputs, hiddenOtp, livewireEl, livewireModel) {
    const combinedValue = inputs.map(input => input.value || '').join('');

    if (hiddenOtp) {
        hiddenOtp.value = combinedValue;

        const event = new Event('change', { bubbles: true });
        hiddenOtp.dispatchEvent(event);
    }

    if (livewireEl && livewireModel && window.Livewire) {
        const componentId = livewireEl.getAttribute('wire:id');
        if (componentId) {
            window.Livewire.find(componentId).set(livewireModel, combinedValue);
        }
    }
}

/**
 * Helper function to find the closest form container for OTP inputs
 * This provides more flexibility than relying on a specific class
 */
function findOtpContainer(input) {
    let container = input.closest('.space-y-6');

    if (!container) {
        container = input.closest('form') ||
                   input.closest('.space-y-4') ||
                   input.closest('.otp-container') ||
                   input.closest('.form-container');
    }

    return container;
}

/**
 * Initialize countdown timer for OTP resend
 */
function initCountdownTimer() {
    const setupTimers = () => {
        const resendBtns = document.querySelectorAll('#resend-otp-btn');

        resendBtns.forEach(resendBtn => {
            if (resendBtn.dataset.timerInitialized === 'true') return;

            const timerContainer = resendBtn.closest('div');
            if (!timerContainer) return;

            const timerSpan = timerContainer.querySelector('#otp-timer');
            const timerTextElement = timerContainer.querySelector('#timer-text');

            if (!timerSpan) return;

            resendBtn.dataset.timerInitialized = 'true';

            let timeLeft = parseInt(timerSpan.textContent) || 60;

            timerSpan.textContent = timeLeft;

            const countdownId = setInterval(() => {
                timeLeft--;
                if (timerSpan) timerSpan.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(countdownId);
                    enableResendButton(resendBtn, timerTextElement, timerSpan);
                    resendBtn.dataset.timerInitialized = 'false';
                }
            }, 1000);

            resendBtn.dataset.countdownId = countdownId;
        });
    };

    setupTimers();

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

    if (resendBtn.classList.contains('bg-gray-500')) {
        if (timerTextElement) {
            timerTextElement.textContent = 'You can now request a new OTP code';
        }
        resendBtn.classList.remove('bg-gray-500', 'hover:bg-gray-600');
        resendBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
    } else {
        resendBtn.classList.remove('disabled:text-gray-400', 'disabled:cursor-not-allowed');
        resendBtn.classList.add('text-indigo-600', 'hover:underline');

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
