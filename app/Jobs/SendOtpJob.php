<?php

namespace App\Jobs;

use App\Mail\OtpMail;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $otp;
    public $verificationLink;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, $otp, $verificationLink)
    {
        $this->user = $user;
        $this->otp = $otp;
        $this->verificationLink = $verificationLink;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Always send email - this is the priority method
            Log::info("Attempting to send OTP email to: {$this->user->email}");

            // Debug mail configuration
            Log::debug("Mail Configuration: " . json_encode([
                'driver' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'from_address' => config('mail.from.address'),
                'queue_connection' => config('queue.default'),
            ]));

            Mail::to($this->user->email)->send(new OtpMail($this->user->email, $this->otp, $this->verificationLink));
            Log::info("OTP email sent successfully to user: {$this->user->email}");
        } catch (\Exception $e) {
            Log::error("Failed to send OTP email: " . $e->getMessage());
            Log::error("Exception stack trace: " . $e->getTraceAsString());
            throw $e; // Re-throw to let Laravel handle the job failure
        }
    }
}
