@extends('layouts.app')

@section('title', isset($job) ? $job->title . ' - NeksJob PH' : 'Job Details - NeksJob PH')

@section('content')
<div class="bg-gray-100 p-12">
    <div class="container">
        <div class="flex justify-center items-center min-h-screen">
            {{-- Delete this line --}}
            <h1 class="text-4xl font-bold text-center mb-8">Put Job Details Page Design Here</h1>
        </div>
    </div>
</div>
@endsection
