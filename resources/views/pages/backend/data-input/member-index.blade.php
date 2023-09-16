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
                        <h2 class="page-title">Anggota Dasawisma</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <a wire:navigate href="{{ route('admin.data_input.member.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            New Anggota
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card"x-data="{ currentTabMember: $persist('tabsFamily') }">
                    <div class="card-header">
                        <ul wire:ignore class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                            <li @click.prevent="currentTabMember = 'tabsFamily'" class="nav-item">
                                <a href="#tabsFamily" class="nav-link" :class="currentTabMember == 'tabsFamily' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Kepala Keluarga
                                </a>
                            </li>
                            <li @click.prevent="currentTabMember = 'tabsFamilyBuilding'" class="nav-item">
                                <a href="#tabsFamilyBuilding" class="nav-link" :class="currentTabMember == 'tabsFamilyBuilding' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Bangunan
                                </a>
                            </li>
                            <li @click.prevent="currentTabMember = 'tabsFamilyNumber'" class="nav-item">
                                <a href="#tabsFamilyNumber" class="nav-link" :class="currentTabMember == 'tabsFamilyNumber' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Jumlah Anggota
                                </a>
                            </li>
                            <li @click.prevent="currentTabMember = 'tabsFamilyMember'" class="nav-item">
                                <a href="#tabsFamilyMember" class="nav-link" :class="currentTabMember == 'tabsFamilyMember' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Anggota Keluarga
                                </a>
                            </li>
                            <li @click.prevent="currentTabMember = 'tabsFamilyActivity'" class="nav-item">
                                <a href="#tabsFamilyActivity" class="nav-link" :class="currentTabMember == 'tabsFamilyActivity' ? 'active' : ''"
                                    data-bs-toggle="tab">
                                    Aktifitas Keluarga
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamily' ? 'active' : ''" id="tabsFamily">
                                @livewire('app.backend.data-input.family-index', ['lazy' => true])
                            </div>
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamilyBuilding' ? 'active' : ''"
                                id="tabsFamilyBuilding">
                                @livewire('app.backend.data-input.family-building-index', ['lazy' => true])
                            </div>
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamilyNumber' ? 'active' : ''"
                                id="tabsFamilyNumber">
                                @livewire('app.backend.data-input.family-number-index', ['lazy' => true])
                            </div>
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamilyMember' ? 'active' : ''"
                                id="tabsFamilyMember">
                                @livewire('app.backend.data-input.family-member-index', ['lazy' => true])
                            </div>
                            <div wire:ignore.self class="tab-pane show" :class="currentTabMember == 'tabsFamilyActivity' ? 'active' : ''"
                                id="tabsFamilyActivity">
                                @livewire('app.backend.data-input.family-activity-index', ['lazy' => true])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $("document").ready(function() {
            setTimeout(function() {
                $("div.alert").remove();
            }, 3000);

        });

        function swalConfirm(id, name, eventName) {
            return Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi hapus!',
                html: `Apakah anda ingin menghapus data: <b>${name}</b> ?`,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
                customClass: {
                    cancelButton: 'order-1',
                    confirmButton: 'order-2',
                },
            }).then(function(result) {
                if (result.isConfirmed) {
                    Livewire.dispatch(eventName, {
                        id: id
                    })
                }
            });
        }

        function familyDeleteConfirm(id, name) {
            swalConfirm(id, name, 'family-deleted');
        }

        function familyMemberDeleteConfirm(id, name) {
            swalConfirm(id, name, 'family-member-deleted');
        }
    </script>
@endpush
