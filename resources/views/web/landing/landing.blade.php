@extends('layouts.app')

@section('content')
<div>
    <div class="bg-[#EBF5FF]">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-28 relative">
            <div class="absolute top-0 right-0 bottom-0 left-1/2 overflow-hidden z-0 pointer-events-none">
                <svg class="absolute top-0 right-0 h-full w-full text-[#C7E1FF] opacity-80" xmlns="http://www.w3.org/2000/svg">
                    <line x1="30%" y1="0" x2="10%" y2="100%" stroke="currentColor" stroke-width="2" />
                    <line x1="50%" y1="0" x2="30%" y2="100%" stroke="currentColor" stroke-width="2" />
                    <line x1="70%" y1="0" x2="50%" y2="100%" stroke="currentColor" stroke-width="2" />
                    <line x1="90%" y1="0" x2="70%" y2="100%" stroke="currentColor" stroke-width="2" />
                </svg>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative z-10">
                <div class="space-y-6 pt-12">
                    <h1 class="text-6xl md:text-7xl font-bold text-black leading-tight">
                        FIND YOUR<br/>
                        NEXT JOB!
                    </h1>
                    <h2 class="text-4xl md:text-5xl font-semibold text-[#2563EB]">
                        Your next career<br/>
                        starts here.
                    </h2>
                    <p class="text-lg text-gray-600">
                        Discover thousands of job opportunities tailored<br/>
                        to your skills and goals with just a few clicks.
                    </p>

                    <!-- Search Form -->
                    <div class="flex p-4 bg-white mt-8 shadow-md z-10" style="max-width: 120%; margin-right: -20%;">
                        <div class="w-full">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex-4 relative" style="flex: 4;">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" placeholder="Job title or keyword" class="block w-full pl-10 pr-3 py-3 border border-gray-300 backdrop:focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div class="flex-2 relative" style="flex: 2;">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" placeholder="Location" class="block w-full pl-10 pr-3 py-3 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <button class="bg-[#2563EB] text-white px-8 py-3 hover:bg-blue-600 transition duration-200">
                                    Find Job
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="hidden lg:block relative">
                    <img src="{{ asset('images/landing/hero-bg.jpg') }}" alt="Professional man" class="w-full h-auto object-contain">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
