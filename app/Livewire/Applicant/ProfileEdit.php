<?php

namespace App\Livewire\Applicant;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileEdit extends Component
{
    use WithFileUploads;

    // User instance
    public $user;

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
        $this->user = Auth::user();
        $profile = $this->user->applicantProfile;

        // Pre-fill form with user data
        $this->full_name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone_number = $profile->phone_number ?? null;
        $this->location = $profile->location ?? null;
        $this->gender = $profile->gender ?? null;
        $this->age = $profile->age ?? null;
        $this->field = $profile->field ?? null;
        $this->skills = $profile->skills ?? null;
        $this->years_experience = $profile->years_experience ?? null;

        // Set profile picture preview if exists
        if ($profile && $profile->profile_picture_path && Storage::disk('public')->exists($profile->profile_picture_path)) {
            $this->profile_picture_preview = Storage::url($profile->profile_picture_path);
        }
    }

    /**
     * Handle file upload preview for profile picture.
     */
    public function updatedProfilePicture()
    {
        $this->validate([
            'profile_picture' => 'image|max:1024', // 1MB Max
        ]);

        $this->profile_picture_preview = $this->profile_picture->temporaryUrl();
    }

    /**
     * Handle file upload for resume.
     */
    public function updatedResume()
    {
        $this->validate([
            'resume' => 'file|mimes:pdf,doc,docx|max:5120', // 5MB Max
        ]);

        $this->resume_name = $this->resume->getClientOriginalName();
    }

    /**
     * Save the user profile data.
     */
    public function saveProfile()
    {
        // Validate form fields - all fields are optional in profile edit mode
        $this->validate([
            'full_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255', // Email remains required as it's essential
            'phone_number' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female,other',
            'age' => 'nullable|integer|min:18',
            'field' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'years_experience' => 'nullable|integer|min:0',
        ]);

        // Validate file uploads if provided
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

        // Get the applicant profile
        $profile = $this->user->applicantProfile;

        // Only update fields that have been changed
        $userData = [];
        $profileData = [];

        // Check each field for changes and only include if changed
        if ($this->full_name !== $this->user->name) {
            $userData['name'] = $this->full_name;
            $profileData['full_name'] = $this->full_name;
        }

        if ($this->email !== $this->user->email) {
            $userData['email'] = $this->email;
        }

        if ($this->phone_number !== $profile->phone_number) {
            $profileData['phone_number'] = $this->phone_number;
        }

        if ($this->location !== $profile->location) {
            $profileData['location'] = $this->location;
        }

        if ($this->gender !== $profile->gender) {
            $profileData['gender'] = $this->gender;
        }

        if ($this->age !== $profile->age) {
            $profileData['age'] = $this->age;
        }

        if ($this->field !== $profile->field) {
            $profileData['field'] = $this->field;
        }

        if ($this->skills !== $profile->skills) {
            $profileData['skills'] = $this->skills;
        }

        if ($this->years_experience !== $profile->years_experience) {
            $profileData['years_experience'] = $this->years_experience;
        }

        // Handle profile picture upload
        if ($this->profile_picture) {
            // Delete old file if exists
            if ($profile->profile_picture_path) {
                Storage::delete('public/' . $profile->profile_picture_path);
            }

            $profilePicturePath = $this->profile_picture->store('profile-pictures', 'public');
            $profileData['profile_picture_path'] = $profilePicturePath;
        }

        // Handle resume upload
        if ($this->resume) {
            // Delete old file if exists
            if ($profile->resume_path) {
                Storage::delete('public/' . $profile->resume_path);
            }

            $resumePath = $this->resume->store('resumes', 'public');
            $profileData['resume_path'] = $resumePath;
        }

        // Update user if there are changes
        if (!empty($userData)) {
            $this->user->update($userData);
        }

        // Update profile if there are changes
        if (!empty($profileData)) {
            $profile->update($profileData);

            // Mark profile as completed if all required fields are filled
            if (!$profile->setup_completed &&
                $profile->full_name &&
                $profile->phone_number &&
                $profile->location &&
                $profile->field &&
                $profile->skills) {
                $profile->update(['setup_completed' => true]);
            }

            // Show success message
            session()->flash('status', 'Profile updated successfully!');
        } else if (empty($userData)) {
            // No changes were made
            session()->flash('status', 'No changes detected in your profile.');
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.applicant.profile-edit');
    }
}
