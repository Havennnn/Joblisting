<?php

namespace App\Livewire\Applicant;

use App\Models\User;
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

        // Pre-fill form with user data if available
        $this->full_name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->gender = $user->gender;
        $this->age = $user->age;
        $this->field = $user->field;
        $this->skills = $user->skills;
        $this->years_experience = $user->years_experience;

        // Set profile picture preview if exists
        if ($user->profile_picture_path && Storage::disk('public')->exists($user->profile_picture_path)) {
            $this->profile_picture_preview = Storage::url($user->profile_picture_path);
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
        $this->validateProfessionalInfo();

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

        // Update user data
        $userData = [
            'name' => $this->full_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'age' => $this->age,
            'field' => $this->field,
            'skills' => $this->skills,
            'years_experience' => $this->years_experience,
            'setup_completed' => true, // Mark setup as completed regardless of file uploads
        ];

        // Handle profile picture upload
        if ($this->profile_picture) {
            // Delete old file if exists
            if ($user->profile_picture_path) {
                Storage::delete('public/' . $user->profile_picture_path);
            }

            $profilePicturePath = $this->profile_picture->store('profile-pictures', 'public');
            $userData['profile_picture_path'] = $profilePicturePath;
        }

        // Handle resume upload
        if ($this->resume) {
            // Delete old file if exists
            if ($user->resume_path) {
                Storage::delete('public/' . $user->resume_path);
            }

            $resumePath = $this->resume->store('resumes', 'public');
            $userData['resume_path'] = $resumePath;
        }

        // Update user
        $user->update($userData);

        // Redirect to dashboard
        return redirect()->route('applicant.dashboard')->with('status', 'Profile setup completed successfully!');
    }

    /**
     * Skip the setup process.
     */
    public function skipSetup()
    {
        $user = Auth::user();

        // Mark basic fields with current data
        $userData = [
            'name' => $this->full_name,
            'email' => $this->email,
            'setup_completed' => true // Mark as setup completed even when skipped
        ];

        // Update any fields that might have been filled before skipping
        if (!empty($this->phone_number)) $userData['phone_number'] = $this->phone_number;
        if (!empty($this->gender)) $userData['gender'] = $this->gender;
        if (!empty($this->age)) $userData['age'] = $this->age;
        if (!empty($this->field)) $userData['field'] = $this->field;
        if (!empty($this->skills)) $userData['skills'] = $this->skills;
        if (!empty($this->years_experience)) $userData['years_experience'] = $this->years_experience;

        // Update user
        $user->update($userData);

        return redirect()->route('applicant.dashboard')
            ->with('status', 'Setup skipped. You can complete your profile anytime for a better experience.');
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.applicant.profile-setup');
    }
}
