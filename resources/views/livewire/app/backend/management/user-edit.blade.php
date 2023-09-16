<form class="card" wire:submit.prevent="update" method="post" autocomplete="off">
    <div class="card-body">
        <h2 class="h2 text-center mb-4">Edit User</h2>
        <div class="row">
            <div class="{{ $roleId == 1 || $roleId == 2 ? 'col-md-4' : 'col-md-6' }}">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-auto">
                            @if ($newProfilePicture)
                                <img class="avatar avatar-md" src="{{ $newProfilePicture->temporaryUrl() }}">
                            @else
                                <img class="avatar avatar-md"
                                    src="{{ !is_null($oldProfilePicture) ? asset('storage/images/profiles/' . $oldProfilePicture) : asset('src/img/auth/profile_default.png') }}">
                            @endif
                        </div>
                        <div class="col">
                            <label class="form-label">Ubah Foto Profil</label>
                            <input type="file" wire:model='newProfilePicture' class="form-control" accept=".png,.jpg,.jpeg,.svg,.gif" />
                        </div>
                    </div>
                    @error('new_image')
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
                    <label class="form-label">Password Lama</label>
                    <input type="password" wire:model='currentPassword' class="form-control @error('current_password') is-invalid @enderror"
                        placeholder="Password Lama...">
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" wire:model='newPassword' class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password Baru...">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">No. Telepon</label>
                    <input type="tel" wire:model='phoneNumber' class="form-control @error('phoneNumber') is-invalid @enderror"
                        placeholder="No. Telepon...">
                    @error('phoneNumber')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label required">Role</label>
                    <select wire:model.live='roleId' class="form-select @error('roleId') is-invalid @enderror">
                        <option value='' selected>Select a role...</option>
                        @if (!empty($roles))
                            @foreach ($roles as $role)
                                <option wire:key='{{ $role->id }}' value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('roleId')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if ($roleId == 1 || $roleId == 2)
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label required">Provinsi</label>
                        <select wire:model.live='provinceId' class="form-select @error('provinceId') is-invalid @enderror">
                            <option value='' selected>Select a province...</option>
                            @if (!empty($provinces))
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('provinceId')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kabupaten/Kota</label>
                        <select wire:model.live='regencyId' class="form-select @error('regencyId') is-invalid @enderror">
                            <option value='' selected>Select a regency...</option>
                            @if (!empty($regencies))
                                @foreach ($regencies as $regency)
                                    <option value="{{ $regency->id }}">{{ $regency->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('regencyId')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <select wire:model.live='districtId' class="form-select @error('districtId') is-invalid @enderror">
                            <option value='' selected>Select a district...</option>
                            @if (!empty($districts))
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('districtId')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelurahan/Desa</label>
                        <select wire:model.live='villageId' class="form-select @error('villageId') is-invalid @enderror">
                            <option value='' selected>Select a village...</option>
                            @if (!empty($villages))
                                @foreach ($villages as $village)
                                    <option value="{{ $village->id }}">{{ $village->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('villageId')
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
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </div>
</form>
