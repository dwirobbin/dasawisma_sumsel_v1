@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        @if (session()->has('message'))
            <div class="alert alert-important alert-{{ session('message')['type'] }} alert-dismissible mt-3 mb-0 mx-3" role="alert">
                <div>{{ session('message')['text'] }}</div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col-4">
                        <h2 class="page-title">Rekap Kegiatan Warga</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    @livewire('app.backend.data-recap.family-activity-index', ['param' => $param, 'lazy' => true])
                </div>
            </div>
        </div>
    </div>
@endsection
