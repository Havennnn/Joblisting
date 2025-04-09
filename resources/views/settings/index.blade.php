@extends('layouts.' . (auth()->user()->isEmployer() ? 'employer' : 'applicant'))

@section('title', 'Account Settings')

@section('content')
    @livewire('user-settings')
@endsection
