<!-- resources/views/messenger/applicant-profile-form.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Complete Your Profile</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Please complete your profile information to access the chat system. This information will be shared with interviewers.
                    </div>

                    <form action="{{ route('messenger.save-applicant-profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name ?? '') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $profile->phone_number ?? '') }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $profile->location ?? '') }}" required placeholder="City, State/Province, Country">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="resume" class="form-label">Resume (PDF, DOC, DOCX)</label>
                            <input type="file" class="form-control @error('resume') is-invalid @enderror" id="resume" name="resume">
                            @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if(isset($profile) && $profile->resume_path)
                                <div class="mt-2">
                                    <p class="mb-0"><i class="fas fa-file-pdf"></i> Current resume: {{ basename($profile->resume_path) }}</p>
                                    <input type="hidden" name="existing_resume" value="{{ $profile->resume_path }}">
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills</label>
                            <textarea class="form-control @error('skills') is-invalid @enderror" id="skills" name="skills" rows="3" placeholder="List your key skills, separated by commas">{{ old('skills', $profile->skills ?? '') }}</textarea>
                            @error('skills')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="experience" class="form-label">Experience</label>
                            <textarea class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience" rows="4" placeholder="Summarize your relevant work experiences">{{ old('experience', $profile->experience ?? '') }}</textarea>
                            @error('experience')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="education" class="form-label">Education</label>
                            <textarea class="form-control @error('education') is-invalid @enderror" id="education" name="education" rows="3" placeholder="List your educational background">{{ old('education', $profile->education ?? '') }}</textarea>
                            @error('education')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Save Profile & Continue to Chat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
