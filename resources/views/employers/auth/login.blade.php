@extends('layouts.employer.guest')

@section('content')
    <div class="card p-4 shadow-lg" style="width: 350px;">
        <h3 class="text-center mb-3">Employer Login</h3>
        @livewire('employers.login')
    </div>
@endsection

@push('pageStyles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('pageScripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
