<?php

namespace App\Notifications;

use App\Models\Jobs\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationAcceptedAfterInterview extends Notification implements ShouldQueue
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Jobs\JobApplication $application
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
        return (new MailMessage)
            ->subject('Congratulations! Your Application Has Been Accepted')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('We are pleased to inform you that your application for the position of ' . $this->application->job->title . ' has been accepted after the interview.')
            ->line('The employer will be in touch with you shortly regarding the next steps.')
            ->action('View Application Details', route('applicant.applications.show', $this->application->id))
            ->line('Thank you for your interest in this position!');
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
            'job_title' => $this->application->job->title,
            'company_name' => $this->application->job->company->name,
            'message' => 'Your application for ' . $this->application->job->title . ' has been accepted after the interview.',
        ];
    }
}
