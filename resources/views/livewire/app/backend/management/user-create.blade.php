<form class="card" wire:submit.prevent="store" method="post" autocomplete="off">
    <div class="card-body">
        <h2 class="h2 text-center mb-4">New User</h2>
        <div class="row">
            <div class="{{ $roleId == 1 || $roleId == 2 ? 'col-md-4' : 'col-md-6' }}">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-auto">
                            @if ($profilePicture)
                                <img class="avatar avatar-md" src="{{ $profilePicture->temporaryUrl() }}">
                            @else
                                <span class="avatar avatar-md" style="background-image: url({{ asset('src/img/auth/profile_default.png') }})">
                                </span>
                            @endif
                        </div>
                        <div class="col">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" wire:model='profilePicture' class="form-control @error('profile_picture') is-invalid @enderror"
                                accept=".png,.jpg,.jpeg,.svg,.gif" />
                        </div>
                    </div>
                    @error('profile_picture')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">Nama</label>
                    <input type="text" wire:model='name' class="form-control @error('name') is-invalid @enderror" placeholder="Name...">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">Username</label>
                    <input type="text" wire:model='username' class="form-control @error('username') is-invalid @enderror"
                        placeholder="Username...">
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">Email</label>
                    <input type="text" wire:model='email' class="form-control @error('email') is-invalid @enderror" placeholder="Email...">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="{{ $roleId == 1 || $roleId == 2 ? 'col-md-4' : 'col-md-6' }}">
                <div class="mb-3">
                    <label class="form-label required">Password</label>
                    <input type="password" wire:model='password' class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password...">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">Konfirmasi Password</label>
                    <input type="password" wire:model='passwordConfirmation'
                        class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi Password...">
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">No. Telepon</label>
                    <input type="tel" wire:model='phoneNumber' class="form-control @error('phone_number') is-invalid @enderror"
                        placeholder="No. Telepon...">
                    @error('phone_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">Role</label>
                    <select wire:model.live='roleId' class="form-select @error('role_id') is-invalid @enderror">
                        <option value='' selected>Select a role...</option>
                        @if (!is_null($roles))
                            @foreach ($roles as $role)
                                <option wire:key='{{ $role->id }}' value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('role_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if ((!is_null($roleId) && $roleId == 1) || (!is_null($roleId) && $roleId == 2))
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <select wire:model.live='provinceId' class="form-select @error('province_id') is-invalid @enderror">
                            <option value='' selected>Select a province...</option>
                            @if (!is_null($provinces))
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('province_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kabupaten/Kota</label>
                        <select wire:model.live='regencyId' class="form-select @error('regency_id') is-invalid @enderror">
                            <option value='' selected>Select a regency...</option>
                            @if (!is_null($regencies))
                                @foreach ($regencies as $regency)
                                    <option value="{{ $regency->id }}">
                                        {{ $regency->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('regency_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <select wire:model.live='districtId' class="form-select @error('district_id') is-invalid @enderror">
                            <option value='' selected>Select a district...</option>
                            @if (!is_null($districts))
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('district_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelurahan/Desa</label>
                        <select wire:model.live='villageId' class="form-select @error('village_id') is-invalid @enderror">
                            <option value='' selected>Select a village...</option>
                            @if (!is_null($villages))
                                @foreach ($villages as $village)
                                    <option value="{{ $village->id }}">
                                        {{ $village->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('village_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
        </div>
        <div class="form-footer d-flex justify-content-between">
            <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('admin.management.user.index') }}"
                class="btn btn-danger me-auto">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>
