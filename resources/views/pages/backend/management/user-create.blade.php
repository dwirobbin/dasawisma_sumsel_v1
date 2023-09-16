@extends('layouts.app', ['page' => 'page-center'])

@section('content')
    <div class="container py-4">
        @livewire('app.backend.management.user-create')
    </div>
@endsection
