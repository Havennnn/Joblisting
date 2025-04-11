<?php

namespace App\Notifications;

use App\Models\Jobs\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The job application instance.
     *
     * @var \App\Models\Jobs\JobApplication
     */
    protected $application;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Jobs\JobApplication  $application
     * @return void
     */
    public function __construct(JobApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $statusText = ucfirst($this->application->status);
        $jobTitle = $this->application->job->title;
        $companyName = $this->application->job->employer->company_name ?? 'the employer';

        return (new MailMessage)
            ->subject("Job Application Status Update: {$statusText}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("Your application for the position of \"{$jobTitle}\" at {$companyName} has been updated.")
            ->line("Status: **{$statusText}**")
            ->action('View Application Details', url(route('applicant.applications.index')))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'job_title' => $this->application->job->title,
            'employer_id' => $this->application->employer_id,
            'employer_name' => $this->application->employer->company_name ?? 'Employer',
            'status' => $this->application->status,
            'updated_at' => now()->toDateTimeString(),
        ];
    }
}
