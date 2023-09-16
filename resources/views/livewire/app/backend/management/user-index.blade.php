<div>
    <div class="d-flex flex-wrap justify-content-center pb-3">
        <div class="text-muted my-1 my-lg-0">
            <label>
                Lihat
                <select class="d-inline-block form-select w-auto" wire:model.live='perPage'>
                    <option value="4">4</option>
                    <option value="8">8</option>
                    <option value="16">16</option>
                    <option value="24">24</option>
                    <option value="48">48</option>
                    @if (count($users))
                        <option value="{{ $users->total() }}">Semua</option>
                    @endif
                </select>
                data
            </label>
        </div>
        <div class="text-muted mx-auto my-1 my-lg-0">
            <label>
                Status Akun
                <select class="d-inline-block form-select w-auto" wire:model.live='isActive'>
                    <option value="">Semua</option>
                    <option value="1">On</option>
                    <option value="0">Off</option>
                </select>
            </label>
        </div>
        <div class="text-muted my-1 my-lg-0">
            <div class="input-icon">
                <input type="text" wire:model.live='search' class="form-control" placeholder="Cari...">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <div class="row row-cards">
        @forelse ($users as $user)
            <div class="col-md-6 col-lg-3" wire:key="user-{{ $user->id }}">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <span class="avatar avatar-xl mb-3 rounded"
                            style="background-image: url({{ !is_null($user->profile_picture) ? asset('storage/images/profiles/' . $user->profile_picture) : asset('src/img/auth/profile_default.png') }})"></span>
                        <h3 class="m-0 mb-1">{{ $user->name }}</h3>
                        <div class="text-muted">{{ $user->email }}</div>
                        <div class="mt-3">
                            @if ($user->isSuperAdmin())
                                <span class="badge bg-blue-lt">{{ $user->role_name }}</span>
                            @elseif ($user->isAdminProvince())
                                <span class="badge bg-purple-lt">{{ $user->role_name . ' ' . $user->prov_name }}</span>
                            @elseif ($user->isAdminRegency())
                                <span class="badge bg-danger-lt">{{ $user->role_name . ' ' . $user->regency_name }}</span>
                            @elseif ($user->isAdminDistrict())
                                <span class="badge bg-warning-lt">{{ $user->role_name . ' ' . $user->district_name }}</span>
                            @elseif ($user->isAdminVillage())
                                <span class="badge bg-green-lt">{{ $user->role_name . ' ' . $user->village_name }}</span>
                            @elseif ($user->isGuest())
                                <span class="badge bg-secondary-lt">{{ $user->role_name }}</span>
                            @elseif ($user->isNotSet())
                                <span class="badge bg-violet-500">Belum diatur</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex overflow-hidden justify-content-between">
                        @if (auth()->user()->role_id !== 3)
                            <a wire:navigate href="{{ route('admin.management.user.edit', ['user' => $user->username]) }}"
                                class="card-btn bg-warning-lt border-bottom-0 border-x-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                    <path d="M16 5l3 3"></path>
                                </svg>
                                Edit
                            </a>
                        @endif

                        @if ($user->id != auth()->user()->id)
                            @livewire('app.bootstrap.toggle-button', ['model' => $user, 'field' => 'is_active'], key($user->id))

                            <a x-on:click="confirmDelete({{ $user->id }}, '{{ $user->name }}')" class="card-btn bg-danger-lt"
                                role="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7l16 0"></path>
                                    <path d="M10 11l0 6"></path>
                                    <path d="M14 11l0 6"></path>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                                Hapus
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-important alert-warning alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="12" cy="12" r="9"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    </div>
                    <div>
                        {{ empty($users) ? 'Tidak ada data yang tersedia pada tabel ini!' : 'Tidak ditemukan data yang sesuai!' }}
                    </div>
                </div>
            </div>
        @endforelse

        <div class="mt-3">
            @if (count($users))
                {{ $users->links() }}
            @endif
        </div>
    </div>
</div>
