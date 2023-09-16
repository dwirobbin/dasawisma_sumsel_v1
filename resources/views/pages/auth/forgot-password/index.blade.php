@extends('layouts.app', ['page' => 'page-center'])

@section('content')
    <div class="container container-tight py-4">
        @livewire('app.auth.forgot-password.index')
    </div>
@endsection
