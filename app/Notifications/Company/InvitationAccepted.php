<?php

namespace App\Notifications\Company;

use App\Models\Companies\CompanyInvitation;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $invitation;
    protected $acceptor;

    /**
     * Create a new notification instance.
     */
    public function __construct(CompanyInvitation $invitation, User $acceptor)
    {
        $this->invitation = $invitation;
        $this->acceptor = $acceptor;
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
        // Make sure company is loaded
        if (!$this->invitation->relationLoaded('company')) {
            $this->invitation->load('company');
        }

        return (new MailMessage)
            ->subject('Company Invitation Accepted')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->acceptor->name . ' has accepted your invitation to join ' . $this->invitation->company->name . '.')
            ->line('They are now a member of your company.')
            ->action('View Company Members', route('employer.company.index'))
            ->line('Thank you for using Neksjob!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'invitation_accepted',
            'invitation_id' => $this->invitation->id,
            'company_id' => $this->invitation->company_id,
            'company_name' => $this->invitation->company->name,
            'acceptor_name' => $this->acceptor->name,
            'acceptor_email' => $this->acceptor->email,
            'accepted_at' => $this->invitation->accepted_at,
        ];
    }
}
