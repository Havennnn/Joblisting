@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="min-h-screen flex justify-center bg-gray-100">
    <div class="max-w-7xl mt-10 px-4 sm:px-6 lg:px-8">
        @livewire('settings.user-settings')
    </div>
</div>
@endsection
