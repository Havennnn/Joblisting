@extends('layouts.app')

@section('title', 'Content Unavailable')

@section('content')
<div class="bg-white min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-4 text-center">
        <div>
            <div class="flex justify-center">
                <img src="{{ asset('images/NextJob.svg') }}" alt="Logo" class="h-14 w-auto">
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Content Unavailable
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                You need to be logged in to access this content.
            </p>
        </div>

        <div class="mt-4">
            <a href="{{ route('landing') }}" class="text-sm text-gray-600 text-neksjob-blue">
                Return to Homepage
            </a>
        </div>
    </div>
</div>
@endsection
