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
                                    <p class="ml-2 text-xs text-gray-500">Max size: 2MB</p>
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
        </div>
    </div>
</div>
@endsection
