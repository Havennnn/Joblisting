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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative">
                <div class="space-y-6 pt-12 relative">
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

                    <div class="mt-8 relative" style="max-width: 160%; margin-right: -60%; z-index: 100;">
                        <x-job-search.search-bar :route="'jobs.search'" />
                    </div>
                </div>

                <div class="hidden lg:block relative">
                    <img src="{{ asset('images/landing/hero-bg.jpg') }}" alt="Professional man" class="w-full h-auto object-contain">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
