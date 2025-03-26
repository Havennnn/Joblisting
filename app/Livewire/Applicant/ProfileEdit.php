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

        // Pre-fill form with user data
        $this->full_name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->phone_number;
        $this->gender = $this->user->gender;
        $this->age = $this->user->age;
        $this->field = $this->user->field;
        $this->skills = $this->user->skills;
        $this->years_experience = $this->user->years_experience;

        // Set profile picture preview if exists
        if ($this->user->profile_picture_path && Storage::disk('public')->exists($this->user->profile_picture_path)) {
            $this->profile_picture_preview = Storage::url($this->user->profile_picture_path);
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

        // Only update fields that have been changed
        $userData = [];

        // Check each field for changes and only include if changed
        if ($this->full_name !== $this->user->name) {
            $userData['name'] = $this->full_name;
        }

        if ($this->email !== $this->user->email) {
            $userData['email'] = $this->email;
        }

        if ($this->phone_number !== $this->user->phone_number) {
            $userData['phone_number'] = $this->phone_number;
        }

        if ($this->gender !== $this->user->gender) {
            $userData['gender'] = $this->gender;
        }

        if ($this->age !== $this->user->age) {
            $userData['age'] = $this->age;
        }

        if ($this->field !== $this->user->field) {
            $userData['field'] = $this->field;
        }

        if ($this->skills !== $this->user->skills) {
            $userData['skills'] = $this->skills;
        }

        if ($this->years_experience !== $this->user->years_experience) {
            $userData['years_experience'] = $this->years_experience;
        }

        // Handle profile picture upload
        if ($this->profile_picture) {
            // Delete old file if exists
            if ($this->user->profile_picture_path) {
                Storage::delete('public/' . $this->user->profile_picture_path);
            }

            $profilePicturePath = $this->profile_picture->store('profile-pictures', 'public');
            $userData['profile_picture_path'] = $profilePicturePath;
        }

        // Handle resume upload
        if ($this->resume) {
            // Delete old file if exists
            if ($this->user->resume_path) {
                Storage::delete('public/' . $this->user->resume_path);
            }

            $resumePath = $this->resume->store('resumes', 'public');
            $userData['resume_path'] = $resumePath;
        }

        // Only update if there are changes
        if (!empty($userData)) {
            // Update user
            $this->user->update($userData);

            // Show success message
            session()->flash('status', 'Profile updated successfully!');
        } else {
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
