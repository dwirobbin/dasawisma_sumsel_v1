@extends('layouts.app', ['page' => 'page center'])

@section('content')
    <div class="container-xxl py-4">
        @switch(true)
            @case($data instanceof \App\Models\Family)
                @livewire('app.backend.data-input.family-edit', [$data])
            @break

            @case($data instanceof \App\Models\FamilyBuilding)
                @livewire('app.backend.data-input.family-building-edit', [$data])
            @break

            @case($data instanceof \App\Models\FamilyNumber)
                @livewire('app.backend.data-input.family-number-edit', [$data])
            @break

            @case(is_array($data))
                @livewire('app.backend.data-input.family-member-edit', [$data])
            @break

            @case($data instanceof \App\Models\FamilyActivity)
                @livewire('app.backend.data-input.family-activity-edit', [$data])
            @break
        @endswitch
    </div>
@endsection
