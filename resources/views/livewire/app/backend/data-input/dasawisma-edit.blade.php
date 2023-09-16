<form class="card" wire:submit="update" method="post" autocomplete="off">
    <div class="card-body">
        <h2 class="h2 text-center mb-4">Edit Dasawisma</h2>
        <div class="row mb-3">
            <label class="col-3 col-form-label required">Nama Dasawisma</label>
            <div class="col">
                <input type="text" wire:model='name' class="form-control @error('name') is-invalid @enderror" placeholder="Nama Dasawisma...">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-3 col-form-label">RT</label>
            <div class="col">
                <input type="number" wire:model='rt' class="form-control @error('rt') is-invalid @enderror" placeholder="RT...">
                @error('rt')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-3 col-form-label">RW</label>
            <div class="col">
                <input type="number" wire:model='rw' class="form-control @error('rw') is-invalid @enderror" placeholder="RW...">
                @error('rw')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-3 col-form-label">Provinsi</label>
            <div class="col">
                <select wire:model.live='provinceId' class="form-select @error('provinceId') is-invalid @enderror">
                    <option value='' selected>---Pilih Provinsi---</option>
                    @if (!is_null($provinces))
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">
                                {{ $province->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('provinceId')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-3 col-form-label">Kabupaten/Kota</label>
            <div class="col">
                <select wire:model.live='regencyId' class="form-select @error('regencyId') is-invalid @enderror">
                    <option value='' selected>---Pilih Kabupaten/Kota---</option>
                    @if (!is_null($regencies))
                        @foreach ($regencies as $regency)
                            <option value="{{ $regency->id }}">
                                {{ $regency->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('regencyId')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-3 col-form-label">Kecamatan</label>
            <div class="col">
                <select wire:model.live='districtId' class="form-select @error('districtId') is-invalid @enderror">
                    <option value='' selected>---Pilih Kecamatan---</option>
                    @if (!is_null($districts))
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">
                                {{ $district->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('districtId')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-3 col-form-label">Kelurahan/Desa</label>
            <div class="col">
                <select wire:model.live='villageId' class="form-select @error('villageId') is-invalid @enderror">
                    <option value='' selected>---Pilih Kelurahan/Desa---</option>
                    @if (!is_null($villages))
                        @foreach ($villages as $village)
                            <option value="{{ $village->id }}">
                                {{ $village->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('villageId')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-footer d-flex justify-content-between">
            <a wire:navigate href="{{ url()->previous() != url()->current() ? url()->previous() : route('admin.data_input.dasawisma.index') }}"
                class="btn btn-danger me-auto">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </div>
</form>
