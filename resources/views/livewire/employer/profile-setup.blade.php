<div class="min-h-screen py-6 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900">Complete Your Profile</h1>
                <p class="mt-2 text-gray-600">Please provide your contact details to get started.</p>

                @if (session('status'))
                    <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium text-gray-900">Profile Setup</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Complete your profile to get started. This information will be used for communication purposes.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form wire:submit.prevent="saveProfile">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <!-- Personal Information -->
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                                <input type="text" wire:model="full_name" id="full_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                @error('full_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                                <input type="email" wire:model="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                                <input type="tel" wire:model="phone_number" id="phone_number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button type="button" wire:click="skipSetup" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Skip for now
                                        </button>
                                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Complete Setup
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
