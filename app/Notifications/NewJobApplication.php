<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobApplication extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The job application instance.
     *
     * @var \App\Models\JobApplication
     */
    protected $application;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\JobApplication  $application
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
        $jobTitle = $this->application->job->title;
        $applicantName = $this->application->applicant->name;

        return (new MailMessage)
            ->subject("New Job Application: {$jobTitle}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("You have received a new application for \"{$jobTitle}\" from {$applicantName}.")
            ->action('View Application', url(route('employer.applications.show', $this->application->id)))
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
            'applicant_id' => $this->application->applicant_id,
            'applicant_name' => $this->application->applicant->name,
            'applied_at' => $this->application->applied_at->toDateTimeString(),
        ];
    }
}
