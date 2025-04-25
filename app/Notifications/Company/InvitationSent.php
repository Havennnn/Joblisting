<?php

namespace App\Notifications\Company;

use App\Models\Companies\CompanyInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationSent extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invitation;

    /**
     * Create a new notification instance.
     */
    public function __construct(CompanyInvitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $acceptUrl = route('employer.company.invite.accept', $this->invitation->token);
        $creatorName = $this->invitation->creator ? $this->invitation->creator->name : 'A company administrator';
        $companyName = $this->invitation->company ? $this->invitation->company->name : 'a company';

        return (new MailMessage)
            ->subject('You have been invited to join a company')
            ->greeting('Hello!')
            ->line("You have been invited to join {$companyName} on Neksjob.")
            ->line("This invitation was sent by {$creatorName}.")
            ->action('Accept Invitation', $acceptUrl)
            ->line('If you already have an account, you will need to log in first. If you do not have an account, you will need to register as an employer.')
            ->line('This invitation link will expire in 7 days.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $creatorName = $this->invitation->creator ? $this->invitation->creator->name : 'A company administrator';
        $companyName = $this->invitation->company ? $this->invitation->company->name : 'a company';

        return [
            'type' => 'company_invitation',
            'invitation_id' => $this->invitation->id,
            'company_id' => $this->invitation->company_id,
            'company_name' => $companyName,
            'sender_name' => $creatorName,
            'token' => $this->invitation->token,
        ];
    }
}
