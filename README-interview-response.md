# Interview Response Functionality

This feature allows applicants to accept or decline interview invitations directly from their "My Applications" page.

## Implementation Details

### Features Added

1. **Interview Response Options**: Applicants can now accept or decline interview invitations when the application status is "to_be_interviewed".
2. **Interview Status Display**: Applications show different UI based on the interview status (pending, accepted, declined).
3. **Decline Reason**: Applicants can provide an optional reason when declining an interview.
4. **Employer Notifications**: Employers receive notifications when applicants respond to interview invitations.

### Files Changed/Created

1. **Controllers**:

    - `InterviewResponseController.php`: Added methods to handle accept/decline actions
    - `MyApplications/IndexController.php`: Updated to eager load interview relation

2. **Models**:

    - `JobApplication.php`: Added interview relationship and interview_status field

3. **Views**:

    - `applications/index.blade.php`: Updated to display interview information and response buttons

4. **Notifications**:

    - `InterviewResponseSubmitted.php`: Created to notify employers of applicant responses

5. **Routes**:

    - `applicant.php`: Added routes for interview accept/decline endpoints

6. **Database Changes**:
    - `job_applications` table: Added `interview_status` column

## How It Works

1. When an employer schedules an interview, the application status changes to "to_be_interviewed"
2. The applicant sees the interview details and options to accept or decline in their applications list
3. Upon acceptance, the interview status updates to "accepted"
4. Upon declining, the applicant can provide a reason, and the status updates to "declined"
5. The employer receives a notification of the applicant's response

## Testing

To test this functionality:

1. Login as an employer and schedule an interview for an applicant
2. Login as the applicant and navigate to "My Applications"
3. The interview details and response options should be visible
4. Test both accept and decline flows
5. Verify the employer receives appropriate notifications
