<?php

namespace App\Livewire\Applicant;

use App\Models\Users\User;
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
        $this->phone_number = $profile->phone_number ?? null;
        $this->location = $profile->location ?? null;
        $this->gender = $profile->gender ?? null;
        $this->age = $profile->age ?? null;
        $this->field = $profile->field ?? null;
        $this->skills = $profile->skills ?? null;
        $this->years_experience = $profile->years_experience ?? null;

        // Set profile picture preview if exists
        if ($profile && $profile->profile_picture_path) {
            $this->profile_picture_preview = route('applicant.profile.picture', ['user' => $this->user->id]);
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
     * Save profile changes.
     */
    public function saveProfile()
    {
        // Validate basic user information
        $this->validate([
            'full_name' => 'required|min:3|max:255',
            'phone_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'age' => 'required|integer|min:18|max:100',
            'field' => 'nullable|string|max:255',
            'skills' => 'nullable|string',
            'years_experience' => 'nullable|integer|min:0|max:50',
            'profile_picture' => 'nullable|image|max:1024', // 1MB Max
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB Max
        ]);

        // Prepare user data to update
        $userData = [
            'name' => $this->full_name,
        ];

        // Update user record
        $this->user->update($userData);

        // Prepare profile data to update
        $profileData = [
            'phone_number' => $this->phone_number,
            'location' => $this->location,
            'gender' => $this->gender,
            'age' => $this->age,
            'field' => $this->field,
            'skills' => $this->skills,
            'years_experience' => $this->years_experience,
        ];

        // Handle profile picture upload
        if ($this->profile_picture) {
            // If there's an existing profile picture, delete it
            if ($this->user->applicantProfile && $this->user->applicantProfile->profile_picture_path) {
                Storage::delete($this->user->applicantProfile->profile_picture_path);
            }

            // Store in private storage (local disk)
            $profilePicturePath = $this->profile_picture->store('profile-pictures', 'local');
            $profileData['profile_picture_path'] = $profilePicturePath;
        }

        // Handle resume upload
        if ($this->resume) {
            // If there's an existing resume, delete it
            if ($this->user->applicantProfile && $this->user->applicantProfile->resume_path) {
                Storage::delete($this->user->applicantProfile->resume_path);
            }

            // Store in private storage (local disk)
            $resumePath = $this->resume->store('resumes', 'local');
            $profileData['resume_path'] = $resumePath;
        }

        // Update applicant profile
        $profile = $this->user->applicantProfile;
        if ($profile) {
            $profile->update($profileData);
        } else {
            $this->user->applicantProfile()->create($profileData);
        }

        session()->flash('status', 'Profile updated successfully!');
        return redirect()->route('applicant.profile');
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.applicant.profile-edit');
    }
}
