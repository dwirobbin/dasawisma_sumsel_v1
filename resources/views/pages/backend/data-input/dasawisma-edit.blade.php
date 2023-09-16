@extends('layouts.app', ['page' => 'page center'])

@section('content')
    <div class="container container-narrow py-4">
        @livewire('app.backend.data-input.dasawisma-edit', ['dasawisma' => $dasawisma])
    </div>
@endsection
