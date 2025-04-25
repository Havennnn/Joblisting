<?php

namespace App\Http\Controllers\Employer\Company;

use App\Models\Jobs\JobPost;
use App\Models\Users\Employer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteCompanyController extends CompanyController
{
    /**
     * Delete the company and all associated data
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        if (!$this->company || !$this->isOwner) {
            return redirect()->route('employer.company.index')
                ->with('error', 'You must be the company owner to delete it.');
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Get company ID for reference
            $companyId = $this->company->id;
            $companyName = $this->company->name;

            // Get all job posts related to this company
            $jobPosts = JobPost::where('company_id', $companyId)->get();
            $deletedJobCount = 0;

            // Delete all job posts
            foreach ($jobPosts as $jobPost) {
                $jobPost->delete();
                $deletedJobCount++;
            }

            // Get all employers in this company
            $employers = Employer::where('company_id', $companyId)->get();

            // Remove all employers from the company
            foreach ($employers as $employer) {
                $employer->company_id = null;
                $employer->save();
            }

            // Now delete the company
            $this->company->delete();

            // Commit the transaction
            DB::commit();

            // Log the company deletion
            Log::info('Company deleted', [
                'company_id' => $companyId,
                'company_name' => $companyName,
                'deleted_by' => $this->user->id,
                'deleted_by_name' => $this->user->name,
                'job_posts_deleted' => $deletedJobCount
            ]);

            return redirect()->route('employer.dashboard')
                ->with('success', 'Company "' . $companyName . '" has been deleted successfully along with all its data.');

        } catch (\Exception $e) {
            // Roll back in case of error
            DB::rollBack();

            Log::error('Error deleting company', [
                'company_id' => $this->company->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('employer.company.index')
                ->with('error', 'Failed to delete company. Please try again or contact support.');
        }
    }
}
