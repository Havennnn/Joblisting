@extends('layouts.employer')

@section('title', 'Create Company - Neksjob')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-employer.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="max-w-5xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Create Company</h1>
                    <p class="mt-1 text-gray-600">Set up your company profile</p>
                </div>
                <a href="{{ route('employer.company.index') }}" class="text-indigo-600 hover:text-indigo-500">
                    Back to Company
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <!-- Create Company Form -->
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

                    <form action="{{ route('employer.company.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Company Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Company Name *</label>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Industry -->
                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-700">Industry *</label>
                                <input type="text" name="industry" id="industry" required value="{{ old('industry') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Company Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea name="description" id="description" rows="4" required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Provide a brief description of your company (max 1000 characters)</p>
                            </div>

                            <!-- Website -->
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="url" name="website" id="website" value="{{ old('website') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Location *</label>
                                <input type="text" name="location" id="location" required value="{{ old('location') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Founding Year -->
                            <div>
                                <label for="founding_year" class="block text-sm font-medium text-gray-700">Founding Year</label>
                                <input type="number" name="founding_year" id="founding_year" value="{{ old('founding_year') }}"
                                    min="1800" max="{{ date('Y') }}"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Company Size -->
                            <div>
                                <label for="size" class="block text-sm font-medium text-gray-700">Company Size *</label>
                                <select name="size" id="size" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select company size</option>
                                    <option value="1-10" {{ old('size') == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                    <option value="11-50" {{ old('size') == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                    <option value="51-200" {{ old('size') == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                    <option value="201-500" {{ old('size') == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                                    <option value="501-1000" {{ old('size') == '501-1000' ? 'selected' : '' }}>501-1000 employees</option>
                                    <option value="1001+" {{ old('size') == '1001+' ? 'selected' : '' }}>1001+ employees</option>
                                </select>
                            </div>

                            <!-- Company Logo -->
                            <div>
                                <label for="logo" class="block text-sm font-medium text-gray-700">Company Logo</label>
                                <div class="mt-1 flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 bg-gray-100 border border-gray-200 rounded-md overflow-hidden">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
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
                                        Create Company
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
