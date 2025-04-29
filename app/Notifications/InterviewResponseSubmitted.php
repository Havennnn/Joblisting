<?php

namespace App\Notifications;

use App\Models\Interviews\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InterviewResponseSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The interview instance.
     *
     * @var \App\Models\Interviews\Interview
     */
    protected $interview;

    /**
     * The response type (accepted or declined).
     *
     * @var string
     */
    protected $responseType;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Interviews\Interview  $interview
     * @param  string  $responseType  'accepted' or 'declined'
     * @return void
     */
    public function __construct(Interview $interview, string $responseType)
    {
        $this->interview = $interview;
        $this->responseType = $responseType;
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
        $applicantName = $this->interview->applicant->name;
        $interviewDate = $this->interview->interview_date->format('l, F j, Y');
        $startTime = $this->interview->start_time->format('g:i A');

        $mailMessage = (new MailMessage)
            ->subject("Interview {$this->responseType} for {$jobTitle}");

        if ($this->responseType === 'accepted') {
            return $mailMessage
                ->greeting("Hello!")
                ->line("{$applicantName} has accepted the interview for \"{$jobTitle}\".")
                ->line("**Interview Details:**")
                ->line("- Date: {$interviewDate}")
                ->line("- Start Time: {$startTime}")
                ->action('View Applications', url(route('employer.applications.index')))
                ->line('The candidate will be present for the scheduled interview.');
        } else {
            $reason = !empty($this->interview->notes)
                ? "Reason provided: {$this->interview->notes}"
                : "No reason was provided.";

            return $mailMessage
                ->greeting("Hello!")
                ->line("{$applicantName} has declined the interview for \"{$jobTitle}\".")
                ->line("**Scheduled Interview Details:**")
                ->line("- Date: {$interviewDate}")
                ->line("- Start Time: {$startTime}")
                ->line($reason)
                ->action('View Applications', url(route('employer.applications.index')))
                ->line('You may want to contact the candidate or schedule an interview with another candidate.');
        }
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
            'applicant_id' => $this->interview->applicant_id,
            'applicant_name' => $this->interview->applicant->name,
            'interview_date' => $this->interview->interview_date->toDateString(),
            'start_time' => $this->interview->start_time->toDateTimeString(),
            'response_type' => $this->responseType,
        ];
    }
}
