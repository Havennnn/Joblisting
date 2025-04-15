<?php

namespace App\Livewire\Settings\Email;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OtpMail;

class ChangeEmail extends Component
{
    public $user;
    public $currentEmail;
    public $newEmail;
    public $otp;
    public $password;

    // UI State Management
    public $isChangingEmail = false;
    public $isVerifyingEmail = false;
    public $emailChangeRequested = false;
    public $canResendOtp = false;
    public $otpResendTimer = 60;

    protected $rules = [
        'newEmail' => 'required|email|unique:users,email',
        'password' => 'required|current_password',
        'otp' => 'sometimes|required|digits:6',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->currentEmail = $this->user->email;

        // Check if there's a pending email change
        $this->emailChangeRequested = session()->has('pending_email_change');
        if ($this->emailChangeRequested) {
            $this->newEmail = session('pending_email_change');
        }

        // Initialize OTP timer when verification is active
        if ($this->isVerifyingEmail) {
            $this->updateOtpTimer();
        } else {
            $this->canResendOtp = true;
        }
    }

    public function startEmailChange()
    {
        // If there's a pending email change, ask user if they want to continue or start over
        if ($this->emailChangeRequested) {
            // User already has a pending email change, let them decide
            // We'll just continue with the form for now
            session()->flash('info', 'You already have a pending email change request. You can continue with it or enter a new email address.');
        }

        $this->isChangingEmail = true;
        $this->isVerifyingEmail = false;
    }

    public function cancelEmailChange()
    {
        $this->resetEmailChangeForms();
    }

    public function showOtpVerification()
    {
        if (!$this->emailChangeRequested || !$this->newEmail) {
            session()->flash('error', 'No pending email change found. Please try again.');
            return;
        }

        $this->isChangingEmail = false;
        $this->isVerifyingEmail = true;
    }

    public function initiateEmailChange()
    {
        $this->validate([
            'newEmail' => 'required|email|unique:users,email',
            'password' => 'required|current_password',
        ]);

        try {
            // Store the new email temporarily in session
            session(['pending_email_change' => $this->newEmail]);
            $this->emailChangeRequested = true;

            // Generate and send OTP to the new email
            $this->generateOtpForEmailChange($this->user, $this->newEmail);

            // Show verification screen
            $this->isChangingEmail = false;
            $this->isVerifyingEmail = true;
            $this->canResendOtp = false;
            $this->otpResendTimer = 60;

            // Flash success message
            session()->flash('status', 'Verification code sent to your new email address. Please enter the 6-digit code below to complete your email change.');

            // Log the action
            Log::info("Email change initiated", ['user_id' => $this->user->id, 'new_email' => $this->newEmail]);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send verification code. Please try again.');
            Log::error("Email change initiation failed", ['user_id' => $this->user->id, 'error' => $e->getMessage()]);
        }
    }

    public function resendOtp()
    {
        try {
            // Check for cooldown
            $otpCooldownKey = 'otp_requested_at_' . $this->user->id;
            $lastOtpTime = session($otpCooldownKey);

            // If there's a last OTP time and it's been less than 1 minute
            if ($lastOtpTime && now()->diffInSeconds($lastOtpTime) < 60) {
                $remainingTime = 60 - now()->diffInSeconds($lastOtpTime);
                $this->otpResendTimer = $remainingTime;
                $this->canResendOtp = false;
                session()->flash('error', 'Please wait before requesting a new OTP.');
                return;
            }

            // Store OTP request timestamp
            session([$otpCooldownKey => now()]);
            $this->otpResendTimer = 60;
            $this->canResendOtp = false;

            // Re-generate and send OTP
            $this->generateOtpForEmailChange($this->user, $this->newEmail);

            session()->flash('status', 'A new verification code has been sent to your email.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to resend verification code. Please try again.');
            Log::error("OTP resend failed", ['user_id' => $this->user->id, 'error' => $e->getMessage()]);
        }
    }

    public function verifyEmailChange()
    {
        $this->validate([
            'otp' => 'required|digits:6',
        ]);

        try {
            if (!$this->newEmail) {
                session()->flash('error', 'Email change request expired. Please try again.');
                $this->resetEmailChangeForms();
                return;
            }

            // Verify OTP
            $verified = $this->verifyOtpForEmailChange($this->user, $this->newEmail, $this->otp);

            if (!$verified) {
                $this->addError('otp', 'Invalid verification code or it has expired.');
                return;
            }

            // Update email
            $this->user->email = $this->newEmail;
            $this->user->email_verified_at = now();
            $this->user->save();

            // Update currentEmail property
            $this->currentEmail = $this->newEmail;

            // Clear session and reset forms
            session()->forget('pending_email_change');
            $this->resetEmailChangeForms();
            $this->emailChangeRequested = false;

            // Flash success message
            session()->flash('success', 'Email address has been updated and verified.');

            // Log the action
            Log::info("Email changed successfully", ['user_id' => $this->user->id, 'new_email' => $this->newEmail]);

            // Emit event for parent component
            $this->dispatch('emailUpdated', $this->currentEmail);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to verify email change. Please try again.');
            Log::error("Email verification failed", ['user_id' => $this->user->id, 'error' => $e->getMessage()]);
        }
    }

    protected function resetEmailChangeForms()
    {
        $this->isChangingEmail = false;
        $this->isVerifyingEmail = false;
        $this->reset(['otp', 'password']);
        if (!$this->emailChangeRequested) {
            $this->reset(['newEmail']);
        }
    }

    /**
     * Generate OTP for email change verification
     */
    protected function generateOtpForEmailChange($user, $newEmail)
    {
        $otp = rand(100000, 999999);

        // Store OTP in session with different key for email change
        session([
            'email_change_otp_' . $user->id => $otp,
            'email_change_otp_expires_at_' . $user->id => now()->addMinutes(10)
        ]);

        try {
            // Send OTP to the new email
            Log::info("Sending email change OTP to: " . $newEmail);
            Mail::to($newEmail)->send(new OtpMail($newEmail, $otp, route('settings.index')));
            Log::info("Email change OTP sent successfully to: " . $newEmail);
        } catch (\Exception $e) {
            Log::error("Failed to send email change OTP: " . $e->getMessage());
            Log::error($e->getTraceAsString());
            throw $e; // Re-throw to be caught by the caller
        }
    }

    /**
     * Verify OTP for email change
     */
    protected function verifyOtpForEmailChange($user, $newEmail, $otp)
    {
        $storedOtp = session('email_change_otp_' . $user->id);
        $expiresAt = session('email_change_otp_expires_at_' . $user->id);

        if (!$storedOtp || !$expiresAt) {
            return false;
        }

        if (now()->isAfter($expiresAt)) {
            // OTP expired
            session()->forget(['email_change_otp_' . $user->id, 'email_change_otp_expires_at_' . $user->id]);
            return false;
        }

        if ((string)$storedOtp !== (string)$otp) {
            return false;
        }

        // Clear OTP from session after successful verification
        session()->forget(['email_change_otp_' . $user->id, 'email_change_otp_expires_at_' . $user->id]);

        return true;
    }

    public function render()
    {
        // Update OTP timer if needed
        $this->updateOtpTimer();

        return view('livewire.settings.email.change-email');
    }

    /**
     * Update OTP timer and resend ability
     */
    protected function updateOtpTimer()
    {
        if ($this->isVerifyingEmail) {
            $otpCooldownKey = 'otp_requested_at_' . $this->user->id;
            $lastOtpTime = session($otpCooldownKey);

            if ($lastOtpTime) {
                $elapsedSeconds = now()->diffInSeconds($lastOtpTime);

                if ($elapsedSeconds < 60) {
                    $this->otpResendTimer = 60 - $elapsedSeconds;
                    $this->canResendOtp = false;
                } else {
                    $this->canResendOtp = true;
                }
            } else {
                $this->canResendOtp = true;
            }
        }
    }
}
