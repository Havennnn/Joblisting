<div class="min-h-screen py-6 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Your Employer Profile</h1>
                <p class="mt-2 text-gray-600">Update your company information below.</p>

                @if (session('status'))
                    <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                <form wire:submit.prevent="saveProfile" class="mt-6">
                    <!-- Personal Information Section -->
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Personal Information</h3>
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name (Optional)</label>
                                    <input type="text" wire:model="full_name" id="full_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('full_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" wire:model="email" id="email" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Details Section -->
                    <div class="mt-8 bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Company Details</h3>
                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name (Optional)</label>
                                    <input type="text" wire:model="company_name" id="company_name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('company_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="company_description" class="block text-sm font-medium text-gray-700">Company Description (Optional)</label>
                                    <textarea wire:model="company_description" id="company_description" rows="4" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                    @error('company_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                                    <input type="text" wire:model="industry" id="industry" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('industry') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" wire:model="phone_number" id="phone_number" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('phone_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                    <input type="text" wire:model="location" id="location" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website URL (Optional)</label>
                                    <input type="url" wire:model="website" id="website" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('website') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Logo Upload Section -->
                    <div class="mt-8 bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Company Logo (Optional)</h3>
                            <div class="mt-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-24 w-24 bg-gray-200 rounded-md overflow-hidden">
                                        @if ($company_logo_preview)
                                            <img src="{{ $company_logo_preview }}" alt="Company logo preview" class="h-24 w-24 object-cover">
                                        @else
                                            <div class="h-24 w-24 flex items-center justify-center text-gray-400">
                                                <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M4 4h16v16H4V4zm1 1v14h14V5H5zm4 6h6v4H9v-4zm1 1v2h4v-2h-4zm-1-6h2v4H9V6zm1 1v2h1V7H10z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="relative bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm flex items-center cursor-pointer hover:bg-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <label for="company_logo" class="relative text-sm font-medium text-gray-700 pointer-events-none">
                                                <span>Upload a file</span>
                                            </label>
                                            <input id="company_logo" wire:model="company_logo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        </div>
                                        <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF up to 1MB</p>
                                        @error('company_logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
