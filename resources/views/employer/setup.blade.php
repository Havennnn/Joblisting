@extends('layouts.setup')

@section('title', 'Complete Your Company Profile')

@section('content')
<div class="min-h-screen bg-white-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full {{ $step == 1 ? 'bg-blue-600 text-white' : ($step > 1 ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500') }} flex items-center justify-center">
                                    1
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium {{ $step == 1 ? 'text-blue-600' : ($step > 1 ? 'text-green-600' : 'text-gray-500') }}">Basic Information</h3>
                                <p class="text-sm text-gray-500">Your personal details</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full {{ $step == 2 ? 'bg-blue-600 text-white' : ($step > 2 ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500') }} flex items-center justify-center">
                                    2
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium {{ $step == 2 ? 'text-blue-600' : ($step > 2 ? 'text-green-600' : 'text-gray-500') }}">Company Details</h3>
                                <p class="text-sm text-gray-500">Your company information</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-8 w-8 rounded-full {{ $step == 3 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center">
                                    3
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium {{ $step == 3 ? 'text-blue-600' : 'text-gray-500' }}">Confirmation</h3>
                                <p class="text-sm text-gray-500">Review and finish</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Setup Form -->
            <div class="bg-white shadow sm:rounded-lg border border-gray-300">
                <div class="px-4 py-5 sm:p-6">
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Step 1: Basic Information -->
                    @if($step == 1)
                        <form action="{{ route('employer.setup.step-one') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Complete your employer profile</h2>
                                <p class="text-sm text-gray-500 mb-6">Please provide your basic contact information.</p>
                                <hr class="border-t-2 border-gray-300 mb-4">
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $data['full_name'] ?? $user->name) }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $data['email'] ?? $user->email) }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $data['phone_number'] ?? '') }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="flex justify-between pt-6">
                                <a href="{{ route('employer.setup.skip') }}" class="text-sm text-blue-600 hover:text-blue-500">Skip for now</a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Next
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Step 2: Company Information -->
                    @if($step == 2)
                        <form action="{{ route('employer.setup.step-two') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Company Information</h2>
                                <p class="text-sm text-gray-500 mb-6">Tell us about your company.</p>
                                <hr class="border-t-2 border-gray-300 mb-4">
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $data['company_name'] ?? '') }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                                    <input type="text" name="industry" id="industry" value="{{ old('industry', $data['industry'] ?? '') }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="company_description" class="block text-sm font-medium text-gray-700">Company Description</label>
                                    <textarea name="company_description" id="company_description" rows="4"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('company_description', $data['company_description'] ?? '') }}</textarea>
                                </div>

                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website (Optional)</label>
                                    <input type="url" name="website" id="website" value="{{ old('website', $data['website'] ?? '') }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                    <input type="text" name="location" id="location" value="{{ old('location', $data['location'] ?? '') }}"
                                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Company Logo (Optional)</label>
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-block h-16 w-16 rounded-full overflow-hidden bg-gray-100" id="preview-container">
                                            @if(isset($user->employer) && $user->employer->company_logo_path && Storage::disk('public')->exists($user->employer->company_logo_path))
                                                <img src="{{ Storage::url($user->employer->company_logo_path) }}" alt="Company Logo" class="h-full w-full object-cover" id="logo-preview">
                                            @else
                                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24" id="logo-placeholder">
                                                    <path d="M21.5 20.5H2.5V5.5H21.5V20.5ZM12 8.5C10.1 8.5 8.5 10.1 8.5 12C8.5 13.9 10.1 15.5 12 15.5C13.9 15.5 15.5 13.9 15.5 12C15.5 10.1 13.9 8.5 12 8.5Z" />
                                                </svg>
                                            @endif
                                        </span>
                                        <input type="file" name="company_logo" id="company_logo" accept="image/*"
                                            class="ml-5 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between pt-6">
                                <a href="{{ route('employer.setup.previous') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Previous
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Next
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Step 3: Confirmation -->
                    @if($step == 3)
                        <div class="space-y-6">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Confirm Your Information</h2>
                                <p class="text-sm text-gray-500 mb-6">Please review your information before finalizing your setup.</p>
                                <hr class="border-t-2 border-gray-300 mb-4">
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg space-y-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-3">Personal Information</h3>
                                    <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['full_name'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['email'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['phone_number'] ?? 'Not provided' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-3">Company Information</h3>
                                    <dl class="grid grid-cols-2 gap-x-4 gap-y-3">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Company Name</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['company_name'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Industry</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['industry'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Website</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['website'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['location'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div class="col-span-2">
                                            <dt class="text-sm font-medium text-gray-500">Company Description</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['company_description'] ?? 'Not provided' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                            <dd class="text-sm text-gray-900">{{ $data['phone_number'] ?? 'Not provided' }}</dd>
                                        </div>
                                        @if(isset($data['company_logo_path']))
                                        <div class="col-span-2 mt-2">
                                            <dt class="text-sm font-medium text-gray-500 mb-2">Company Logo</dt>
                                            <dd class="text-sm text-gray-900">
                                                <img src="{{ asset('storage/' . $data['company_logo_path']) }}"
                                                     alt="Company Logo"
                                                     class="h-16 w-16 rounded-full object-cover"
                                                     onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,%3csvg width=\'16\' height=\'16\' xmlns=\'http://www.w3.org/2000/svg\'%3e%3crect width=\'16\' height=\'16\' fill=\'%23CCC\'/%3e%3c/svg%3e'; this.classList.add('bg-gray-200');">
                                            </dd>
                                        </div>
                                        @endif
                                    </dl>
                                </div>
                            </div>

                            <form action="{{ route('employer.setup.step-three') }}" method="POST" class="pt-4">
                                @csrf
                                <div class="flex justify-between">
                                    <a href="{{ route('employer.setup.previous') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Previous
                                    </a>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Complete Setup
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Image preview for company logo
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.getElementById('company_logo');
        if (logoInput) {
            logoInput.addEventListener('change', function() {
                const preview = document.getElementById('preview-container');
                const placeholder = document.getElementById('logo-placeholder');

                // If there's already an image preview, replace it
                const existingPreview = document.getElementById('logo-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }

                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        if (placeholder) placeholder.style.display = 'none';

                        const img = document.createElement('img');
                        img.id = 'logo-preview';
                        img.src = e.target.result;
                        img.alt = 'Company Logo Preview';
                        img.className = 'h-full w-full object-cover';

                        preview.appendChild(img);
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
</script>
@endsection
@endsection
