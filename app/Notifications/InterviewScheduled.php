<?php

namespace App\Notifications;

use App\Models\Interviews\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InterviewScheduled extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The interview instance.
     *
     * @var \App\Models\Interviews\Interview
     */
    protected $interview;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Interviews\Interview  $interview
     * @return void
     */
    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
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
        $jobTitle = $this->interview->job->title;
        $companyName = $this->interview->job->employer->company_name ?? 'the employer';
        $interviewDate = $this->interview->interview_date->format('l, F j, Y');
        $startTime = $this->interview->start_time->format('g:i A');

        $locationType = $this->interview->is_online ? 'Virtual Interview' : 'In-Person Interview';

        // Handle potentially missing location/link information
        $locationDetails = '';
        if ($this->interview->is_online) {
            $locationDetails = $this->interview->meeting_link
                ? "Meeting Link: {$this->interview->meeting_link}"
                : "Virtual interview (no meeting link provided yet)";
        } else {
            $locationDetails = $this->interview->location
                ? "Location: {$this->interview->location}"
                : "In-person interview (no location specified yet)";
        }

        return (new MailMessage)
            ->subject("Interview Scheduled for {$jobTitle}")
            ->greeting("Hello {$notifiable->name}!")
            ->line("You have been scheduled for an interview for the position of \"{$jobTitle}\" at {$companyName}.")
            ->line("**Interview Details:**")
            ->line("- Date: {$interviewDate}")
            ->line("- Start Time: {$startTime}")
            ->line("- Type: {$locationType}")
            ->line("- {$locationDetails}")
            ->action('View Application Details', url(route('applicant.applications.index')))
            ->line('Please be prepared and on time for your interview. Good luck!');
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
            'interview_id' => $this->interview->id,
            'job_id' => $this->interview->job_id,
            'job_title' => $this->interview->job->title,
            'employer_id' => $this->interview->employer_id,
            'employer_name' => $this->interview->job->employer->company_name ?? 'Employer',
            'interview_date' => $this->interview->interview_date->toDateString(),
            'start_time' => $this->interview->start_time->toDateTimeString(),
            'is_online' => $this->interview->is_online,
            'location' => $this->interview->location,
            'meeting_link' => $this->interview->meeting_link,
        ];
    }
}
