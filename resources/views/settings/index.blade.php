@extends('layouts.' . (auth()->user()->is_employer ? 'employer' : 'applicant'))

@section('title', 'Account Settings')

@section('content')
    @livewire('user-settings')
@endsection
