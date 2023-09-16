<div class="collapse navbar-collapse" id="navbar-menu">
    <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
        <ul class="navbar-nav" x-data="{ openDataInput: false, openDataRecap: false }">
            @if (request()->routeIs('home'))
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a wire:navigate class="nav-link" href="{{ route('home') }}">
                        <span class="nav-link-title">
                            Beranda
                        </span>
                    </a>
                </li>
            @elseif (request()->routeIs('admin.*'))
                @auth
                    <li class="nav-item {{ request()->routeIs('admin.home.index') ? 'active' : '' }}">
                        <a class="nav-link" wire:navigate href="{{ route('admin.home.index') }}" data-bs-auto-close="outside">
                            <span class="nav-link-title">
                                Beranda
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown" :class='{ "active": "{{ request()->routeIs('admin.data_input.dasawisma.*') }}" }'>
                        <a class="nav-link dropdown-toggle" :class="{ 'show': openDataInput == true }" x-on:click="openDataInput = !openDataInput"
                            data-bs-toggle="dropdown" :aria-expanded="openDataInput" role="button">
                            <span class="nav-link-title">
                                Input Data
                            </span>
                        </a>
                        <div x-show="openDataInput" class="dropdown-menu" :class="{ 'show': openDataInput == true }"
                            :data-bs-popper="{ 'static': openDataInput == true }">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a wire:navigate href="{{ route('admin.data_input.dasawisma.index') }}" class="dropdown-item">
                                        Dasawisma
                                    </a>
                                    <a wire:navigate href="{{ route('admin.data_input.member.index') }}" class="dropdown-item">
                                        Anggota
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown" :class='{ "active": "{{ request()->routeIs('admin.data_recap.*') }}" }'>
                        <a class="nav-link dropdown-toggle" :class="{ 'show': openDataRecap == true }" x-on:click="openDataRecap = !openDataRecap"
                            data-bs-toggle="dropdown" :aria-expanded="openDataRecap" role="button">
                            <span class="nav-link-title">
                                Rekap Data
                            </span>
                        </a>
                        <div x-show="openDataRecap" class="dropdown-menu" :class="{ 'show': openDataRecap == true }"
                            :data-bs-popper="{ 'static': openDataRecap == true }">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <a class="dropdown-item" wire:navigate href="{{ route('admin.data_recap.family_buildings.index') }}">
                                        Rekap Info Bangunan
                                    </a>
                                    <a class="dropdown-item" wire:navigate href="{{ route('admin.data_recap.family_numbers.index') }}">
                                        Rekap Jumlah Anggota
                                    </a>
                                    <a class="dropdown-item" wire:navigate href="{{ route('admin.data_recap.family_members.index') }}">
                                        Rekap Anggota Keluarga
                                    </a>
                                    <a class="dropdown-item" wire:navigate href="{{ route('admin.data_recap.family_activities.index') }}">
                                        Rekap Kegiatan Warga
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.management.user.*') ? 'active' : '' }}">
                        <a wire:navigate href="{{ route('admin.management.user.index') }}" class="nav-link">
                            <span class="nav-link-title">
                                Manajemen Pengguna
                            </span>
                        </a>
                    </li>
                @endauth
            @endif
        </ul>
    </div>
</div>
