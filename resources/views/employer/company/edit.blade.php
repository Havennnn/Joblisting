@extends('layouts.employer')

@section('title', 'Edit Company - Neksjob')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-employer.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="max-w-5xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Edit Company Settings</h1>
                    <p class="mt-1 text-gray-600">Update your company information</p>
                </div>
                <a href="{{ route('employer.company.index') }}" class="text-indigo-600 hover:text-indigo-500">
                    Back to Company
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <!-- Edit Company Form -->
                <div class="p-6">
                    @if($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">Please correct the following errors:</p>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('employer.company.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <!-- Company Name (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company Name</label>
                                <div class="mt-1 px-3 py-2 bg-gray-100 rounded-md border border-gray-200 text-gray-700">
                                    {{ $company->name }}
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Company name cannot be changed</p>
                            </div>

                            <!-- Industry (Read-only) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Industry</label>
                                <div class="mt-1 px-3 py-2 bg-gray-100 rounded-md border border-gray-200 text-gray-700">
                                    {{ $company->industry }}
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Industry cannot be changed</p>
                            </div>

                            <!-- Company Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea name="description" id="description" rows="4" required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $company->description) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Provide a brief description of your company (max 1000 characters)</p>
                            </div>

                            <!-- Website -->
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="url" name="website" id="website" value="{{ old('website', $company->website) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Location *</label>
                                <input type="text" name="location" id="location" required value="{{ old('location', $company->location) }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Company Logo -->
                            <div>
                                <label for="logo" class="block text-sm font-medium text-gray-700">Company Logo</label>
                                <div class="mt-1 flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 bg-gray-100 border border-gray-200 rounded-md overflow-hidden">
                                        @if($company->logo_path)
                                            <img src="{{ Storage::url($company->logo_path) }}" alt="{{ $company->name }}" class="h-16 w-16 object-cover">
                                        @else
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <input type="file" name="logo" id="logo" accept="image/*"
                                        class="ml-4 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <p class="ml-2 text-xs text-gray-500">Max size: 5MB</p>
                                </div>
                            </div>

                            <div class="pt-5">
                                <div class="flex justify-end">
                                    <a href="{{ route('employer.company.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </a>
                                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Update Company
                                    </button>
                                </div>
                                <p class="mt-4 text-xs text-gray-500">* Required fields</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Company Section -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Delete Company</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Once you delete your company, all company data including job posts will be permanently removed.
                        This action cannot be undone.
                    </p>
                </div>
                <div class="p-6 bg-gray-50">
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        onclick="document.getElementById('deleteCompanyModal').classList.remove('hidden')">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete Company
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Company Modal -->
    <div id="deleteCompanyModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Delete Company
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete your company? This action will:
                                </p>
                                <ul class="list-disc pl-5 mt-2 text-sm text-gray-500">
                                    <li>Remove all company members from the company</li>
                                    <li>Delete all job posts created by the company</li>
                                    <li>Permanently delete all company data</li>
                                </ul>
                                <p class="text-sm text-gray-500 mt-2">
                                    <strong>This action cannot be undone.</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{ route('employer.company.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete Company
                        </button>
                    </form>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('deleteCompanyModal').classList.add('hidden')">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
