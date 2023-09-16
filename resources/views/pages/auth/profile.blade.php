@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        @if (session()->has('message'))
            <div class="alert alert-important alert-{{ session('message')['type'] }} alert-dismissible mt-3 mb-0 mx-3" role="alert">
                <div>{{ session('message')['text'] }}</div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <div class="page-header">
            <div class="container-xl">
                @livewire('app.auth.profile.picture')
            </div>
        </div>
        <hr />

        <!-- Page body -->
        @if (auth()->user()->role_id !== 3)
            <div class="page-body">
                <div class="container-xl d-flex flex-column justify-content-center">
                    <div class="row row-cards">
                        <div class="col-md-12">
                            <div class="card" x-data="{ currentTabProfile: $persist('tabsProfileDetail') }">
                                <div class="card-header">
                                    <ul wire:ignore class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                                        <li @click.prevent="currentTabProfile = 'tabsProfileDetail'" class="nav-item">
                                            <a href="#tabsProfileDetail" class="nav-link"
                                                :class="currentTabProfile === 'tabsProfileDetail' ? 'active' : ''" data-bs-toggle="tab">
                                                Detail Profile
                                            </a>
                                        </li>
                                        <li @click.prevent="currentTabProfile = 'tabsChangePassword'" class="nav-item">
                                            <a href="#tabsChangePassword" class="nav-link"
                                                :class="currentTabProfile === 'tabsChangePassword' ? 'active' : ''" data-bs-toggle="tab">
                                                Ubah Password
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div wire:ignore.self class="tab-pane fade show"
                                            :class="currentTabProfile === 'tabsProfileDetail' ? 'active' : ''" id="tabsProfileDetail">
                                            @livewire('app.auth.profile.detail-form')
                                        </div>
                                        <div wire:ignore.self class="tab-pane fade show"
                                            :class="currentTabProfile === 'tabsChangePassword' ? 'active' : ''" id="tabsChangePassword">
                                            @livewire('app.auth.profile.change-password-form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
