<div>
    <form class="card" wire:submit.prevent="update" method="post" autocomplete="off">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Edit Bangunan</h2>

            <div class="row mb-3">
                <div class="col-4">
                    <label class="form-label required">Dasawisma</label>
                    <div>
                        <select wire:model='dasawismaId' class="form-select @error('dasawisma_id') is-invalid @enderror">
                            <option value='' selected>---Pilih Dasawisma---</option>
                            @isset($dasawismas)
                                @foreach ($dasawismas as $dasawisma)
                                    <option value="{{ $dasawisma->id }}">
                                        {{ $dasawisma->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('dasawisma_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <label class="form-label required">No. KK</label>
                    <div>
                        <input type="text" wire:model='kkNumber' class="form-control @error('kk_number') is-invalid @enderror"
                            placeholder="No. KK...">
                        @error('kk_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <label class="form-label required">Nama Kepala Keluarga</label>
                    <div>
                        <input type="text" wire:model='kkHead' class="form-control @error('kk_head') is-invalid @enderror"
                            placeholder="Nama Kepala Keluarga...">
                        @error('kk_head')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label pt-0 required">Sumber Air Keluarga</label>
                    <div class="col d-flex flex-row justify-content-between">
                        <label class="form-check" role="button">
                            <input type="checkbox" wire:model='waterSrc' class="form-check-input" value="PDAM" role="button"
                                @checked(isset($waterSrc[0]))>
                            <span class="form-check-label text-muted">PDAM</span>
                        </label>
                        <label class="form-check" role="button">
                            <input type="checkbox" wire:model='waterSrc' class="form-check-input" value="Sumur" role="button"
                                @checked(isset($waterSrc[1]))>
                            <span class="form-check-label text-muted">Sumur</span>
                        </label>
                        <label class="form-check" role="button">
                            <input type="checkbox" wire:model='waterSrc' class="form-check-input" value="Sungai" role="button"
                                @checked(isset($waterSrc[2]))>
                            <span class="form-check-label text-muted">Sungai</span>
                        </label>
                        <label class="form-check" role="button">
                            <input type="checkbox" wire:model='waterSrc' class="form-check-input" value="Lainnya" role="button"
                                @checked(isset($waterSrc[3]))>
                            <span class="form-check-label text-muted">Lainnya</span>
                        </label>
                    </div>
                    @error('water_src')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 mb-3">
                <div class="col">
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Makanan Pokok</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="staple_food" wire:model="stapleFood" class="form-check-input" value="Beras"
                                    role="button">
                                <span class="form-check-label text-muted">Beras</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="staple_food" wire:model="stapleFood" class="form-check-input" value="Non Beras"
                                    role="button">
                                <span class="form-check-label text-muted">Non Beras</span>
                            </label>
                        </div>
                        @error('staple_food')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Mempunyai Jamban</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_toilet" wire:model="haveToilet" class="form-check-input" value="1"
                                    role="button">
                                <span class="form-check-label text-muted">Ya</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_toilet" wire:model="haveToilet" class="form-check-input" value="0"
                                    role="button">
                                <span class="form-check-label text-muted">Tidak</span>
                            </label>
                        </div>
                        @error('have_toilet')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Mempunyai Tempat Pembuangan Sampah</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_landfill" wire:model="haveLandfill" class="form-check-input" value="1"
                                    role="button">
                                <span class="form-check-label text-muted">Ya</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_landfill" wire:model="haveLandfill" class="form-check-input" value="0"
                                    role="button">
                                <span class="form-check-label text-muted">Tidak</span>
                            </label>
                        </div>
                        @error('have_landfill')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Mempunyai Saluran Pembuangan Air Limbah</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_sewerage" wire:model="haveSewerage" class="form-check-input" value="1"
                                    role="button">
                                <span class="form-check-label text-muted">Ya</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="have_sewerage" wire:model="haveSewerage" class="form-check-input" value="0"
                                    role="button">
                                <span class="form-check-label text-muted">Tidak</span>
                            </label>
                        </div>
                        @error('have_sewerage')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Menempel Stiker P4K</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="pasting_p4k_sticker" wire:model="pastingP4kSticker" class="form-check-input"
                                    value="1" role="button">
                                <span class="form-check-label text-muted">Ya</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="pasting_p4k_sticker" wire:model="pastingP4kSticker" class="form-check-input"
                                    value="0" role="button">
                                <span class="form-check-label text-muted">Tidak</span>
                            </label>
                        </div>
                        @error('pasting_p4k_sticker')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <label class="form-label pt-0 required">Kriteria Rumah</label>
                        <div>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="house_criteria" wire:model="houseCriteria" class="form-check-input"
                                    value="Sehat" role="button">
                                <span class="form-check-label text-muted">Sehat</span>
                            </label>
                            <label class="form-check form-check-inline" role="button">
                                <input type="radio" name="house_criteria" wire:model="houseCriteria" class="form-check-input"
                                    value="Kurang Sehat" role="button">
                                <span class="form-check-label text-muted">Kurang Sehat</span>
                            </label>
                        </div>
                        @error('house_criteria')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-footer d-flex justify-content-between">
                <a wire:navigate href="{{ route('admin.data_input.member.index') }}" class="btn btn-secondary me-auto">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
