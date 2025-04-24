<?php

namespace App\Services;

use App\Models\Companies\CompanyInvitation;
use App\Models\Users\User;
use App\Notifications\Company\InvitationSent;
use App\Notifications\Company\InvitationAccepted;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class CompanyInvitationService
{
    /**
     * Create and send a company invitation
     *
     * @param int $companyId The company ID
     * @param string $email The invitee email
     * @param User $sender The sender user
     * @param string|null $inviteeName The invitee name (if known)
     * @return CompanyInvitation
     */
    public function createInvitation(int $companyId, string $email, User $sender, ?string $inviteeName = null): CompanyInvitation
    {
        $invitation = new CompanyInvitation();
        $invitation->company_id = $companyId;
        $invitation->email = $email;
        $invitation->name = $inviteeName;
        $invitation->token = Str::random(64);
        $invitation->created_by = $sender->id;
        $invitation->status = 'pending';
        $invitation->save();

        return $invitation;
    }

    /**
     * Send invitation notification
     *
     * @param CompanyInvitation $invitation
     * @param User|null $existingUser
     * @return void
     */
    public function sendInvitationNotification(CompanyInvitation $invitation, ?User $existingUser = null): void
    {
        // Load relationships to ensure we have all data for the notification
        $invitation->load(['company', 'creator']);

        if ($existingUser) {
            // Send to an existing user account
            $existingUser->notify(new InvitationSent($invitation));

            // Also create an in-app notification record
            $this->createInAppNotification($existingUser, $invitation);
        } else {
            // Send to an email address only
            Notification::route('mail', [
                $invitation->email => $invitation->name ?? 'Invited Employer',
            ])->notify(new InvitationSent($invitation));
        }
    }

    /**
     * Send acceptance notification
     *
     * @param CompanyInvitation $invitation
     * @param User $acceptor
     * @return void
     */
    public function sendAcceptanceNotification(CompanyInvitation $invitation, User $acceptor): void
    {
        // Load relationships to ensure we have all data for the notification
        $invitation->load(['company']);

        $creator = User::findOrFail($invitation->created_by);
        $creator->notify(new InvitationAccepted($invitation, $acceptor));
    }

    /**
     * Create an in-app notification record
     *
     * @param User $user
     * @param CompanyInvitation $invitation
     * @return void
     */
    private function createInAppNotification(User $user, CompanyInvitation $invitation): void
    {
        $user->notifications()->create([
            'type' => 'App\Notifications\Company\InvitationSent',
            'data' => [
                'type' => 'company_invitation',
                'invitation_id' => $invitation->id,
                'company_id' => $invitation->company_id,
                'company_name' => $invitation->company->name,
                'sender_name' => $invitation->creator->name,
                'token' => $invitation->token,
            ],
        ]);
    }

    /**
     * Process invitation acceptance
     *
     * @param CompanyInvitation $invitation
     * @param User $acceptor
     * @return void
     */
    public function acceptInvitation(CompanyInvitation $invitation, User $acceptor): void
    {
        // Update invitation status
        $invitation->status = 'accepted';
        $invitation->accepted_by = $acceptor->id;
        $invitation->accepted_at = now();
        $invitation->save();

        // Try to send notification to creator
        try {
            $this->sendAcceptanceNotification($invitation, $acceptor);
        } catch (\Exception $e) {
            // Continue even if notification fails
            // Consider logging the error here
        }
    }

    /**
     * Process invitation decline
     *
     * @param CompanyInvitation $invitation
     * @return void
     */
    public function declineInvitation(CompanyInvitation $invitation): void
    {
        // Update invitation status
        $invitation->status = 'declined';
        $invitation->save();

        // Optionally, here you could add notification logic to inform the creator
        // that their invitation was declined
    }
}
