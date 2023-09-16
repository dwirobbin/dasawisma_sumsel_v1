@extends('layouts.app', ['page' => 'page center'])

@section('content')
    <div class="container-xxl py-4">
        @livewire('app.backend.data-input.member-create')
    </div>
@endsection
