<?php

namespace App\Livewire\Applicant;

use App\Models\User;
use App\Models\ApplicantProfile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileSetup extends Component
{
    use WithFileUploads;

    // Step tracking
    public $currentStep = 1;

    // User data properties
    public $full_name;
    public $email;
    public $phone_number;
    public $location;
    public $gender;
    public $age;

    // Professional details
    public $field;
    public $skills;
    public $years_experience;

    // Document uploads
    public $profile_picture;
    public $resume;

    // Temporary URLs for preview
    public $profile_picture_preview;
    public $resume_name;

    /**
     * Initialize the component.
     */
    public function mount()
    {
        $user = Auth::user();
        $profile = $user->applicantProfile;

        // Pre-fill form with user data if available
        $this->full_name = $user->name;
        $this->email = $user->email;

        // Get values from applicant profile if it exists
        if ($profile) {
            $this->phone_number = $profile->phone_number;
            $this->location = $profile->location;
            $this->gender = $profile->gender;
            $this->age = $profile->age;
            $this->field = $profile->field;
            $this->skills = $profile->skills;
            $this->years_experience = $profile->years_experience;

            // Set profile picture preview if exists
            if ($profile->profile_picture_path && Storage::disk('public')->exists($profile->profile_picture_path)) {
                $this->profile_picture_preview = Storage::url($profile->profile_picture_path);
            }
        } else {
            // Fallback to user fields if no profile exists yet (for backwards compatibility)
            if (isset($user->phone_number)) $this->phone_number = $user->phone_number;
            if (isset($user->location)) $this->location = $user->location;
            if (isset($user->gender)) $this->gender = $user->gender;
            if (isset($user->age)) $this->age = $user->age;
            if (isset($user->field)) $this->field = $user->field;
            if (isset($user->skills)) $this->skills = $user->skills;
            if (isset($user->years_experience)) $this->years_experience = $user->years_experience;
        }
    }

    // Step navigation methods
    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validateBasicInfo();
        } elseif ($this->currentStep == 2) {
            $this->validateProfessionalInfo();
        }

        $this->currentStep++;
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    // Validation methods
    protected function validateBasicInfo()
    {
        $this->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,other',
            'age' => 'required|integer|min:18',
        ]);
    }

    protected function validateProfessionalInfo()
    {
        $this->validate([
            'field' => 'required|string|max:255',
            'skills' => 'required|string',
            'years_experience' => 'required|integer|min:0',
        ]);
    }

    // File upload preview methods
    public function updatedProfilePicture()
    {
        $this->validate([
            'profile_picture' => 'image|max:1024', // 1MB max
        ]);

        // Create temporary URL for preview
        $this->profile_picture_preview = $this->profile_picture->temporaryUrl();
    }

    public function updatedResume()
    {
        $this->validate([
            'resume' => 'file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        // Store filename for display
        $this->resume_name = $this->resume->getClientOriginalName();
    }

    /**
     * Save the user profile data.
     */
    public function saveProfile()
    {
        // Validate all steps
        $this->validateBasicInfo();

        // Only validate professional info if fields were filled out
        if (!empty($this->field) || !empty($this->skills) || !empty($this->years_experience)) {
            $this->validateProfessionalInfo();
        }

        // Make profile picture and resume optional
        if ($this->profile_picture) {
            $this->validate([
                'profile_picture' => 'image|max:1024',
            ]);
        }

        if ($this->resume) {
            $this->validate([
                'resume' => 'file|mimes:pdf,doc,docx|max:5120',
            ]);
        }

        $user = Auth::user();

        // Update user basic data
        $userData = [
            'name' => $this->full_name,
            'email' => $this->email,
        ];

        // Update user record
        $user->update($userData);

        // Get or create applicant profile
        $profile = $user->applicantProfile;
        if (!$profile) {
            $profile = new ApplicantProfile();
            $profile->user_id = $user->id;
        }

        // Update profile data
        $profile->full_name = $this->full_name;
        $profile->phone_number = $this->phone_number;
        $profile->location = $this->location;
        $profile->gender = $this->gender;
        $profile->age = $this->age;
        $profile->field = $this->field;
        $profile->skills = $this->skills;
        $profile->years_experience = $this->years_experience;
        $profile->setup_completed = true;

        // Handle profile picture upload
        if ($this->profile_picture) {
            // Delete old file if exists
            if ($profile->profile_picture_path) {
                Storage::delete('public/' . $profile->profile_picture_path);
            }

            $profilePicturePath = $this->profile_picture->store('profile-pictures', 'public');
            $profile->profile_picture_path = $profilePicturePath;
        }

        // Handle resume upload
        if ($this->resume) {
            // Delete old file if exists
            if ($profile->resume_path) {
                Storage::delete('public/' . $profile->resume_path);
            }

            $resumePath = $this->resume->store('resumes', 'public');
            $profile->resume_path = $resumePath;
        }

        // Save the profile
        $profile->save();

        // Redirect to dashboard with success message
        session()->flash('status', 'Profile setup completed successfully!');

        // Force redirect to break the Livewire lifecycle
        $this->redirect(route('applicant.dashboard'), navigate: false);
    }

    /**
     * Skip the setup process based on current step.
     */
    public function skipSetup()
    {
        if ($this->currentStep == 2) {
            // If on step 2, just move to step 3
            $this->currentStep = 3;
            return;
        } elseif ($this->currentStep == 3) {
            // If on step 3, complete setup and go to dashboard
            $user = Auth::user();

            // Validate step 1 data to ensure we have the required information
            $this->validateBasicInfo();

            // Update user data
            $userData = [
                'name' => $this->full_name,
                'email' => $this->email,
            ];

            // Update user record
            $user->update($userData);

            // Get or create applicant profile
            $profile = $user->applicantProfile;
            if (!$profile) {
                $profile = new ApplicantProfile();
                $profile->user_id = $user->id;
            }

            // Update profile with basic data
            $profile->full_name = $this->full_name;
            $profile->phone_number = $this->phone_number;
            $profile->location = $this->location;
            $profile->gender = $this->gender;
            $profile->age = $this->age;

            // Add optional fields if they were provided
            if (!empty($this->field)) $profile->field = $this->field;
            if (!empty($this->skills)) $profile->skills = $this->skills;
            if (!empty($this->years_experience)) $profile->years_experience = $this->years_experience;

            $profile->setup_completed = true;
            $profile->save();

            session()->flash('status', 'Setup completed. You can update your profile anytime.');

            // Force redirect to break the Livewire lifecycle
            $this->redirect(route('applicant.dashboard'), navigate: false);
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.applicant.profile-setup');
    }
}
