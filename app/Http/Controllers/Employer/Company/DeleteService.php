<?php

namespace App\Http\Controllers\Employer\Company;

use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyInvitation;
use App\Models\Jobs\JobPost;
use App\Models\Users\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Service class for deletion operations within the company context
 */
class DeleteService
{
    /**
     * Delete a job post
     *
     * @param  int  $id
     * @param  Employer $employer
     * @param  Company $company
     * @param  bool $isOwner
     * @return array [success: bool, message: string]
     */
    public function deleteJobPost($id, $employer, $company, $isOwner)
    {
        if (!$company) {
            return [
                'success' => false,
                'message' => 'You must belong to a company to perform this action.'
            ];
        }

        try {
            $companyEmployerIds = $company->employers()->pluck('id')->toArray();
            $jobPost = JobPost::findOrFail($id);

            if (!in_array($jobPost->employer_id, $companyEmployerIds)) {
                return [
                    'success' => false,
                    'message' => 'This job post does not belong to your company.'
                ];
            }

            if (!$isOwner && $jobPost->employer_id !== $employer->id) {
                return [
                    'success' => false,
                    'message' => 'You do not have permission to delete this job post.'
                ];
            }

            $jobPost->delete();

            return [
                'success' => true,
                'message' => 'Job post has been deleted successfully.'
            ];
        } catch (\Exception $e) {
            Log::error('Error deleting job post', [
                'job_post_id' => $id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while deleting the job post.'
            ];
        }
    }

    /**
     * Cancel an invitation
     *
     * @param  int  $id
     * @param  Company $company
     * @return array [success: bool, message: string]
     */
    public function cancelInvite($id, $company)
    {
        if (!$company) {
            return [
                'success' => false,
                'message' => 'You must belong to a company to cancel invitations.'
            ];
        }

        try {
            $invitation = CompanyInvitation::where('id', $id)
                ->where('company_id', $company->id)
                ->where('status', 'pending')
                ->firstOrFail();

            $invitation->status = 'cancelled';
            $invitation->save();

            return [
                'success' => true,
                'message' => 'Invitation cancelled successfully.'
            ];
        } catch (\Exception $e) {
            Log::error('Error cancelling invitation', [
                'invitation_id' => $id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while cancelling the invitation.'
            ];
        }
    }

    /**
     * Kick a member from the company.
     *
     * @param  int  $id
     * @param  Employer $currentEmployer
     * @param  Company $company
     * @return array [success: bool, message: string]
     */
    public function kickMember($id, $currentEmployer, $company)
    {
        if (!$company || $currentEmployer->id === (int)$id) {
            return [
                'success' => false,
                'message' => 'You cannot remove yourself from the company.'
            ];
        }

        try {
            $employer = Employer::findOrFail($id);

            if ($employer->company_id !== $company->id) {
                return [
                    'success' => false,
                    'message' => 'This employer is not a member of your company.'
                ];
            }

            // Start a database transaction
            DB::beginTransaction();

            // Get all job posts created by this employer within the company
            $jobPosts = JobPost::where('employer_id', $employer->id)
                ->get();

            $deletedCount = 0;

            // Delete each job post
            foreach ($jobPosts as $jobPost) {
                $jobPost->delete();
                $deletedCount++;
            }

            $employer->company_id = null;
            $employer->save();

            // Commit the transaction
            DB::commit();

            $message = 'Member has been removed from the company.';
            if ($deletedCount > 0) {
                $message .= " {$deletedCount} job posts associated with this member have been deleted.";
            }

            return [
                'success' => true,
                'message' => $message
            ];
        } catch (\Exception $e) {
            // Roll back the transaction if something goes wrong
            DB::rollBack();

            Log::error('Error kicking member', [
                'employer_id' => $id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to remove member from company. Please try again.'
            ];
        }
    }
}
